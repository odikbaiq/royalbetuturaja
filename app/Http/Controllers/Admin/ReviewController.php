<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Menampilkan daftar semua ulasan untuk admin
     */
    public function index()
    {
        $reviews = Review::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Menyetujui ulasan (membuat visible)
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);

        $review->update(['is_visible' => true, 'status' => 'approved']);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Ulasan berhasil disetujui.');
    }

    /**
     * Menghapus ulasan
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
