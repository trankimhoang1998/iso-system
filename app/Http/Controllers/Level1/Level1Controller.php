<?php

namespace App\Http\Controllers\Level1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Level1Controller extends Controller
{
    /**
     * Show level 1 dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'level2_users' => User::where('role', User::ROLE_LEVEL2)
                                 ->where('is_active', true)
                                 ->count(),
            'level3_users' => User::where('role', User::ROLE_LEVEL3)
                                 ->where('is_active', true)
                                 ->count(),
        ];

        return view('level1.dashboard', compact('stats'));
    }

    /**
     * Show documents management page
     */
    public function documents()
    {
        return view('level1.documents');
    }
}