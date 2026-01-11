<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){
        $galleries = Gallery::all();
        $menus = \App\Models\Menu::where('is_available', true)->get();
        return view('public.gallery', compact('galleries', 'menus'));
    }


}
