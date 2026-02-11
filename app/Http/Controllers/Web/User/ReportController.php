<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAttachmentRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Services\DisasterTypeService;
use App\Services\ReportCommentService;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService,
        private DisasterTypeService $disasterTypeService,
        private ReportCommentService $commentService
    ) {}

    /**
     * Display a listing of user's reports
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'disaster_type_id', 'search']);
        $userId = auth()->id();

        $reports = $this->reportService->getAllPaginated($filters, 10, $userId);
        $disasterTypes = $this->disasterTypeService->getAll();

        return view('user.reports.index', compact('reports', 'disasterTypes', 'filters'));
    }

    /**
     * Show the form for creating a new report
     */
    public function create()
    {
        $disasterTypes = $this->disasterTypeService->getAll();

        return view('user.reports.create', compact('disasterTypes'));
    }

    /**
     * Store a newly created report
     */
    public function store(StoreReportRequest $request)
    {
        try {
            $report = $this->reportService->create(
                $request->validated(),
                auth()->id()
            );

            return redirect()
                ->route('user.reports.show', $report->id)
                ->with('success', 'Laporan berhasil dibuat. Laporan Anda akan segera diverifikasi oleh admin.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
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

        // Check ownership
        if ($report->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini');
        }

        $comments = $this->commentService->getByReport($id, false); // exclude internal

        return view('user.reports.show', compact('report', 'comments'));
    }

    /**
     * Show the form for editing the specified report
     */
    public function edit(int $id)
    {
        $report = $this->reportService->findById($id, false);

        if (!$report) {
            abort(404, 'Laporan tidak ditemukan');
        }

        // Check ownership
        if ($report->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini');
        }

        // Check if can be edited
        if (!$report->canBeEdited()) {
            return redirect()
                ->route('user.reports.show', $id)
                ->with('error', 'Laporan tidak dapat diubah karena sudah diverifikasi oleh admin');
        }

        $disasterTypes = $this->disasterTypeService->getAll();

        return view('user.reports.edit', compact('report', 'disasterTypes'));
    }

    /**
     * Update the specified report
     */
    public function update(UpdateReportRequest $request, int $id)
    {
        try {
            $updated = $this->reportService->update(
                $id,
                $request->validated(),
                auth()->id()
            );

            if (!$updated) {
                abort(404, 'Laporan tidak ditemukan');
            }

            return redirect()
                ->route('user.reports.show', $id)
                ->with('success', 'Laporan berhasil diperbarui');
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Unauthorized') {
                abort(403, 'Anda tidak memiliki akses untuk mengubah laporan ini');
            }

            if ($e->getMessage() === 'Report cannot be edited') {
                return redirect()
                    ->route('user.reports.show', $id)
                    ->with('error', 'Laporan tidak dapat diubah karena sudah diverifikasi');
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified report
     */
    public function destroy(int $id)
    {
        try {
            $deleted = $this->reportService->delete($id, auth()->id());

            if (!$deleted) {
                abort(404, 'Laporan tidak ditemukan');
            }

            return redirect()
                ->route('user.reports.index')
                ->with('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Unauthorized') {
                abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini');
            }

            if ($e->getMessage() === 'Report cannot be deleted') {
                return redirect()
                    ->route('user.reports.show', $id)
                    ->with('error', 'Laporan tidak dapat dihapus karena sudah diverifikasi');
            }

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    /**
     * Add attachment to report
     */
    public function addAttachment(AddAttachmentRequest $request, int $id)
    {
        try {
            $report = $this->reportService->findById($id, false);

            if (!$report) {
                abort(404, 'Laporan tidak ditemukan');
            }

            // Check ownership
            if ($report->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke laporan ini');
            }

            // Check if can be edited
            if (!$report->canBeEdited()) {
                return redirect()
                    ->route('user.reports.show', $id)
                    ->with('error', 'Tidak dapat menambah lampiran karena laporan sudah diverifikasi');
            }

            $this->reportService->addAttachment(
                $id,
                $request->file('file'),
                $request->input('description')
            );

            return redirect()
                ->route('user.reports.show', $id)
                ->with('success', 'Lampiran berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan lampiran: ' . $e->getMessage());
        }
    }

    /**
     * Delete attachment
     */
    public function deleteAttachment(int $reportId, int $attachmentId)
    {
        try {
            $deleted = $this->reportService->deleteAttachment($attachmentId, auth()->id());

            if (!$deleted) {
                abort(404, 'Lampiran tidak ditemukan');
            }

            return redirect()
                ->route('user.reports.show', $reportId)
                ->with('success', 'Lampiran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus lampiran: ' . $e->getMessage());
        }
    }

    /**
     * Add comment to report
     */
    public function addComment(StoreCommentRequest $request, int $id)
    {
        $this->commentService->addComment(
            $id,
            auth()->id(),
            $request->input('comment'),
            false // user cannot make internal comment
        );

        return redirect()
            ->route('user.reports.show', $id)
            ->with('success', 'Komentar berhasil ditambahkan');
    }
}