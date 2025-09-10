<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownloadGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DownloadGuideController extends Controller
{
    public function index()
    {
        $downloadGuide = DownloadGuide::first();
        return view('admin.download-guide.index', compact('downloadGuide'));
    }

    public function edit()
    {
        $downloadGuide = DownloadGuide::first();
        if (!$downloadGuide) {
            $downloadGuide = new DownloadGuide();
        }
        return view('admin.download-guide.edit', compact('downloadGuide'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'download_link' => 'required|url|max:255',
        ], [
            'download_link.required' => 'Link tài liệu không được để trống',
            'download_link.url' => 'Link tài liệu không hợp lệ',
            'download_link.max' => 'Link tài liệu không được vượt quá 255 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $downloadGuide = DownloadGuide::first();
        if ($downloadGuide) {
            $downloadGuide->update([
                'download_link' => $request->download_link,
            ]);
        } else {
            DownloadGuide::create([
                'download_link' => $request->download_link,
            ]);
        }

        return redirect()->route('admin.download-guide.index')
            ->with('success', 'Link tài liệu hướng dẫn đã được cập nhật thành công');
    }
}