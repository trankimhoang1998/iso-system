<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\IsoSystemCategory;

class HomeController extends Controller
{
    public function index()
    {
        // Display home page for authenticated users (any role can access)
        if (Auth::check()) {
            // Get all departments for process search dropdown
            $departments = Department::orderBy('name')->get();
            
            // Get category IDs for process types
            $heThongCategory = IsoSystemCategory::where('name', 'like', '%QUY TRÌNH HỆ THỐNG%')->first();
            $tacNghiepCategory = IsoSystemCategory::where('name', 'like', '%QUY TRÌNH TÁC NGHIỆP%')->first();
            
            $processCategories = [
                'he_thong_id' => $heThongCategory ? $heThongCategory->id : null,
                'tac_nghiep_id' => $tacNghiepCategory ? $tacNghiepCategory->id : null
            ];
            
            return view('home', compact('departments', 'processCategories'));
        }
        
        // If not logged in, redirect to login
        return redirect()->route('home');
    }
}
