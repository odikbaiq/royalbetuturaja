<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(){
        return view('public.services.index');
    }

    public function galaDinner(){
        return view('public.services.galadinner');
    }

    public function tour(){
        return view('public.services.toursejarah');
    }

    public function cookingClass(){
        return view('public.services.cookingclass');
    }
}
