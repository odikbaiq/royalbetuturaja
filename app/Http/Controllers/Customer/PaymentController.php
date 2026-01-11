<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use App\Notifications\PaymentSuccessNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    /**
     * Helper untuk Update Status ke 'Lunas' setelah verifikasi Midtrans
     */
    private function markAsConfirmed(Reservation $reservation, $statusResponse)
    {
        // Pastikan status dari Midtrans benar-benar 'settlement'
        if (($statusResponse->transaction_status ?? null) !== 'settlement') {
            return;
        }

        $payment = $reservation->payment;
        if ($payment) {
            $wasNotPaid = !in_array($payment->status, ['paid', 'lunas']);

            // 1. Update Tabel Payment
            $payment->update([
                'status' => 'lunas',
                'verified' => 1,
                'va_number' => $statusResponse->va_numbers[0]->va_number ?? ($statusResponse->payment_code ?? null),
                'gateway_response' => json_encode($statusResponse),
            ]);

            // 2. Update Tabel Reservation (Status Akhir)
            if ($wasNotPaid) {
                // Generate ticket_code otomatis
                $ticketCode = 'TKT-' . strtoupper(Str::random(8));
                while (Reservation::where('ticket_code', $ticketCode)->exists()) {
                    $ticketCode = 'TKT-' . strtoupper(Str::random(8));
                }

                $reservation->update([
                    'status' => 'success',
                    'ticket_code' => $ticketCode
                ]);

                // 3. Kirim Notifikasi Sukses
                try {
                    Notification::send($reservation->user, new PaymentSuccessNotification($reservation));
                } catch (\Exception $e) {
                    Log::error('Notification Error: ' . $e->getMessage());
                }
            }
        }
    }

    private function checkAndUpdatePaymentStatus(Reservation $reservation)
    {
        try {
            Config::$serverKey = trim(config('midtrans.serverKey'));
            Config::$isProduction = config('midtrans.isProduction');

            $order_id = $reservation->payment ? $reservation->payment->transaction_id : $reservation->code;
            $statusResponse = (object) Transaction::status($order_id);

            if ($statusResponse) {
                $transactionStatus = $statusResponse->transaction_status;
                $fraudStatus = $statusResponse->fraud_status ?? null;

                // Hanya anggap sukses apabila status benar-benar 'settlement'
                if ($transactionStatus === 'settlement' && $fraudStatus != 'challenge') {
                    $this->markAsConfirmed($reservation, $statusResponse);
                }
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Status Check Error: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'waiting_payment', 'success'])
            ->with('payment')
            ->latest()
            ->get();

        foreach ($reservations as $reservation) {
            if ($reservation->payment && $reservation->status !== 'success') {
                $this->checkAndUpdatePaymentStatus($reservation);
            }
        }

        return view('customer.payment.index', compact('reservations'));
    }

    public function showPayPage(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) abort(403);

        // Hanya bisa lanjut ke pembayaran jika admin belum Approve
        if (strtolower($reservation->status) !== 'waiting_payment') {
            return redirect()->route('customer.payment.index')
                ->with('error', 'Reservasi harus disetujui admin sebelum melakukan pembayaran.');
        }

        // Check if total_price is set
        if (!$reservation->total_price || $reservation->total_price <= 0) {
            return redirect()->route('customer.payment.index')
                ->with('error', 'Harga belum ditentukan oleh admin. Silakan hubungi admin.');
        }

        return view('customer.payment.pay', compact('reservation'));
    }

    public function callback(Request $request)
    {
        try {
            $notification = json_decode($request->getContent());
            if (!$notification) {
                Log::warning('Midtrans Callback: Invalid JSON received');
                return response()->json(['status' => 'error'], 400);
            }

            // VERIFIKASI SIGNATURE KEY - KEAMANAN PENTING
            $serverKey = config('midtrans.serverKey');
            $signatureKey = hash('sha512', $notification->order_id . $notification->status_code . $notification->gross_amount . $serverKey);

            if ($signatureKey !== $notification->signature_key) {
                Log::error('Midtrans Callback: Invalid signature key', [
                    'order_id' => $notification->order_id,
                    'received_signature' => $notification->signature_key,
                    'calculated_signature' => $signatureKey
                ]);
                return response()->json(['status' => 'error'], 403);
            }

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status ?? null;

            Log::info('Midtrans Callback Received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            // Cari reservation berdasarkan code atau payment transaction_id
            $reservation = Reservation::where('code', $orderId)
                ->orWhereHas('payment', fn($q) => $q->where('transaction_id', $orderId))
                ->first();

            if (!$reservation) {
                Log::warning('Midtrans Callback: Reservation not found', ['order_id' => $orderId]);
                return response()->json(['status' => 'error'], 404);
            }

            // Hanya proses jika status settlement dan fraud status aman
            if ($transactionStatus === 'settlement' && $fraudStatus !== 'challenge') {
                // Generate ticket_code unik
                $ticketCode = 'TKT-' . strtoupper(Str::random(8));
                while (Reservation::where('ticket_code', $ticketCode)->exists()) {
                    $ticketCode = 'TKT-' . strtoupper(Str::random(8));
                }

                // Update reservation status ke success
                $reservation->update([
                    'status' => 'success',
                    'ticket_code' => $ticketCode
                ]);

                // Update payment record jika ada
                if ($reservation->payment) {
                    $reservation->payment->update([
                        'status' => 'lunas',
                        'verified' => 1,
                        'va_number' => $notification->va_numbers[0]->va_number ?? ($notification->payment_code ?? null),
                        'gateway_response' => json_encode($notification),
                    ]);
                }

                // Kirim notifikasi sukses pembayaran
                try {
                    Notification::send($reservation->user, new PaymentSuccessNotification($reservation));
                    Log::info('Payment success notification sent', ['reservation_id' => $reservation->id]);
                } catch (\Exception $e) {
                    Log::error('Notification Error: ' . $e->getMessage());
                }
            } elseif ($transactionStatus === 'pending') {
                // Update status ke waiting_payment jika masih pending
                if ($reservation->status === 'approved') {
                    $reservation->update(['status' => 'waiting_payment']);
                }
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                // Jika pembayaran gagal, kembalikan ke approved agar bisa bayar lagi
                if ($reservation->status === 'waiting_payment') {
                    $reservation->update(['status' => 'approved']);
                }
                Log::warning('Payment failed', [
                    'order_id' => $orderId,
                    'status' => $transactionStatus
                ]);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function process(Reservation $reservation)
    {
        try {
            // Validasi otorisasi
            if ($reservation->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }

            // Validasi status reservasi
            if ($reservation->status !== 'waiting_payment') {
                return response()->json(['error' => 'Reservation is not ready for payment. Status: ' . $reservation->status], 400);
            }

            // Validasi harga
            if (!$reservation->total_price || $reservation->total_price <= 0) {
                return response()->json(['error' => 'Invalid total price: ' . $reservation->total_price], 400);
            }

            // Jika sudah ada snap_token, gunakan itu
            if ($reservation->snap_token) {
                return response()->json(['snap_token' => $reservation->snap_token]);
            }

            // Konfigurasi Midtrans
            $serverKey = config('midtrans.serverKey');
            if (!$serverKey) {
                return response()->json(['error' => 'Midtrans server key not configured'], 500);
            }

            Config::$serverKey = trim($serverKey);
            Config::$isProduction = config('midtrans.isProduction', false);

            $order_id = $reservation->code;
            $gross_amount = (int) $reservation->total_price;

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $gross_amount,
                ],
                'customer_details' => [
                    'first_name' => $reservation->user->name ?? $reservation->name,
                    'email' => $reservation->user->email ?? $reservation->email,
                ],
                'item_details' => [
                    [
                        'id' => $reservation->id,
                        'price' => $gross_amount,
                        'quantity' => 1,
                        'name' => 'Reservasi ' . $reservation->service_type,
                    ],
                ],
                'finish_url' => route('customer.payment.index'),
            ];

            // Generate snap token
            $snap_token = Snap::getSnapToken($params);

            if (!$snap_token) {
                return response()->json(['error' => 'Failed to generate snap token from Midtrans'], 500);
            }

            // Simpan snap_token ke reservation dan payment
            $reservation->update(['snap_token' => $snap_token]);
            Payment::updateOrCreate(
                ['reservation_id' => $reservation->id],
                [
                    'amount' => $reservation->total_price,
                    'status' => 'pending',
                    'transaction_id' => $order_id,
                    'snap_token' => $snap_token,
                ]
            );

            return response()->json(['snap_token' => $snap_token]);
        } catch (\Exception $e) {
            Log::error('Midtrans Process Error: ' . $e->getMessage(), [
                'reservation_id' => $reservation->id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function pay(Reservation $reservation)
    {
        try {
            if ($reservation->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if ($reservation->status !== 'waiting_payment') {
                return response()->json(['error' => 'Reservasi belum siap untuk pembayaran'], 400);
            }

            if ($reservation->snap_token) {
                return response()->json(['snap_token' => $reservation->snap_token]);
            }

            // Konfigurasi Midtrans
            Config::$serverKey = trim(config('midtrans.serverKey'));
            Config::$clientKey = config('midtrans.clientKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $order_id = $reservation->code . '-' . time();

            $transaction = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => (int) $reservation->total_price,
                ],
                'customer_details' => [
                    'first_name' => $reservation->user->name ?? $reservation->name,
                    'email' => $reservation->user->email ?? $reservation->email,
                ],
                'item_details' => [
                    [
                        'id' => $reservation->id,
                        'price' => (int) $reservation->total_price,
                        'quantity' => 1,
                        'name' => 'Reservasi ' . $reservation->service_type,
                    ],
                ],
                'finish_url' => route('customer.payment.index'),
            ];

            $snapToken = Snap::getSnapToken($transaction);

            // Simpan snap_token ke reservation dan payment
            $reservation->update(['snap_token' => $snapToken]);
            Payment::updateOrCreate(
                ['reservation_id' => $reservation->id],
                [
                    'amount' => $reservation->total_price,
                    'status' => 'pending',
                    'transaction_id' => $order_id,
                    'snap_token' => $snapToken,
                ]
            );

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Pay Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat sistem pembayaran'], 500);
        }
    }

    public function downloadInvoice(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) abort(403);

        // Hanya bisa download jika status lunas
        if ($reservation->status !== 'lunas') {
            return redirect()->route('customer.reservation.index')->with('error', 'Invoice hanya tersedia setelah pembayaran lunas.');
        }

        // Generate PDF invoice
        $pdf = Pdf::loadView('customer.payment.invoice_pdf', compact('reservation'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Invoice_' . $reservation->code . '.pdf');
    }


    public function downloadTicket(Reservation $reservation)
{
    if ($reservation->user_id !== Auth::id()) abort(403);

    // Perbaikan: Invoice bisa didownload jika status 'success' (sudah lunas)
    if (!in_array($reservation->status, ['success', 'lunas'])) {
        return redirect()->route('customer.payment.index')
            ->with('error', 'Invoice hanya tersedia setelah pembayaran berhasil.');
    }

    $pdf = Pdf::loadView('customer.payment.invoice_pdf', compact('reservation'));
    return $pdf->download('Invoice_' . $reservation->code . '.pdf');
}

    public function testMidtrans()
    {
        try {
            // Konfigurasi Midtrans
            $serverKey = config('midtrans.serverKey');
            $clientKey = config('midtrans.clientKey');
            $merchantId = config('midtrans.merchantId');
            $isProduction = config('midtrans.isProduction', false);

            if (!$serverKey) {
                return response()->json(['error' => 'MIDTRANS_SERVER_KEY tidak dikonfigurasi di .env'], 500);
            }

            if (!$clientKey) {
                return response()->json(['error' => 'MIDTRANS_CLIENT_KEY tidak dikonfigurasi di .env'], 500);
            }

            // Set konfigurasi
            Config::$serverKey = trim($serverKey);
            Config::$clientKey = trim($clientKey);
            Config::$isProduction = $isProduction;

            // Test dengan dummy transaction
            $testParams = [
                'transaction_details' => [
                    'order_id' => 'TEST-' . time(),
                    'gross_amount' => 10000,
                ],
                'customer_details' => [
                    'first_name' => 'Test User',
                    'email' => 'test@example.com',
                ],
                'item_details' => [
                    [
                        'id' => 'test-item',
                        'price' => 10000,
                        'quantity' => 1,
                        'name' => 'Test Item',
                    ],
                ],
            ];

            $snapToken = Snap::getSnapToken($testParams);

            if ($snapToken) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Midtrans configuration is working correctly',
                    'server_key_prefix' => substr($serverKey, 0, 10) . '...',
                    'client_key_prefix' => substr($clientKey, 0, 15) . '...',
                    'is_production' => $isProduction,
                    'merchant_id' => $merchantId ? substr($merchantId, 0, 5) . '...' : null,
                    'test_snap_token_generated' => true
                ]);
            } else {
                return response()->json(['error' => 'Failed to generate test snap token'], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Midtrans Test Failed: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
