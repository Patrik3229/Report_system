<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->IsAdmin) {
            return view('admin-dashboard');
        } else {
            return view('user-dashboard');
        }
    }
}
