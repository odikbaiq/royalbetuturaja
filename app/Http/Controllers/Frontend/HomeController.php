<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Gallery;
use App\Models\Reservation;
use App\Models\Testimonial;
use App\Models\Review;
use App\Models\Service;
use Carbon\Carbon;




class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)->take(4)->get();
        $galleries = Gallery::latest()->take(6)->get();

        // Menu section
        $makanan = Menu::where('category', 'Makanan')->where('is_available', true)->where('is_best', true)->take(3)->get();
        $minuman = Menu::where('category', 'Minuman')->where('is_available', true)->where('is_best', true)->take(3)->get();

        // Reservations
        $bookedEvents = Reservation::select(['service_type', 'date'])
            ->whereIn('status', ['success', 'approved', 'lunas'])
            ->where('date', '>=', Carbon::now('Asia/Makassar')->toDateString())
            ->get();

        $availability = $this->getServiceAvailability();

        // --- PERBAIKAN DI SINI ---
        // Gunakan take(3) agar tidak muncul berulang-ulang atau terlalu banyak
        $services = Service::take(3)->get();
        // -------------------------

        $reviews = Review::where('is_visible', true)
            ->where('status', 'approved')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('public.home', compact('menus', 'galleries', 'bookedEvents', 'reviews', 'makanan', 'minuman', 'availability', 'services'));
    }

    private function getServiceAvailability()
    {
        $serviceTypes = ['Gala Dinner', 'Cooking Class', 'Tour Sejarah'];
        $availability = [];
        $maxGuests = 15; // Maximum 15 guests per day per service

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now('Asia/Makassar')->addDays($i)->toDateString();
            $formattedDate = Carbon::now('Asia/Makassar')->addDays($i)->format('d M Y');

            foreach ($serviceTypes as $serviceType) {
                $bookedGuests = Reservation::where('date', $date)
                    ->where('service_type', $serviceType)
                    ->whereIn('status', ['Paid', 'Confirmed'])
                    ->sum('guests');

                $isAvailable = $bookedGuests < $maxGuests;
                $availability[$serviceType][$formattedDate] = [
                    'available' => $isAvailable,
                    'booked' => $bookedGuests,
                    'remaining' => $maxGuests - $bookedGuests
                ];
            }
        }

        return $availability;
    }
}
