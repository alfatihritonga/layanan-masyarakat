<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAttachmentRequest;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
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
     * Get all reports (for authenticated user)
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
        $userId = $request->user()->id;

        $reports = $this->reportService->getAllPaginated($filters, $perPage, $userId);

        return $this->paginatedResponse(
            $reports,
            ReportListResource::class,
            'Daftar laporan berhasil diambil'
        );
    }

    /**
     * Create new report
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        try {
            $report = $this->reportService->create(
                $request->validated(),
                $request->user()->id
            );

            return $this->resourceResponse(
                new ReportResource($report),
                'Laporan berhasil dibuat',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Gagal membuat laporan: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Get report detail
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $report = $this->reportService->findById($id);

        if (!$report) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        // Check ownership (user can only see their own reports)
        if ($report->user_id !== $request->user()->id) {
            return $this->forbiddenResponse('Anda tidak memiliki akses ke laporan ini');
        }

        return $this->resourceResponse(
            new ReportResource($report),
            'Detail laporan berhasil diambil'
        );
    }

    /**
     * Update report (only if status is pending)
     */
    public function update(UpdateReportRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->reportService->update(
                $id,
                $request->validated(),
                $request->user()->id
            );

            if (!$updated) {
                return $this->notFoundResponse('Laporan tidak ditemukan');
            }

            $report = $this->reportService->findById($id);

            return $this->resourceResponse(
                new ReportResource($report),
                'Laporan berhasil diperbarui'
            );
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Unauthorized') {
                return $this->forbiddenResponse('Anda tidak memiliki akses untuk mengubah laporan ini');
            }

            if ($e->getMessage() === 'Report cannot be edited') {
                return $this->errorResponse('Laporan tidak dapat diubah karena sudah diverifikasi', 422);
            }

            return $this->errorResponse('Gagal memperbarui laporan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete report (only if status is pending)
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $deleted = $this->reportService->delete($id, $request->user()->id);

            if (!$deleted) {
                return $this->notFoundResponse('Laporan tidak ditemukan');
            }

            return $this->successResponse(
                null,
                'Laporan berhasil dihapus'
            );
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Unauthorized') {
                return $this->forbiddenResponse('Anda tidak memiliki akses untuk menghapus laporan ini');
            }

            if ($e->getMessage() === 'Report cannot be deleted') {
                return $this->errorResponse('Laporan tidak dapat dihapus karena sudah diverifikasi', 422);
            }

            return $this->errorResponse('Gagal menghapus laporan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Add attachment to report
     */
    public function addAttachment(AddAttachmentRequest $request, int $id): JsonResponse
    {
        try {
            $report = $this->reportService->findById($id, false);

            if (!$report) {
                return $this->notFoundResponse('Laporan tidak ditemukan');
            }

            // Check ownership
            if ($report->user_id !== $request->user()->id) {
                return $this->forbiddenResponse('Anda tidak memiliki akses ke laporan ini');
            }

            // Check if can be edited
            if (!$report->canBeEdited()) {
                return $this->errorResponse('Tidak dapat menambah lampiran karena laporan sudah diverifikasi', 422);
            }

            $attachment = $this->reportService->addAttachment(
                $id,
                $request->file('file'),
                $request->input('description')
            );

            return $this->successResponse(
                [
                    'id' => $attachment->id,
                    'file_name' => $attachment->file_name,
                    'file_type' => $attachment->file_type,
                    'url' => $attachment->url,
                ],
                'Lampiran berhasil ditambahkan',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal menambahkan lampiran: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete attachment
     */
    public function deleteAttachment(Request $request, int $reportId, int $attachmentId): JsonResponse
    {
        try {
            $deleted = $this->reportService->deleteAttachment($attachmentId, $request->user()->id);

            if (!$deleted) {
                return $this->notFoundResponse('Lampiran tidak ditemukan');
            }

            return $this->successResponse(null, 'Lampiran berhasil dihapus');
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Unauthorized or report cannot be edited') {
                return $this->forbiddenResponse('Anda tidak memiliki akses atau laporan tidak dapat diubah');
            }

            return $this->errorResponse('Gagal menghapus lampiran: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get report histories
     */
    public function histories(int $id): JsonResponse
    {
        $report = $this->reportService->findById($id);

        if (!$report) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        return $this->successResponse(
            $report->histories()->with('changer')->latest()->get(),
            'History laporan berhasil diambil'
        );
    }
}