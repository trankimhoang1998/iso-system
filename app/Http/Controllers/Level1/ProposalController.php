<?php

namespace App\Http\Controllers\Level1;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $query = Proposal::with(['document', 'user'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('proposal_type')) {
            $query->where('proposal_type', $request->proposal_type);
        }

        $proposals = $query->paginate(20);

        return view('level1.proposals', compact('proposals'));
    }

    public function show(Proposal $proposal)
    {
        $proposal->load(['document', 'user', 'responder']);
        
        return view('level1.proposal-detail', compact('proposal'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,implemented',
            'response' => 'required|string|max:2000'
        ]);

        // Only allow status transitions that make sense
        if ($proposal->status === 'implemented') {
            return back()->with('error', 'Không thể thay đổi trạng thái của đề xuất đã hoàn thành');
        }

        if ($request->status === 'implemented' && $proposal->status !== 'approved') {
            return back()->with('error', 'Chỉ có thể đánh dấu "Đã thực hiện" cho đề xuất đã được chấp nhận');
        }

        $proposal->update([
            'status' => $request->status,
            'response' => $request->response,
            'responded_by' => Auth::id(),
            'responded_at' => now()
        ]);

        $statusNames = [
            'approved' => 'chấp nhận',
            'rejected' => 'từ chối',
            'implemented' => 'đánh dấu đã thực hiện'
        ];

        return redirect()->route('level1.proposals')
            ->with('success', "Đã {$statusNames[$request->status]} đề xuất thành công");
    }
}