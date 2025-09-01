<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect all authenticated users to admin dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        // If not logged in, redirect to login
        return redirect()->route('home');
    }
}
