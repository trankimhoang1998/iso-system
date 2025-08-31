<?php

namespace App\Http\Controllers\Level3;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Proposal;
use App\Models\DocumentPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Proposal::where('user_id', $user->id)
            ->with(['document', 'user']);

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

        $proposals = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get available documents for create modal
        $availableDocuments = Document::whereHas('permissions', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('can_view', true);
        })->get();

        // Get Level 2 users to submit proposals to
        $level2Users = User::where('role', 2)->get();

        return view('level3.proposals', compact('proposals', 'availableDocuments', 'level2Users'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'level2_user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'proposal_type' => 'required|in:content_correction,format_improvement,additional_info,process_optimization,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'description' => 'required|string',
            'proposed_content' => 'nullable|string',
            'reason' => 'nullable|string'
        ]);

        // Check if the selected user is actually Level 2
        $level2User = User::where('id', $request->level2_user_id)
            ->where('role', 2)
            ->first();
            
        if (!$level2User) {
            return back()->with('error', 'Người nhận đề xuất không hợp lệ');
        }

        // Check if user has permission to access this document
        $hasPermission = DocumentPermission::where('document_id', $request->document_id)
            ->where('user_id', $user->id)
            ->where('can_view', true)
            ->exists();

        if (!$hasPermission) {
            return back()->with('error', 'Bạn không có quyền tạo đề xuất cho tài liệu này');
        }

        Proposal::create([
            'user_id' => $user->id,
            'document_id' => $request->document_id,
            'level2_user_id' => $request->level2_user_id, // Level 3 proposals go to Level 2
            'title' => $request->title,
            'proposal_type' => $request->proposal_type,
            'priority' => $request->priority,
            'description' => $request->description,
            'proposed_content' => $request->proposed_content,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return redirect()->route('level3.proposals')->with('success', 'Đề xuất đã được gửi đến cấp 2 thành công');
    }

    public function show(Proposal $proposal)
    {
        // Ensure user can only view their own proposals
        if ($proposal->user_id !== Auth::id()) {
            abort(403);
        }

        $proposal->load(['document', 'user']);
        
        return view('level3.proposal-detail', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        // Ensure user can only edit their own proposals and only if pending
        if ($proposal->user_id !== Auth::id() || $proposal->status !== 'pending') {
            abort(403);
        }

        $availableDocuments = Document::whereHas('permissions', function ($q) {
            $q->where('user_id', Auth::id())
              ->where('can_view', true);
        })->get();

        $level2Users = User::where('role', 2)->get();

        return view('level3.proposal-edit', compact('proposal', 'availableDocuments', 'level2Users'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        // Ensure user can only update their own proposals and only if pending
        if ($proposal->user_id !== Auth::id() || $proposal->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'level2_user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'proposal_type' => 'required|in:content_correction,format_improvement,additional_info,process_optimization,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'description' => 'required|string',
            'proposed_content' => 'nullable|string',
            'reason' => 'nullable|string'
        ]);

        // Check if the selected user is actually Level 2
        $level2User = User::where('id', $request->level2_user_id)
            ->where('role', 2)
            ->first();
            
        if (!$level2User) {
            return back()->with('error', 'Người nhận đề xuất không hợp lệ');
        }

        // Check if user has permission to access this document
        $hasPermission = DocumentPermission::where('document_id', $request->document_id)
            ->where('user_id', Auth::id())
            ->where('can_view', true)
            ->exists();

        if (!$hasPermission) {
            return back()->with('error', 'Bạn không có quyền tạo đề xuất cho tài liệu này');
        }

        $proposal->update([
            'document_id' => $request->document_id,
            'level2_user_id' => $request->level2_user_id,
            'title' => $request->title,
            'proposal_type' => $request->proposal_type,
            'priority' => $request->priority,
            'description' => $request->description,
            'proposed_content' => $request->proposed_content,
            'reason' => $request->reason
        ]);

        return redirect()->route('level3.proposals')->with('success', 'Đề xuất đã được cập nhật thành công');
    }

    public function destroy(Proposal $proposal)
    {
        // Ensure user can only delete their own proposals and only if pending
        if ($proposal->user_id !== Auth::id() || $proposal->status !== 'pending') {
            abort(403);
        }

        $proposal->delete();

        return redirect()->route('level3.proposals')->with('success', 'Đề xuất đã được xóa thành công');
    }
}