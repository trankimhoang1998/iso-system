<?php

namespace App\Http\Controllers\Level2;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Level2Controller extends Controller
{
    /**
     * Show level 2 dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'level3_users' => User::where('role', User::ROLE_LEVEL3)
                                 ->where('parent_id', $user->id)
                                 ->where('is_active', true)
                                 ->count(),
            'pending_proposals' => 0, // TODO: implement proposals
        ];

        return view('level2.dashboard', compact('stats'));
    }

    /**
     * Show documents page
     */
    public function documents()
    {
        return view('level2.documents');
    }

    /**
     * Show proposals page
     */
    public function proposals()
    {
        return view('level2.proposals');
    }
}