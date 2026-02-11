<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRelawanRequest;
use App\Http\Requests\CompleteAssignmentRequest;
use App\Http\Requests\UpdateAssignmentStatusRequest;
use App\Http\Resources\AssignmentResource;
use App\Services\AssignmentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use ApiResponse;

    public function __construct(
        private AssignmentService $assignmentService
    ) {}

    /**
     * Get all assignments
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'relawan_id', 'report_id', 'sort_by', 'sort_order']);
        $perPage = $request->input('per_page', 15);

        $assignments = $this->assignmentService->getAllPaginated($filters, $perPage);

        return $this->paginatedResponse(
            $assignments,
            AssignmentResource::class,
            'Daftar penugasan berhasil diambil'
        );
    }

    /**
     * Get assignment detail
     */
    public function show(int $id): JsonResponse
    {
        $assignment = $this->assignmentService->findById($id);

        if (!$assignment) {
            return $this->notFoundResponse('Penugasan tidak ditemukan');
        }

        return $this->resourceResponse(
            new AssignmentResource($assignment),
            'Detail penugasan berhasil diambil'
        );
    }

    /**
     * Assign relawan to report
     */
    public function assign(AssignRelawanRequest $request, int $reportId): JsonResponse
    {
        try {
            $assignments = $this->assignmentService->assign(
                $reportId,
                $request->input('relawan_ids'),
                $request->user()->id,
                $request->input('notes')
            );

            return $this->successResponse(
                AssignmentResource::collection($assignments),
                count($assignments) . ' relawan berhasil ditugaskan',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal menugaskan relawan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update assignment status
     */
    public function updateStatus(UpdateAssignmentStatusRequest $request, int $id): JsonResponse
    {
        $updated = $this->assignmentService->updateStatus(
            $id,
            $request->input('status'),
            $request->user()->id,
            $request->input('notes')
        );

        if (!$updated) {
            return $this->notFoundResponse('Penugasan tidak ditemukan');
        }

        $assignment = $this->assignmentService->findById($id);

        return $this->resourceResponse(
            new AssignmentResource($assignment),
            'Status penugasan berhasil diperbarui'
        );
    }

    /**
     * Complete assignment
     */
    public function complete(CompleteAssignmentRequest $request, int $id): JsonResponse
    {
        $completed = $this->assignmentService->complete(
            $id,
            $request->user()->id,
            $request->input('completion_notes')
        );

        if (!$completed) {
            return $this->notFoundResponse('Penugasan tidak ditemukan');
        }

        $assignment = $this->assignmentService->findById($id);

        return $this->resourceResponse(
            new AssignmentResource($assignment),
            'Penugasan berhasil diselesaikan'
        );
    }

    /**
     * Cancel assignment
     */
    public function cancel(Request $request, int $id): JsonResponse
    {
        $cancelled = $this->assignmentService->cancel(
            $id,
            $request->user()->id,
            $request->input('reason')
        );

        if (!$cancelled) {
            return $this->notFoundResponse('Penugasan tidak ditemukan');
        }

        $assignment = $this->assignmentService->findById($id);

        return $this->resourceResponse(
            new AssignmentResource($assignment),
            'Penugasan berhasil dibatalkan'
        );
    }

    /**
     * Get assignments by report
     */
    public function byReport(int $reportId): JsonResponse
    {
        $assignments = $this->assignmentService->getByReport($reportId);

        return $this->successResponse(
            AssignmentResource::collection($assignments),
            'Daftar penugasan berhasil diambil'
        );
    }

    /**
     * Get active assignments
     */
    public function active(): JsonResponse
    {
        $assignments = $this->assignmentService->getActiveAssignments();

        return $this->successResponse(
            AssignmentResource::collection($assignments),
            'Daftar penugasan aktif berhasil diambil'
        );
    }
}