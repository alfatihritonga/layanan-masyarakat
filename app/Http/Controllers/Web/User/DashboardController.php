<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Statistics
        $statistics = [
            'total' => Report::where('user_id', $userId)->count(),
            'pending' => Report::where('user_id', $userId)->where('status', 'pending')->count(),
            'verified' => Report::where('user_id', $userId)->where('status', 'verified')->count(),
            'in_progress' => Report::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'resolved' => Report::where('user_id', $userId)->where('status', 'resolved')->count(),
        ];

        // Recent reports
        $recent_reports = Report::where('user_id', $userId)
            ->with('disasterType')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('statistics', 'recent_reports'));
    }
}