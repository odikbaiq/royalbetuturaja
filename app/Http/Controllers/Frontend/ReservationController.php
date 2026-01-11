<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('customer.reservation.create');
        } else {
            return redirect()->route('login')->with('intended', route('customer.reservation.create'));
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'service_type' => 'required|in:Gala Dinner,Cooking Class,Tour Sejarah',
            'special_requests' => 'nullable|string|max:500',
        ]);

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
            'name' => $data['name'],
            'email' => $data['email'],
            'code' => 'RES-' . strtoupper(Str::random(6)),
            'date' => $data['date'],
            'time' => $data['time'],
            'guests' => $data['guests'],
            'service_type' => $data['service_type'],
            'notes' => $data['special_requests'] ?? null,
            'total_price' => $total_price,
            'status' => 'pending', // Default: tunggu approve admin
        ]);

        return redirect()->back()
            ->with('success', 'Reservasi berhasil dibuat! Silakan tunggu konfirmasi admin untuk melakukan pembayaran. Kode reservasi: ' . $reservation->code);
    }
}
