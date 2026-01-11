<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Reservation;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Menampilkan daftar testimoni milik customer
     */
    public function index()
    {
        $testimonials = Auth::user()->testimonials()
            ->with('reservation')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.testimoni.index', compact('testimonials'));
    }

    /**
     * Menampilkan form untuk membuat testimoni baru
     */
    public function create(Reservation $reservation)
    {
        // Cek apakah reservasi valid dan milik user
        if ($reservation->user_id !== Auth::id() || $reservation->status !== 'diterima') {
            return redirect()->route('customer.reservation.index')
                ->with('error', 'Reservasi tidak valid atau belum diterima.');
        }

        if (!$reservation) {
            return redirect()->route('customer.reservation.index')
                ->with('error', 'Reservasi tidak valid atau belum diterima.');
        }

        // Cek apakah sudah ada testimoni untuk reservasi ini
        $existingTestimonial = Testimonial::where('reservation_id', $reservation->id)->first();
        if ($existingTestimonial) {
            return redirect()->route('customer.testimoni.index')
                ->with('error', 'Anda sudah memberikan testimoni untuk reservasi ini.');
        }

        return view('customer.testimoni.create', compact('reservation'));
    }

    /**
     * Menyimpan testimoni baru
     */
    public function store(TestimonialRequest $request)
    {
        // Validasi tambahan: cek reservasi milik user dan status diterima
        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('user_id', Auth::id())
            ->where('status', 'diterima')
            ->first();

        if (!$reservation) {
            return redirect()->route('customer.reservation.index')
                ->with('error', 'Reservasi tidak valid.');
        }

        // Cek apakah sudah ada testimoni
        $existingTestimonial = Testimonial::where('reservation_id', $request->reservation_id)->first();
        if ($existingTestimonial) {
            return redirect()->route('customer.testimoni.index')
                ->with('error', 'Testimoni untuk reservasi ini sudah ada.');
        }

        // Simpan testimoni
        Testimonial::create([
            'user_id' => Auth::id(),
            'reservation_id' => $request->reservation_id,
            'rating' => $request->rating,
            'message' => $request->message,
            'is_approved' => false, // Default false, perlu approval admin
        ]);

        return redirect()->route('customer.testimoni.index')
            ->with('success', 'Testimoni berhasil dikirim dan menunggu persetujuan admin.');
    }
}
