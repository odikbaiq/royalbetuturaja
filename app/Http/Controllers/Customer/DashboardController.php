<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }

            $reservations = Reservation::where('user_id', $user->id)->with('payment')->latest()->get();

            $totalReservations = $reservations->count();

            // Count completed reservations (where payment is successful)
            $confirmedCount = $reservations->filter(function($res) {
                return $res->status === 'completed';
            })->count();

            // Count reservations waiting for payment
            $waitingPaymentCount = $reservations->filter(function($res) {
                return $res->status === 'waiting_payment';
            })->count();

            // Calculate total spent from completed reservations
            $totalSpent = $reservations->where('status', 'completed')->sum('total_price') ?? 0;

            $latestReservation = $reservations->first();

            return view('customer.dashboard', compact(
                'reservations',
                'totalReservations',
                'confirmedCount',
                'waitingPaymentCount',
                'totalSpent',
                'latestReservation'
            ));
        } catch (\Exception $e) {
            // Log the error and return with default values
            Log::error('Customer Dashboard Error: ' . $e->getMessage());

            return view('customer.dashboard', [
                'reservations' => collect(),
                'totalReservations' => 0,
                'confirmedCount' => 0,
                'waitingPaymentCount' => 0,
                'totalSpent' => 0,
                'latestReservation' => null,
            ])->with('error', 'Terjadi kesalahan saat memuat data dashboard.');
        }
    }
}
