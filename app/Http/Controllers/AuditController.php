<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index()
    {
        // Audit main page - redirect to summary
        return redirect()->route('admin.audit.summary');
    }

    public function summary()
    {
        // Display audit summary
        return view('audit.summary');
    }

    public function program()
    {
        // Display audit program
        return view('audit.program');
    }

    public function implementation()
    {
        // Display audit implementation
        return view('audit.implementation');
    }

    public function report()
    {
        // Display audit reports
        return view('audit.report');
    }

    public function action()
    {
        // Display audit actions
        return view('audit.action');
    }
}