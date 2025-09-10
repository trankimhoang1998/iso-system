<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Notification;
use App\Models\NewProcess;

class HomeController extends Controller
{
    public function index()
    {
        // Display home page for authenticated users (any role can access)
        if (Auth::check()) {
            // Get all departments for process search dropdown
            $departments = Department::orderBy('id')->get();
            
            // Get latest 4 notifications
            $notifications = Notification::orderBy('display_order')
                ->orderBy('issue_date', 'desc')
                ->limit(4)
                ->get();
            
            // Get latest 4 new processes
            $newProcesses = NewProcess::orderBy('display_order')
                ->orderBy('issue_date', 'desc')
                ->limit(4)
                ->get();
            
            return view('home', compact('departments', 'notifications', 'newProcesses'));
        }
        
        // If not logged in, redirect to login
        return redirect()->route('login');
    }
}
