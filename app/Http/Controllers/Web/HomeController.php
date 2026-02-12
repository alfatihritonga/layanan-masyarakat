<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private ReportService $reportService
    ) {}

    public function index(Request $request)
    {
        $landingStats = $this->reportService->getLandingOverview();

        $cta = [
            'route' => auth()->check()
                ? (auth()->user()->isAdmin() ? route('dashboard') : route('user.dashboard'))
                : route('login'),
            'label' => auth()->check()
                ? (auth()->user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard Saya')
                : 'Lapor Bencana',
        ];
        // return $landingStats;
        return view('welcome', compact('landingStats', 'cta'));
    }
}
