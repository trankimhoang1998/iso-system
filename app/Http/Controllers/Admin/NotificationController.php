<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('display_order')->orderBy('issue_date', 'desc')->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'document_link' => 'required|url|max:255',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'issue_date.required' => 'Thời gian ban hành không được để trống',
            'issue_date.date' => 'Thời gian ban hành không hợp lệ',
            'document_link.required' => 'Link tài liệu không được để trống',
            'document_link.url' => 'Link tài liệu không hợp lệ',
            'document_link.max' => 'Link tài liệu không được vượt quá 255 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Push all existing notifications down by incrementing their display_order
        Notification::query()->increment('display_order');

        // Create new notification with display_order = 0 (top position)
        Notification::create([
            'title' => $request->title,
            'issue_date' => $request->issue_date,
            'document_link' => $request->document_link,
            'display_order' => 0,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Thông báo đã được tạo thành công');
    }

    public function edit(Notification $notification)
    {
        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'document_link' => 'required|url|max:255',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'issue_date.required' => 'Thời gian ban hành không được để trống',
            'issue_date.date' => 'Thời gian ban hành không hợp lệ',
            'document_link.required' => 'Link tài liệu không được để trống',
            'document_link.url' => 'Link tài liệu không hợp lệ',
            'document_link.max' => 'Link tài liệu không được vượt quá 255 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $notification->update([
            'title' => $request->title,
            'issue_date' => $request->issue_date,
            'document_link' => $request->document_link,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Thông báo đã được cập nhật thành công');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Thông báo đã được xóa thành công');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:notifications,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            Notification::where('id', $item['id'])
                ->update(['display_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}