<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    public function index(Request $request) {
        $category = $request->get('category');
        $galleries = Gallery::when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.galeri.index', compact('galleries', 'category'));
    }

    public function create() {
        return view('admin.galeri.create');
    }

    public function store(Request $request) {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|in:Gala Dinner,Cooking Class,Tour Sejarah',
                'image' => 'required|array|min:1|max:20',
                'image.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                'description' => 'nullable|string'
            ]);

            $images = $request->file('image');
            $uploadedCount = 0;
            foreach ($images as $file) {
                $path = $file->store('gallery', 'public');
                if (!$path) {
                    return back()->withErrors(['image' => 'Gagal mengupload salah satu gambar. Periksa izin folder storage.']);
                }

                // Resize image to 500x500
                try {
                    $imagePath = storage_path('app/public/' . $path);
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($imagePath);
                    $image->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $image->save($imagePath);
                } catch (\Exception $e) {
                    // If resizing fails, continue without resizing
                    // Log the error if needed
                }

                Gallery::create([
                    'title' => $data['title'],
                    'category' => $data['category'],
                    'image' => $path,
                    'description' => $data['description']
                ]);
                $uploadedCount++;
            }

            return redirect()->route('admin.gallery.index')->with('success', $uploadedCount . ' galeri baru ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan galeri: ' . $e->getMessage()]);
        }
    }

    public function edit(Gallery $gallery) {
        return view('admin.galeri.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Gala Dinner,Cooking Class,Tour Sejarah',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            if($gallery->image) Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');

            try {
                $imagePath = storage_path('app/public/' . $data['image']);
                $manager = new ImageManager(new Driver());
                $image = $manager->read($imagePath);
                $image->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($imagePath);
            } catch (\Exception $e) {
                // If resizing fails, continue without resizing
            }
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery) {
        if($gallery->image) Storage::disk('public')->delete($gallery->image);
        $gallery->delete();
        return back()->with('success', 'Galeri berhasil dihapus.');
    }
}
