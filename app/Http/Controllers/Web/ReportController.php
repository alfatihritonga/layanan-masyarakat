<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRelawanRequest;
use App\Http\Requests\CompleteAssignmentRequest;
use App\Http\Requests\RejectReportRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateUrgencyLevelRequest;
use App\Http\Requests\VerifyReportRequest;
use App\Services\AssignmentService;
use App\Services\DisasterTypeService;
use App\Services\RelawanService;
use App\Services\ReportCommentService;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService,
        private DisasterTypeService $disasterTypeService,
        private RelawanService $relawanService,
        private AssignmentService $assignmentService,
        private ReportCommentService $commentService
    ) {}

    /**
     * Display a listing of reports
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'status',
            'disaster_type_id',
            'urgency_level',
            'search',
            'date_from',
            'date_to'
        ]);

        $reports = $this->reportService->getAllPaginated($filters, 10);
        $disasterTypes = $this->disasterTypeService->getAll();

        // return response()->json([
        //     'reports' => $reports,
        //     'disasterTypes' => $disasterTypes,
        //     'filters' => $filters
        // ]);
        return view('reports.index', compact('reports', 'disasterTypes', 'filters'));
    }

    /**
     * Display the specified report
     */
    public function show(int $id)
    {
        $report = $this->reportService->findById($id);

        if (!$report) {
            abort(404, 'Laporan tidak ditemukan');
        }

        $availableRelawan = $this->relawanService->getAll(['status' => 'available']);
        $comments = $this->commentService->getByReport($id, true); // include internal

        return view('reports.show', compact('report', 'availableRelawan', 'comments'));
    }

    /**
     * Verify report
     */
    public function verify(VerifyReportRequest $request, int $id)
    {
        $verified = $this->reportService->verify(
            $id,
            auth()->id(),
            $request->validated()
        );

        if (!$verified) {
            abort(404, 'Laporan tidak ditemukan');
        }

        return redirect()
            ->route('reports.show', $id)
            ->with('success', 'Laporan berhasil diverifikasi');
    }

    /**
     * Reject report
     */
    public function reject(RejectReportRequest $request, int $id)
    {
        $rejected = $this->reportService->reject(
            $id,
            auth()->id(),
            $request->input('rejection_reason')
        );

        if (!$rejected) {
            abort(404, 'Laporan tidak ditemukan');
        }

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil ditolak');
    }

    /**
     * Update urgency level
     */
    public function updateUrgency(UpdateUrgencyLevelRequest $request, int $id)
    {
        $updated = $this->reportService->updateUrgencyLevel(
            $id,
            $request->input('urgency_level'),
            auth()->id()
        );

        if (!$updated) {
            abort(404, 'Laporan tidak ditemukan');
        }

        return redirect()
            ->route('reports.show', $id)
            ->with('success', 'Tingkat urgensi berhasil diperbarui');
    }

    /**
     * Assign relawan to report
     */
    public function assign(AssignRelawanRequest $request, int $id)
    {
        try {
            $assignments = $this->assignmentService->assign(
                $id,
                $request->input('relawan_ids'),
                auth()->id(),
                $request->input('notes')
            );

            return redirect()
                ->route('reports.show', $id)
                ->with('success', count($assignments) . ' relawan berhasil ditugaskan');
        } catch (\Exception $e) {
            return redirect()
                ->route('reports.show', $id)
                ->with('error', 'Gagal menugaskan relawan: ' . $e->getMessage());
        }
    }

    /**
     * Update assignment status
     */
    public function updateAssignmentStatus(Request $request, int $reportId, int $assignmentId)
    {
        $request->validate([
            'status' => 'required|in:assigned,on_the_way,on_site,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updated = $this->assignmentService->updateStatus(
            $assignmentId,
            $request->input('status'),
            auth()->id(),
            $request->input('notes')
        );

        if (!$updated) {
            abort(404, 'Penugasan tidak ditemukan');
        }

        return redirect()
            ->route('reports.show', $reportId)
            ->with('success', 'Status penugasan berhasil diperbarui');
    }

    /**
     * Complete assignment
     */
    public function completeAssignment(CompleteAssignmentRequest $request, int $reportId, int $assignmentId)
    {
        $completed = $this->assignmentService->complete(
            $assignmentId,
            auth()->id(),
            $request->input('completion_notes')
        );

        if (!$completed) {
            abort(404, 'Penugasan tidak ditemukan');
        }

        return redirect()
            ->route('reports.show', $reportId)
            ->with('success', 'Penugasan berhasil diselesaikan');
    }

    /**
     * Mark report as resolved
     */
    public function resolve(Request $request, int $id)
    {
        $resolved = $this->reportService->markAsResolved(
            $id,
            auth()->id(),
            $request->input('notes')
        );

        if (!$resolved) {
            abort(404, 'Laporan tidak ditemukan');
        }

        return redirect()
            ->route('reports.show', $id)
            ->with('success', 'Laporan berhasil diselesaikan');
    }

    /**
     * Add comment
     */
    public function addComment(StoreCommentRequest $request, int $id)
    {
        $this->commentService->addComment(
            $id,
            auth()->id(),
            $request->input('comment'),
            $request->input('is_internal', false)
        );

        return redirect()
            ->route('reports.show', $id)
            ->with('success', 'Komentar berhasil ditambahkan');
    }
}