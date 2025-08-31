<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Level1\Level1Controller;
use App\Http\Controllers\Level1\DocumentController as Level1DocumentController;
use App\Http\Controllers\Level1\ProposalController as Level1ProposalController;
use App\Http\Controllers\Level2\Level2Controller;
use App\Http\Controllers\Level2\DocumentController as Level2DocumentController;
use App\Http\Controllers\Level2\ProposalController as Level2ProposalController;
use App\Http\Controllers\Level3\Level3Controller;
use App\Http\Controllers\Level3\DocumentController as Level3DocumentController;
use App\Http\Controllers\Level3\ProposalController as Level3ProposalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::controller(AuthController::class)->group(function () {
    // General login route (smart redirect based on intended URL)
    Route::get('/login', function () {
        // Redirect to dashboard if already logged in
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        
        $intended = session('url.intended');
        
        // Redirect to appropriate login based on intended URL
        if (str_contains($intended, '/level1')) {
            return redirect()->route('level1.login');
        } elseif (str_contains($intended, '/level2')) {
            return redirect()->route('level2.login');
        } elseif (str_contains($intended, '/level3')) {
            return redirect()->route('level3.login');
        } elseif (str_contains($intended, '/admin')) {
            return redirect()->route('admin.login');
        }
        
        // Default to admin login
        return redirect()->route('admin.login');
    })->name('login');
    
    // Login routes for different roles
    Route::get('/admin/login', 'showAdminLogin')->name('admin.login');
    Route::get('/level1/login', 'showLevel1Login')->name('level1.login');
    Route::get('/level2/login', 'showLevel2Login')->name('level2.login');
    Route::get('/level3/login', 'showLevel3Login')->name('level3.login');
    
    // Process login
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout')->name('auth.logout');
});

// Admin routes
Route::middleware(['auth', 'role:0'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'createUser'])->name('users.create');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Documents management
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::put('/documents/{document}/approve', [DocumentController::class, 'approve'])->name('documents.approve');
    Route::put('/documents/{document}/revoke', [DocumentController::class, 'revokeApproval'])->name('documents.revoke');
});

// Level 1 (Ban ISO) routes
Route::middleware(['auth', 'role:1'])->prefix('level1')->name('level1.')->group(function () {
    Route::get('/dashboard', [Level1Controller::class, 'dashboard'])->name('dashboard');
    
    // Documents management
    Route::get('/documents', [Level1DocumentController::class, 'index'])->name('documents');
    Route::post('/documents', [Level1DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/download', [Level1DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/edit', [Level1DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [Level1DocumentController::class, 'update'])->name('documents.update');
    
    // Document permissions management
    Route::get('/documents/permissions', [Level1DocumentController::class, 'permissions'])->name('documents.permissions');
    Route::post('/documents/{document}/grant-permission', [Level1DocumentController::class, 'grantPermission'])->name('documents.grant-permission');
    Route::delete('/documents/{document}/revoke-permission/{user}', [Level1DocumentController::class, 'revokePermission'])->name('documents.revoke-permission');
    
    // Proposals management (from Level 2)
    Route::get('/proposals', [Level1ProposalController::class, 'index'])->name('proposals');
    Route::get('/proposals/{proposal}', [Level1ProposalController::class, 'show'])->name('proposals.show');
    Route::patch('/proposals/{proposal}', [Level1ProposalController::class, 'update'])->name('proposals.update');
});

// Level 2 (Cơ quan/Phân xưởng) routes
Route::middleware(['auth', 'role:2'])->prefix('level2')->name('level2.')->group(function () {
    Route::get('/dashboard', [Level2Controller::class, 'dashboard'])->name('dashboard');
    
    // Documents management
    Route::get('/documents', [Level2DocumentController::class, 'index'])->name('documents');
    Route::get('/documents/{document}/download', [Level2DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/view', [Level2DocumentController::class, 'view'])->name('documents.view');
    
    // Proposals management
    Route::get('/proposals', [Level2ProposalController::class, 'index'])->name('proposals');
    Route::post('/proposals', [Level2ProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/{proposal}', [Level2ProposalController::class, 'show'])->name('proposals.show');
    Route::get('/proposals/{proposal}/edit', [Level2ProposalController::class, 'edit'])->name('proposals.edit');
    Route::put('/proposals/{proposal}', [Level2ProposalController::class, 'update'])->name('proposals.update');
    Route::delete('/proposals/{proposal}', [Level2ProposalController::class, 'destroy'])->name('proposals.destroy');
});

// Level 3 (Người sử dụng) routes
Route::middleware(['auth', 'role:3'])->prefix('level3')->name('level3.')->group(function () {
    Route::get('/dashboard', [Level3Controller::class, 'dashboard'])->name('dashboard');
    
    // Documents management
    Route::get('/documents', [Level3DocumentController::class, 'index'])->name('documents');
    Route::get('/documents/{document}/view', [Level3DocumentController::class, 'view'])->name('documents.view');
    Route::get('/documents/{document}/download', [Level3DocumentController::class, 'download'])->name('documents.download');
    
    // Proposals management (submit to Level 2)
    Route::get('/proposals', [Level3ProposalController::class, 'index'])->name('proposals');
    Route::post('/proposals', [Level3ProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/{proposal}', [Level3ProposalController::class, 'show'])->name('proposals.show');
    Route::get('/proposals/{proposal}/edit', [Level3ProposalController::class, 'edit'])->name('proposals.edit');
    Route::put('/proposals/{proposal}', [Level3ProposalController::class, 'update'])->name('proposals.update');
    Route::delete('/proposals/{proposal}', [Level3ProposalController::class, 'destroy'])->name('proposals.destroy');
});
