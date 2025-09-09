<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;

class HomeController extends Controller
{
    public function index()
    {
        // Display home page for authenticated users (any role can access)
        if (Auth::check()) {
            // Get all departments for process search dropdown
            $departments = Department::orderBy('id')->get();
            return view('home', compact('departments'));
        }
        
        // If not logged in, redirect to login
        return redirect()->route('login');
    }
}
