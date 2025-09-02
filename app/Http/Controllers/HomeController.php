<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Display home page for authenticated users (any role can access)
        if (Auth::check()) {
            return view('home');
        }
        
        // If not logged in, redirect to login
        return redirect()->route('home');
    }
}
