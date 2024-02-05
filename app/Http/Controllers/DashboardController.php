<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Translation\t;

class DashboardController extends Controller
{

    public function index()
    {
        try {
            if (Auth::user()->is_admin()) {
                return view('dashboard.admin');
            } else {
                return view('dashboard.employee');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('status-error', 'Sorry, an error occurred ('.$exception->getCode().')');
        }
    }
}
