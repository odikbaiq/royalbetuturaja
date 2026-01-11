<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Initialize default values
        $totalReservations = 0;
        $reservationPercentage = 0;
        $confirmedReservations = 0;
        $todayReservations = 0;
        $totalCustomers = 0;
        $totalRevenue = 0;
        $reservationsByService = collect();
        $monthlyRevenue = collect();
        $latestReservations = collect();

        try {
            // Total reservations this month
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $totalReservations = Reservation::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count() ?? 0;

            // Last month reservations for percentage
            $lastMonth = Carbon::now()->subMonth()->month;
            $lastMonthYear = Carbon::now()->subMonth()->year;
            $lastMonthReservations = Reservation::whereMonth('created_at', $lastMonth)
                ->whereYear('created_at', $lastMonthYear)
                ->count() ?? 0;

            // Calculate percentage increase
            if ($lastMonthReservations > 0) {
                $reservationPercentage = (($totalReservations - $lastMonthReservations) / $lastMonthReservations) * 100;
            } else {
                $reservationPercentage = $totalReservations > 0 ? 100 : 0;
            }

            $confirmedReservations = Reservation::where('status', 'success')->count() ?? 0; // Assuming confirmed means success
            $todayReservations = Reservation::whereDate('created_at', today())->count() ?? 0;
            $totalCustomers = User::where('role', 'customer')->count() ?? 0;
            $totalRevenue = Reservation::whereIn('status', ['success', 'lunas'])->sum('total_price') ?? 0;

            // Data for charts
            $reservationsByService = Reservation::select('service_type', DB::raw('count(*) as count'))
                ->groupBy('service_type')
                ->get() ?? collect();

            $totalServices = $reservationsByService->sum('count');
            $reservationsByService = $reservationsByService->map(function ($item) use ($totalServices) {
                $item->percentage = $totalServices > 0 ? round(($item->count / $totalServices) * 100, 1) : 0;
                return $item;
            });

            $monthlyRevenue = Reservation::select(DB::raw("MONTH(created_at) as month"), DB::raw('SUM(total_price) as revenue'))
                ->whereIn('status', ['success', 'lunas'])
                ->where(DB::raw("YEAR(created_at)"), date('Y'))
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->orderBy(DB::raw("MONTH(created_at)"))
                ->get() ?? collect();

            $latestReservations = Reservation::with('user')->latest()->take(5)->get() ?? collect();

            return view('admin.dashboard', compact(
                'totalReservations',
                'reservationPercentage',
                'confirmedReservations',
                'todayReservations',
                'totalCustomers',
                'totalRevenue',
                'reservationsByService',
                'monthlyRevenue',
                'latestReservations'
            ));
        } catch (\Exception $e) {
            // Log the error and return with default values
            Log::error('Admin Dashboard Error: ' . $e->getMessage());

            return view('admin.dashboard', compact(
                'totalReservations',
                'reservationPercentage',
                'confirmedReservations',
                'todayReservations',
                'totalCustomers',
                'totalRevenue',
                'reservationsByService',
                'monthlyRevenue',
                'latestReservations'
            ))->with('error', 'Terjadi kesalahan saat memuat data dashboard.');
        }
    }

    public function financialReport()
    {
        $totalPendapatan = 0;
        $rataRata = 0;
        $monthlyData = collect();

        try {
            // Ambil data dari Reservation dengan status success atau lunas
            $reservations = Reservation::whereIn('status', ['success', 'lunas'])->get();

            // Hitung Total Pendapatan
            $totalPendapatan = $reservations->sum('total_price') ?? 0;

            // Hitung Rata-rata Bulanan (total / 12)
            $rataRata = $totalPendapatan > 0 ? $totalPendapatan / 12 : 0;

            // Kelompokkan pendapatan berdasarkan bulan
            $monthlyData = $reservations->groupBy(function($reservation) {
                return Carbon::parse($reservation->created_at)->format('m');
            })->map(function($group, $month) {
                return (object) [
                    'month' => (int) $month,
                    'revenue' => $group->sum('total_price')
                ];
            })->sortBy('month')->values();

            return view('admin.financial-report', compact('totalPendapatan', 'rataRata', 'monthlyData'));
        } catch (\Exception $e) {
            // Log the error and return with default values
            Log::error('Financial Report Error: ' . $e->getMessage());

            return view('admin.financial-report', compact('totalPendapatan', 'rataRata', 'monthlyData'))->with('error', 'Terjadi kesalahan saat memuat laporan keuangan.');
        }
    }
}
