<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DisasterTypeController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\RelawanController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\User\ReportController as UserReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/home', function () {
    return redirect()->route('welcome');
})->name('home');

Route::get('/h', function () {
    return redirect()->route('welcome');
})->name('home.short');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    // OAuth Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes - User (Masyarakat)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('my')->name('user.')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Web\User\DashboardController::class, 'index'])->name('dashboard');
    
    // User Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [UserReportController::class, 'index'])->name('index');
        Route::get('/create', [UserReportController::class, 'create'])->name('create');
        Route::post('/', [UserReportController::class, 'store'])->name('store');
        Route::get('/{id}', [UserReportController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserReportController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserReportController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserReportController::class, 'destroy'])->name('destroy');
        
        // Attachments
        Route::post('/{id}/attachments', [UserReportController::class, 'addAttachment'])->name('addAttachment');
        Route::delete('/{reportId}/attachments/{attachmentId}', [UserReportController::class, 'deleteAttachment'])->name('deleteAttachment');
        
        // Comments
        Route::post('/{id}/comments', [UserReportController::class, 'addComment'])->name('addComment');
    });
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Admin Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/{id}', [ReportController::class, 'show'])->name('show');
        
        // Actions
        Route::post('/{id}/verify', [ReportController::class, 'verify'])->name('verify');
        Route::post('/{id}/reject', [ReportController::class, 'reject'])->name('reject');
        Route::post('/{id}/update-urgency', [ReportController::class, 'updateUrgency'])->name('updateUrgency');
        Route::post('/{id}/assign', [ReportController::class, 'assign'])->name('assign');
        Route::post('/{id}/resolve', [ReportController::class, 'resolve'])->name('resolve');
        
        // Assignment actions
        Route::post('/{reportId}/assignments/{assignmentId}/update-status', [ReportController::class, 'updateAssignmentStatus'])->name('updateAssignmentStatus');
        Route::post('/{reportId}/assignments/{assignmentId}/complete', [ReportController::class, 'completeAssignment'])->name('completeAssignment');
        
        // Comments
        Route::post('/{id}/comments', [ReportController::class, 'addComment'])->name('addComment');
    });
    
    // Relawan
    Route::resource('relawan', RelawanController::class);

    // Disaster Types
    Route::resource('disaster-types', DisasterTypeController::class);
});