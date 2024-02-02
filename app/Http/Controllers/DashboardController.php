<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        if (Auth::user()->is_admin()){
            return view('dashboard.admin');
        }else{
            return view('dashboard.employee');
        }
    }
}
