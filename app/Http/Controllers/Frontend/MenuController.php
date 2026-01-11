<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('is_best', 'desc')->orderBy('name', 'asc')->get()->groupBy('category');
        return view('public.menu', compact('menus'));
    }
}
