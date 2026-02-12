<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Services\RelawanService;

class DashboardController extends Controller
{
    public function __construct(
        private ReportService $reportService,
        private RelawanService $relawanService
    ) {}

    public function index()
    {
        $reportStatistics = $this->reportService->getStatistics();
        $relawanStatistics = $this->relawanService->getStatistics();

        $statistics = [
            'reports' => $reportStatistics,
            'relawan' => $relawanStatistics,
        ];

        return view('dashboard', compact('statistics'));
    }
}