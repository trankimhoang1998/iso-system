<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\IsoDirectiveCategoryController;
use App\Http\Controllers\Admin\IsoSystemCategoryController;
use App\Http\Controllers\Admin\InternalDocumentCategoryController;
use App\Http\Controllers\Admin\IsoDirectiveDocumentController;
use App\Http\Controllers\Admin\IsoSystemDocumentController;
use App\Http\Controllers\Admin\InternalDocumentController;
use App\Http\Controllers\Admin\ManagementDocumentController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\NewProcessController;
use App\Http\Controllers\Admin\DownloadGuideController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login.form');

// Home page (require authentication)
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

// Authentication routes
Route::controller(AuthController::class)->group(function () {
    // Show login form
    Route::get('/login', 'showLogin')->name('login');
    
    // Process login
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout')->name('auth.logout');
});

// Admin routes - All authenticated users can access
Route::middleware(['auth'])->name('admin.')->group(function () {
    
    // Admin only routes - User and Department management
    Route::middleware(['role:0'])->group(function () {
        // Users management - Admin only
        Route::resource('users', UserController::class)->except(['show']);
        
        // Departments management - Admin only
        Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        
        // Download Guide management - Admin only
        Route::get('/download-guide', [DownloadGuideController::class, 'index'])->name('download-guide.index');
        Route::get('/download-guide/edit', [DownloadGuideController::class, 'edit'])->name('download-guide.edit');
        Route::put('/download-guide', [DownloadGuideController::class, 'update'])->name('download-guide.update');
        
        // Document ordering endpoints - Admin only
        Route::post('/iso-directive-documents/reorder', [IsoDirectiveDocumentController::class, 'reorder'])->name('iso-directive-documents.reorder');
        Route::post('/iso-system-documents/reorder', [IsoSystemDocumentController::class, 'reorder'])->name('iso-system-documents.reorder');
        Route::post('/internal-documents/reorder', [InternalDocumentController::class, 'reorder'])->name('internal-documents.reorder');
        Route::post('/management-documents/reorder', [ManagementDocumentController::class, 'reorder'])->name('management-documents.reorder');
        
          
        // New Categories management - 4 separate types (without show routes)
        Route::resource('iso-directive-categories', IsoDirectiveCategoryController::class)->except(['show']);
        Route::resource('iso-system-categories', IsoSystemCategoryController::class)->except(['show']);
        Route::resource('internal-document-categories', InternalDocumentCategoryController::class)->except(['show']);
        
    });
    
    // Document Index Routes - All authenticated users can access
    Route::get('iso-directive-documents', [IsoDirectiveDocumentController::class, 'index'])->name('iso-directive-documents.index');
    Route::get('iso-directive-documents/category/{category}', [IsoDirectiveDocumentController::class, 'indexByCategory'])->name('iso-directive-documents.category');
    
    Route::get('iso-system-documents', [IsoSystemDocumentController::class, 'index'])->name('iso-system-documents.index');
    Route::get('iso-system-documents/category/{category}', [IsoSystemDocumentController::class, 'indexByCategory'])->name('iso-system-documents.category');
    
    Route::get('internal-documents', [InternalDocumentController::class, 'index'])->name('internal-documents.index');
    Route::get('internal-documents/category/{category}', [InternalDocumentController::class, 'indexByCategory'])->name('internal-documents.category');
    
    Route::get('management-documents', [ManagementDocumentController::class, 'index'])->name('management-documents.index');
    Route::get('management-documents/category/{category}', [ManagementDocumentController::class, 'indexByCategory'])->name('management-documents.category');
    
    
    // Notification Management - Admin & Ban ISO (roles 0,1) full access
    Route::middleware(['role:0|1'])->group(function () {
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
        Route::get('notifications/{notification}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
        Route::put('notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');
        Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::post('notifications/reorder', [NotificationController::class, 'reorder'])->name('notifications.reorder');
    });
    
    // New Process Management - Admin & Ban ISO (roles 0,1) full access
    Route::middleware(['role:0|1'])->group(function () {
        Route::get('new-processes', [NewProcessController::class, 'index'])->name('new-processes.index');
        Route::get('new-processes/create', [NewProcessController::class, 'create'])->name('new-processes.create');
        Route::post('new-processes', [NewProcessController::class, 'store'])->name('new-processes.store');
        Route::get('new-processes/{newProcess}/edit', [NewProcessController::class, 'edit'])->name('new-processes.edit');
        Route::put('new-processes/{newProcess}', [NewProcessController::class, 'update'])->name('new-processes.update');
        Route::delete('new-processes/{newProcess}', [NewProcessController::class, 'destroy'])->name('new-processes.destroy');
        Route::post('new-processes/reorder', [NewProcessController::class, 'reorder'])->name('new-processes.reorder');
    });
    
    // Document Management - Admin & Ban ISO (roles 0,1) full access
    Route::middleware(['role:0|1'])->group(function () {
        // ISO Directive Documents
        Route::get('iso-directive-documents/create', [IsoDirectiveDocumentController::class, 'create'])->name('iso-directive-documents.create');
        Route::get('iso-directive-documents/category/{category}/create', [IsoDirectiveDocumentController::class, 'createForCategory'])->name('iso-directive-documents.category.create');
        Route::get('iso-directive-documents/category/{category}/{isoDirectiveDocument}/edit', [IsoDirectiveDocumentController::class, 'editForCategory'])->name('iso-directive-documents.category.edit');
        Route::post('iso-directive-documents', [IsoDirectiveDocumentController::class, 'store'])->name('iso-directive-documents.store');
        Route::get('iso-directive-documents/{isoDirectiveDocument}/edit', [IsoDirectiveDocumentController::class, 'edit'])->name('iso-directive-documents.edit');
        Route::put('iso-directive-documents/{isoDirectiveDocument}', [IsoDirectiveDocumentController::class, 'update'])->name('iso-directive-documents.update');
        Route::delete('iso-directive-documents/{isoDirectiveDocument}', [IsoDirectiveDocumentController::class, 'destroy'])->name('iso-directive-documents.destroy');
        
        // ISO System Documents
        Route::get('iso-system-documents/create', [IsoSystemDocumentController::class, 'create'])->name('iso-system-documents.create');
        Route::get('iso-system-documents/category/{category}/create', [IsoSystemDocumentController::class, 'createForCategory'])->name('iso-system-documents.category.create');
        Route::get('iso-system-documents/category/{category}/{isoSystemDocument}/edit', [IsoSystemDocumentController::class, 'editForCategory'])->name('iso-system-documents.category.edit');
        Route::post('iso-system-documents', [IsoSystemDocumentController::class, 'store'])->name('iso-system-documents.store');
        Route::get('iso-system-documents/{isoSystemDocument}/edit', [IsoSystemDocumentController::class, 'edit'])->name('iso-system-documents.edit');
        Route::put('iso-system-documents/{isoSystemDocument}', [IsoSystemDocumentController::class, 'update'])->name('iso-system-documents.update');
        Route::delete('iso-system-documents/{isoSystemDocument}', [IsoSystemDocumentController::class, 'destroy'])->name('iso-system-documents.destroy');
        
        // Management Documents
        Route::get('management-documents/create', [ManagementDocumentController::class, 'create'])->name('management-documents.create');
        Route::get('management-documents/category/{category}/create', [ManagementDocumentController::class, 'createForCategory'])->name('management-documents.category.create');
        Route::get('management-documents/category/{category}/{managementDocument}/edit', [ManagementDocumentController::class, 'editForCategory'])->name('management-documents.category.edit');
        Route::post('management-documents', [ManagementDocumentController::class, 'store'])->name('management-documents.store');
        Route::get('management-documents/{managementDocument}/edit', [ManagementDocumentController::class, 'edit'])->name('management-documents.edit');
        Route::put('management-documents/{managementDocument}', [ManagementDocumentController::class, 'update'])->name('management-documents.update');
        Route::delete('management-documents/{managementDocument}', [ManagementDocumentController::class, 'destroy'])->name('management-documents.destroy');
    });
    
    // Internal Documents - Admin & Cơ quan-Phân xưởng (roles 0,2) can create/edit/delete
    Route::middleware(['role:0|2'])->group(function () {
        Route::get('internal-documents/create', [InternalDocumentController::class, 'create'])->name('internal-documents.create');
        Route::get('internal-documents/category/{category}/create', [InternalDocumentController::class, 'createForCategory'])->name('internal-documents.category.create');
        Route::get('internal-documents/category/{category}/{internalDocument}/edit', [InternalDocumentController::class, 'editForCategory'])->name('internal-documents.category.edit');
        Route::post('internal-documents', [InternalDocumentController::class, 'store'])->name('internal-documents.store');
        Route::get('internal-documents/{internalDocument}/edit', [InternalDocumentController::class, 'edit'])->name('internal-documents.edit');
        Route::put('internal-documents/{internalDocument}', [InternalDocumentController::class, 'update'])->name('internal-documents.update');
        Route::delete('internal-documents/{internalDocument}', [InternalDocumentController::class, 'destroy'])->name('internal-documents.destroy');
    });
    
    // View and Download Routes - All authenticated users can access (must be after management routes)
    Route::get('iso-directive-documents/{isoDirectiveDocument}/view/{type?}', [IsoDirectiveDocumentController::class, 'view'])->name('iso-directive-documents.view');
    Route::get('iso-directive-documents/{isoDirectiveDocument}/download/{type?}', [IsoDirectiveDocumentController::class, 'download'])->name('iso-directive-documents.download');
    
    Route::get('iso-system-documents/{isoSystemDocument}/view/{type?}', [IsoSystemDocumentController::class, 'view'])->name('iso-system-documents.view');
    Route::get('iso-system-documents/{isoSystemDocument}/download/{type?}', [IsoSystemDocumentController::class, 'download'])->name('iso-system-documents.download');
    
    Route::get('internal-documents/{internalDocument}/view/{type?}', [InternalDocumentController::class, 'view'])->name('internal-documents.view');
    Route::get('internal-documents/{internalDocument}/download/{type?}', [InternalDocumentController::class, 'download'])->name('internal-documents.download');
    
    Route::get('management-documents/{managementDocument}/view/{type?}', [ManagementDocumentController::class, 'view'])->name('management-documents.view');
    Route::get('management-documents/{managementDocument}/download/{type?}', [ManagementDocumentController::class, 'download'])->name('management-documents.download');
});

