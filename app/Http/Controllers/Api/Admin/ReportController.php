<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RejectReportRequest;
use App\Http\Requests\UpdateAdminNotesRequest;
use App\Http\Requests\UpdateUrgencyLevelRequest;
use App\Http\Requests\VerifyReportRequest;
use App\Http\Resources\ReportListResource;
use App\Http\Resources\ReportResource;
use App\Services\ReportService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    public function __construct(
        private ReportService $reportService
    ) {}

    /**
     * Get all reports (Admin)
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'status',
            'disaster_type_id',
            'urgency_level',
            'search',
            'date_from',
            'date_to',
            'sort_by',
            'sort_order'
        ]);

        $perPage = $request->input('per_page', 15);

        // Admin can see all reports (no userId filter)
        $reports = $this->reportService->getAllPaginated($filters, $perPage);

        return $this->paginatedResponse(
            $reports,
            ReportListResource::class,
            'Daftar laporan berhasil diambil'
        );
    }

    /**
     * Get report detail (Admin)
     */
    public function show(int $id): JsonResponse
    {
        $report = $this->reportService->findById($id);

        if (!$report) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        return $this->resourceResponse(
            new ReportResource($report),
            'Detail laporan berhasil diambil'
        );
    }

    /**
     * Verify report
     */
    public function verify(VerifyReportRequest $request, int $id): JsonResponse
    {
        $verified = $this->reportService->verify(
            $id,
            $request->user()->id,
            $request->validated()
        );

        if (!$verified) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        $report = $this->reportService->findById($id);

        return $this->resourceResponse(
            new ReportResource($report),
            'Laporan berhasil diverifikasi'
        );
    }

    /**
     * Reject report
     */
    public function reject(RejectReportRequest $request, int $id): JsonResponse
    {
        $rejected = $this->reportService->reject(
            $id,
            $request->user()->id,
            $request->input('rejection_reason')
        );

        if (!$rejected) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        $report = $this->reportService->findById($id);

        return $this->resourceResponse(
            new ReportResource($report),
            'Laporan berhasil ditolak'
        );
    }

    /**
     * Update urgency level
     */
    public function updateUrgency(UpdateUrgencyLevelRequest $request, int $id): JsonResponse
    {
        $updated = $this->reportService->updateUrgencyLevel(
            $id,
            $request->input('urgency_level'),
            $request->user()->id
        );

        if (!$updated) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        $report = $this->reportService->findById($id);

        return $this->resourceResponse(
            new ReportResource($report),
            'Tingkat urgensi berhasil diperbarui'
        );
    }

    /**
     * Update admin notes
     */
    public function updateNotes(UpdateAdminNotesRequest $request, int $id): JsonResponse
    {
        $updated = $this->reportService->updateAdminNotes(
            $id,
            $request->input('admin_notes')
        );

        if (!$updated) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        $report = $this->reportService->findById($id);

        return $this->resourceResponse(
            new ReportResource($report),
            'Catatan admin berhasil diperbarui'
        );
    }

    /**
     * Mark as resolved
     */
    public function resolve(Request $request, int $id): JsonResponse
    {
        $resolved = $this->reportService->markAsResolved(
            $id,
            $request->user()->id,
            $request->input('notes')
        );

        if (!$resolved) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        $report = $this->reportService->findById($id);

        return $this->resourceResponse(
            new ReportResource($report),
            'Laporan berhasil diselesaikan'
        );
    }

    /**
     * Get dashboard statistics
     */
    public function statistics(): JsonResponse
    {
        $statistics = $this->reportService->getStatistics();

        return $this->successResponse(
            $statistics,
            'Statistik berhasil diambil'
        );
    }
}