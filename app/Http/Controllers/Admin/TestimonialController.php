<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Menampilkan daftar semua testimoni untuk admin
     */
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'reservation'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.testimoni.index', compact('testimonials'));
    }

    /**
     * Menyetujui testimoni
     */
    public function approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $testimonial->update(['is_approved' => true]);

        return redirect()->route('admin.testimoni.index')
            ->with('success', 'Testimoni berhasil disetujui.');
    }

    /**
     * Menghapus testimoni
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $testimonial->delete();

        return redirect()->route('admin.testimoni.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }
}
