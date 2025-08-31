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
        
        // Get available documents count (documents user has permission to view)
        $availableDocuments = \App\Models\Document::whereHas('permissions', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('can_view', true);
        })->count();
        
        // Get pending proposals count (proposals submitted by this user)
        $pendingProposals = \App\Models\Proposal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
            
        // Get total proposals count
        $totalProposals = \App\Models\Proposal::where('user_id', $user->id)->count();
        
        $stats = [
            'available_documents' => $availableDocuments,
            'pending_proposals' => $pendingProposals,
            'total_proposals' => $totalProposals,
        ];

        return view('level3.dashboard', compact('stats'));
    }

}