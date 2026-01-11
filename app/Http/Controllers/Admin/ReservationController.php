<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Notifications\ReservationApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'payment']);

        // Filter berdasarkan status menggunakan when()
        $query->when($request->filled('status'), function ($q) use ($request) {
            return $q->where('status', $request->status);
        }, function ($q) {
            // Jika tidak ada filter status, tampilkan semua status aktif
            return $q->whereIn('status', ['pending', 'waiting_payment', 'success', 'cancelled']);
        });

        // Filter berdasarkan tanggal menggunakan when()
        $query->when($request->filled('date'), function ($q) use ($request) {
            return $q->whereDate('date', $request->date);
        });

        // Pagination dengan 15 data per halaman
        $activeReservations = $query->latest()->paginate(15);

        return view('admin.reservation.index', compact('activeReservations'));
    }

    public function approve(Request $request, $id)
    {
        try {
            $reservation = Reservation::with('user')->findOrFail($id);

            // Validasi status
            if ($reservation->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi sudah tidak dalam status pending.'
                ], 400);
            }

            // Update status ke waiting_payment agar muncul di daftar tagihan customer
            $reservation->status = 'waiting_payment';

            // Jika Admin menginput harga khusus (opsional)
            if ($request->has('total_price')) {
                $reservation->total_price = $request->total_price;
            }

            $reservation->save();

            // KIRIM NOTIFIKASI (Dibungkus try-catch agar jika email gagal, database tidak rollback)
            try {
                if ($reservation->user) {
                    $reservation->user->notify(new ReservationApprovedNotification($reservation));
                }
            } catch (\Exception $e) {
                Log::error('Gagal kirim email: ' . $e->getMessage());
                // Jangan return error di sini, agar status database tetap tersimpan
            }

            // RETURN JSON UNTUK SWEETALERT
            return response()->json([
                'success' => true,
                'message' => 'Reservasi #' . $reservation->code . ' berhasil disetujui. Tagihan telah dikirim ke pelanggan.',
                'redirect' => route('admin.reservation.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Error Approve: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            if ($reservation->status !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Hanya reservasi pending yang bisa ditolak.'], 400);
            }

            $reservation->update(['status' => 'cancelled']);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reservasi #' . $reservation->code . ' telah dibatalkan.'
                ]);
            }

            return back()->with('success', 'Reservasi dibatalkan.');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memproses.'], 500);
        }
    }

    public function completeReservation($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->update(['status' => 'completed']);

            return response()->json([
                'success' => true,
                'message' => 'Layanan telah selesai dan reservasi ditutup.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyelesaikan.'], 500);
        }
    }

    // Fungsi tambahan untuk menangani show, calendar, dsb tetap sama
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'payment']);
        return view('admin.reservation.show', compact('reservation'));
    }

    public function calendar()
    {
        $reservations = Reservation::all();
        return view('admin.reservation.calendar', compact('reservations'));
    }
}
