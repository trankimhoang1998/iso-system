<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\DepartmentController;
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
Route::get('/', [AuthController::class, 'showLogin'])->name('home');

// Home page (require authentication)
Route::get('/trang-chu', [HomeController::class, 'index'])->middleware('auth')->name('trang-chu');

// Authentication routes
Route::controller(AuthController::class)->group(function () {
    // General login route (redirect to home)
    Route::get('/login', function () {
        return redirect()->route('home');
    })->name('login');
    
    // Process login
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout')->name('auth.logout');
});

// Admin routes - All authenticated users can access
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Documents management - All users
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::put('/documents/{document}/approve', [DocumentController::class, 'approve'])->name('documents.approve');
    Route::put('/documents/{document}/revoke', [DocumentController::class, 'revokeApproval'])->name('documents.revoke');
    
    // Admin only routes - User and Department management
    Route::middleware(['role:0'])->group(function () {
        // Users management - Admin only
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'showCreateUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'showEditUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        // Departments management - Admin only
        Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        Route::post('/departments/{department}/toggle', [DepartmentController::class, 'toggle'])->name('departments.toggle');
        
        // Categories management - Admin only
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::post('/categories/reorder', [\App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('categories.reorder');
        Route::patch('/categories/{category}/toggle', [\App\Http\Controllers\Admin\CategoryController::class, 'toggle'])->name('categories.toggle');
        Route::get('/categories/{category}/children', [\App\Http\Controllers\Admin\CategoryController::class, 'getChildren'])->name('categories.children');
    });
});

// Level 1 (Ban ISO) routes
Route::middleware(['auth', 'role:1'])->prefix('level1')->name('level1.')->group(function () {
    Route::get('/dashboard', [Level1Controller::class, 'dashboard'])->name('dashboard');
    
    // Documents management
    Route::get('/documents', [Level1DocumentController::class, 'index'])->name('documents');
    Route::get('/documents/create', [Level1DocumentController::class, 'create'])->name('documents.create');
    Route::get('/documents/permissions', [Level1DocumentController::class, 'permissions'])->name('documents.permissions');
    Route::post('/documents', [Level1DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [Level1DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/download', [Level1DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/edit', [Level1DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [Level1DocumentController::class, 'update'])->name('documents.update');
    
    // Document permissions management  
    Route::post('/documents/{document}/grant-permission', [Level1DocumentController::class, 'grantPermission'])->name('documents.grant-permission');
    Route::delete('/documents/{document}/revoke-permission/{user}', [Level1DocumentController::class, 'revokePermission'])->name('documents.revoke-permission');
    
    // Proposals management (from Level 2)
    Route::get('/proposals', [Level1ProposalController::class, 'index'])->name('proposals');
    Route::get('/proposals/{proposal}', [Level1ProposalController::class, 'show'])->name('proposals.show');
    Route::patch('/proposals/{proposal}', [Level1ProposalController::class, 'update'])->name('proposals.update');
});

// Level 2 (Cơ quan - Phân xưởng) routes
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
