<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Review;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::approved()
            ->with(['user', 'reservation'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $reviews = Review::where('is_visible', true)
            ->where('status', 'approved')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // dd($reviews);

        return view('public.testimonial', compact('testimonials', 'reviews'));
    }
}
