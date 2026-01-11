<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Models\Menu;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->with('payment')->latest()->get();
        return view('customer.reservation.index', compact('reservations'));
    }

    public function create()
    {
        $bookedEvents = Reservation::whereIn('status', ['success', 'confirmed'])
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();

        return view('customer.reservation.create', compact('bookedEvents'));
    }

   public function store(ReservationRequest $request)
{
    $data = $request->validated();

    // Harga server-side yang aman
    $prices = [
        'Gala Dinner' => 500000,
        'Cooking Class' => 350000,
        'Tour Sejarah' => 100000,
    ];

    $pricePerGuest = $prices[$data['service_type']] ?? null;
    if ($pricePerGuest === null) {
        return back()->withInput()->withErrors(['service_type' => 'Jenis layanan tidak valid.']);
    }

    $total_price = $data['guests'] * $pricePerGuest;

    $reservation = Reservation::create([
        'user_id' => Auth::id(),
        'code' => 'RES-' . strtoupper(Str::random(6)),
        'date' => $data['date'],
        'time' => $data['time'],
        'guests' => $data['guests'],
        'service_type' => $data['service_type'],
        'notes' => $data['special_requests'] ?? null,
        'total_price' => $total_price,
        'status' => 'pending', // Default: tunggu approve admin
    ]);

    return redirect()->route('customer.reservation.index')
        ->with('success', 'Reservasi berhasil dibuat! Silakan tunggu konfirmasi admin untuk melakukan pembayaran.');
}

    public function show($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->with('payment')->firstOrFail();
        return view('customer.reservation.show', compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // Hanya bisa edit jika pending
        if ($reservation->status !== 'pending') {
            return redirect()->route('customer.reservation.index')->with('error', 'Reservasi tidak dapat diedit.');
        }
        return view('customer.reservation.edit', compact('reservation'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if ($reservation->status !== 'pending') {
            return redirect()->route('customer.reservation.index')->with('error', 'Reservasi tidak dapat diupdate.');
        }

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'service_type' => 'required|string|in:Gala Dinner,Cooking Class,Tour Sejarah',
            'special_requests' => 'nullable|string|max:500'
        ]);

        // Cek ketersediaan, exclude current reservation
        $existing = Reservation::where('date', $request->date)
            ->where('time', $request->time)
            ->where('service_type', $request->service_type)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('id', '!=', $id)
            ->exists();

        if ($existing) {
            return back()->withErrors(['date' => 'Jadwal sudah penuh untuk tanggal dan waktu tersebut.'])->withInput();
        }

        // Dynamic pricing based on service_type
        $price_per_guest = match ($request->service_type) {
            'Gala Dinner' => 500000,
            'Cooking Class' => 350000,
            'Tour Sejarah' => 100000,
            default => throw new \Exception('Jenis layanan tidak valid'),
        };
        $total_price = $request->guests * $price_per_guest;

        $reservation->update([
            'date' => $request->date,
            'time' => $request->time,
            'guests' => $request->guests,
            'service_type' => $request->service_type,
            'notes' => $request->special_requests,
            'total_price' => $total_price
        ]);

        return redirect()->route('customer.reservation.index')->with('success', 'Reservasi berhasil diupdate.');
    }

    public function calendar()
    {
        // Ambil semua reservasi yang completed untuk ditampilkan di kalender
        $reservations = Reservation::where('status', 'completed')->get();
        return view('customer.reservation.calendar', compact('reservations'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // Hanya bisa batalkan jika status pending
        if ($reservation->status === 'pending') {
            $reservation->delete(); // Soft delete
            return redirect()->route('customer.reservation.index')->with('success', 'Reservasi berhasil dibatalkan.');
        }
        return redirect()->route('customer.reservation.index')->with('error', 'Reservasi tidak dapat dibatalkan.');
    }

    public function uploadBukti(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($reservation->status !== 'approved') {
            return redirect()->route('customer.reservation.index')->with('error', 'Tidak dapat upload bukti untuk reservasi ini.');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            $reservation->update([
                'bukti_pembayaran' => $path,
                'status' => 'lunas',
            ]);

            return redirect()->route('customer.reservation.index')->with('success', 'Bukti pembayaran berhasil diupload. Menunggu validasi admin.');
        }

        return redirect()->route('customer.reservation.index')->with('error', 'Gagal upload bukti pembayaran.');
    }

    public function downloadTicket($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Hanya bisa download jika status success
        if ($reservation->status !== 'success') {
            return redirect()->route('customer.reservation.index')->with('error', 'E-Tiket hanya tersedia setelah pembayaran berhasil.');
        }

        // Generate PDF ticket
        $pdf = Pdf::loadView('customer.reservation.ticket_pdf', compact('reservation'));
        $pdf->setPaper('a6', 'portrait');

        return $pdf->download('E-Tiket_' . $reservation->code . '.pdf');
    }

    public function viewTicket($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Hanya bisa lihat e-tiket jika status success
        if ($reservation->status !== 'success') {
            return redirect()->route('customer.reservation.index')->with('error', 'E-Tiket belum tersedia.');
        }

        return view('customer.reservation.ticket_layout', compact('reservation'));
    }

    public function payment($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Hanya bisa bayar jika status approved
        if ($reservation->status !== 'approved') {
            return redirect()->route('customer.reservation.index')->with('error', 'Reservasi belum disetujui untuk pembayaran.');
        }

        // Jika sudah ada snap_token, gunakan yang ada untuk menghindari duplikasi
        if ($reservation->snap_token) {
            return view('customer.reservation.pay', compact('reservation'));
        }

        try {
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.serverKey');
            Config::$clientKey = config('midtrans.clientKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');

            $order_id = $reservation->code . '-' . time();

            $transaction = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => (int) $reservation->total_price,
                ],
                'customer_details' => [
                    'first_name' => $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Unknown'),
                    'email' => $reservation->user ? $reservation->user->email : ($reservation->email ?? 'unknown@example.com'),
                ],
                'item_details' => [
                    [
                        'id' => $reservation->id,
                        'price' => (int) $reservation->total_price,
                        'quantity' => 1,
                        'name' => 'Reservasi ' . $reservation->service_type,
                    ],
                ],
            ];

            $snapToken = Snap::getSnapToken($transaction);

            // Simpan snap_token ke reservation
            $reservation->update(['snap_token' => $snapToken]);

            return view('customer.reservation.pay', compact('reservation'));
        } catch (\Exception $e) {
            Log::error('Midtrans Payment Error: ' . $e->getMessage());
            return redirect()->route('customer.reservation.index')->with('error', 'Gagal memuat sistem pembayaran.');
        }
    }

    public function getStatuses()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->select('id', 'status')
            ->get()
            ->pluck('status', 'id');

        return response()->json($reservations);
    }


}
