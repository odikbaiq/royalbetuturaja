<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = \App\Models\User::paginate(10);
        return view('admin.user.index', compact('users'));
    }


}
