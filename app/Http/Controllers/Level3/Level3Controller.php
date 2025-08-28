<?php

namespace App\Http\Controllers\Level3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Level3Controller extends Controller
{
    /**
     * Show level 3 dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'available_documents' => 0, // TODO: implement documents
            'pending_proposals' => 0, // TODO: implement proposals
        ];

        return view('level3.dashboard', compact('stats'));
    }

    /**
     * Show documents page
     */
    public function documents()
    {
        return view('level3.documents');
    }

    /**
     * Show proposals page
     */
    public function proposals()
    {
        return view('level3.proposals');
    }
}