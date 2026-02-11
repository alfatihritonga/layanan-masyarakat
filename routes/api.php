<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DisasterTypeController;
use App\Http\Controllers\Api\ReportCommentController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\Admin\AssignmentController;
use App\Http\Controllers\Api\Admin\DisasterTypeController as AdminDisasterTypeController;
use App\Http\Controllers\Api\Admin\RelawanController as AdminRelawanController;
use App\Http\Controllers\Api\Admin\ReportController as AdminReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::get('/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);
    Route::post('/login', [AuthController::class, 'login']); // Optional email login
});

// Public disaster types
Route::get('/disaster-types', [DisasterTypeController::class, 'index']);
Route::get('/disaster-types/{id}', [DisasterTypeController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Routes - User (Masyarakat)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'role:user,admin'])->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Reports - User can only see/manage their own reports
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index']);
        Route::post('/', [ReportController::class, 'store']);
        Route::get('/{id}', [ReportController::class, 'show']);
        Route::put('/{id}', [ReportController::class, 'update']);
        Route::delete('/{id}', [ReportController::class, 'destroy']);
        
        // Attachments
        Route::post('/{id}/attachments', [ReportController::class, 'addAttachment']);
        Route::delete('/{reportId}/attachments/{attachmentId}', [ReportController::class, 'deleteAttachment']);
        
        // Comments
        Route::get('/{reportId}/comments', [ReportCommentController::class, 'index']);
        Route::post('/{reportId}/comments', [ReportCommentController::class, 'store']);
        Route::delete('/{reportId}/comments/{commentId}', [ReportCommentController::class, 'destroy']);
        
        // Histories
        Route::get('/{id}/histories', [ReportController::class, 'histories']);
    });
});

/*
|--------------------------------------------------------------------------
| Protected Routes - Admin Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard & Statistics
    Route::get('/dashboard/statistics', [AdminReportController::class, 'statistics']);
    
    // Reports Management
    Route::prefix('reports')->group(function () {
        Route::get('/', [AdminReportController::class, 'index']);
        Route::get('/{id}', [AdminReportController::class, 'show']);
        
        // Verify & Reject
        Route::put('/{id}/verify', [AdminReportController::class, 'verify']);
        Route::put('/{id}/reject', [AdminReportController::class, 'reject']);
        
        // Update
        Route::put('/{id}/urgency', [AdminReportController::class, 'updateUrgency']);
        Route::put('/{id}/notes', [AdminReportController::class, 'updateNotes']);
        Route::put('/{id}/resolve', [AdminReportController::class, 'resolve']);
        
        // Assignments
        Route::post('/{id}/assign', [AssignmentController::class, 'assign']);
        Route::get('/{id}/assignments', [AssignmentController::class, 'byReport']);
    });
    
    // Assignments Management
    Route::prefix('assignments')->group(function () {
        Route::get('/', [AssignmentController::class, 'index']);
        Route::get('/active', [AssignmentController::class, 'active']);
        Route::get('/{id}', [AssignmentController::class, 'show']);
        Route::put('/{id}/status', [AssignmentController::class, 'updateStatus']);
        Route::put('/{id}/complete', [AssignmentController::class, 'complete']);
        Route::put('/{id}/cancel', [AssignmentController::class, 'cancel']);
    });
    
    // Relawan Management
    Route::prefix('relawan')->group(function () {
        Route::get('/', [AdminRelawanController::class, 'index']);
        Route::post('/', [AdminRelawanController::class, 'store']);
        Route::get('/available', [AdminRelawanController::class, 'available']);
        Route::get('/statistics', [AdminRelawanController::class, 'statistics']);
        Route::get('/{id}', [AdminRelawanController::class, 'show']);
        Route::put('/{id}', [AdminRelawanController::class, 'update']);
        Route::delete('/{id}', [AdminRelawanController::class, 'destroy']);
    });
    
    // Disaster Types Management
    Route::prefix('disaster-types')->group(function () {
        Route::get('/', [AdminDisasterTypeController::class, 'index']);
        Route::post('/', [AdminDisasterTypeController::class, 'store']);
        Route::get('/{id}', [AdminDisasterTypeController::class, 'show']);
        Route::put('/{id}', [AdminDisasterTypeController::class, 'update']);
        Route::delete('/{id}', [AdminDisasterTypeController::class, 'destroy']);
    });
});