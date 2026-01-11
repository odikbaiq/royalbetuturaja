<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request) {
        $category = $request->get('category');
        $menus = Menu::when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })->paginate(10);
        return view('admin.menu.index', compact('menus', 'category'));
    }

    public function create() {
        return view('admin.menu.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required|in:Makanan,Minuman',
            'price' => 'required|numeric',
            'image' => 'required|image|max:2048',
            'is_available' => 'nullable|boolean',
            'is_best' => 'nullable|boolean'
        ]);

        $data['image'] = $request->file('image')->store('menus', 'public');
        $data['is_available'] = $request->has('is_available');
        $data['is_best'] = $request->has('is_best');
        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu baru ditambahkan.');
    }

    public function show(Menu $menu) {
        return view('admin.menu.show', compact('menu'));
    }

    public function edit(Menu $menu) {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu) {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required|in:Makanan,Minuman',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'nullable|boolean',
            'is_best' => 'nullable|boolean'
        ]);

        if ($request->hasFile('image')) {
            if($menu->image) Storage::disk('public')->delete($menu->image);
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $data['is_available'] = $request->has('is_available');
        $data['is_best'] = $request->has('is_best');

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu) {
        if($menu->image) Storage::disk('public')->delete($menu->image);
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus.');
    }
}
