<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\ReportCommentResource;
use App\Services\ReportCommentService;
use App\Services\ReportService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportCommentController extends Controller
{
    use ApiResponse;

    public function __construct(
        private ReportCommentService $commentService,
        private ReportService $reportService
    ) {}

    /**
     * Get comments by report
     */
    public function index(Request $request, int $reportId): JsonResponse
    {
        $report = $this->reportService->findById($reportId, false);

        if (!$report) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        // Check access (only owner can see comments)
        if ($report->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return $this->forbiddenResponse('Anda tidak memiliki akses ke laporan ini');
        }

        // Admin can see internal comments, user cannot
        $includeInternal = $request->user()->isAdmin();

        $comments = $this->commentService->getByReport($reportId, $includeInternal);

        return $this->successResponse(
            ReportCommentResource::collection($comments),
            'Komentar berhasil diambil'
        );
    }

    /**
     * Add comment to report
     */
    public function store(StoreCommentRequest $request, int $reportId): JsonResponse
    {
        $report = $this->reportService->findById($reportId, false);

        if (!$report) {
            return $this->notFoundResponse('Laporan tidak ditemukan');
        }

        // Check access
        if ($report->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return $this->forbiddenResponse('Anda tidak memiliki akses ke laporan ini');
        }

        $comment = $this->commentService->addComment(
            $reportId,
            $request->user()->id,
            $request->input('comment'),
            $request->input('is_internal', false)
        );

        return $this->resourceResponse(
            new ReportCommentResource($comment->load('user')),
            'Komentar berhasil ditambahkan',
            201
        );
    }

    /**
     * Delete comment
     */
    public function destroy(Request $request, int $reportId, int $commentId): JsonResponse
    {
        try {
            $deleted = $this->commentService->delete($commentId, $request->user()->id);

            if (!$deleted) {
                return $this->notFoundResponse('Komentar tidak ditemukan');
            }

            return $this->successResponse(null, 'Komentar berhasil dihapus');
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Unauthorized') {
                return $this->forbiddenResponse('Anda tidak memiliki akses untuk menghapus komentar ini');
            }

            return $this->errorResponse('Gagal menghapus komentar: ' . $e->getMessage(), 500);
        }
    }
}