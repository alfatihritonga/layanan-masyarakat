<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\Report;
use App\Models\Relawan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AssignmentService
{
    public function __construct(
        private ReportService $reportService
    ) {}

    /**
     * Get all assignments with pagination
     */
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Assignment::with(['report.disasterType', 'relawan', 'assigner']);

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by relawan
        if (!empty($filters['relawan_id'])) {
            $query->where('relawan_id', $filters['relawan_id']);
        }

        // Filter by report
        if (!empty($filters['report_id'])) {
            $query->where('report_id', $filters['report_id']);
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'assigned_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Get all assignments
     */
    public function getAll(): Collection
    {
        return Assignment::with(['report', 'relawan', 'assigner'])->get();
    }

    /**
     * Find assignment by ID
     */
    public function findById(int $id): ?Assignment
    {
        return Assignment::with(['report', 'relawan', 'assigner'])->find($id);
    }

    /**
     * Assign relawan to report
     */
    public function assign(int $reportId, array $relawanIds, int $adminId, ?string $notes = null): array
    {
        DB::beginTransaction();
        try {
            $report = $this->reportService->findById($reportId, false);

            if (!$report) {
                throw new \Exception('Report not found');
            }

            // Validasi: report harus sudah verified
            if (!$report->isVerified() && !$report->isInProgress()) {
                throw new \Exception('Report must be verified before assigning volunteers');
            }

            $assignments = [];

            foreach ($relawanIds as $relawanId) {
                // Check if relawan exists and available
                $relawan = Relawan::find($relawanId);

                if (!$relawan) {
                    continue; // Skip if not found
                }

                // Check if already assigned
                $existingAssignment = Assignment::where('report_id', $reportId)
                    ->where('relawan_id', $relawanId)
                    ->first();

                if ($existingAssignment) {
                    continue; // Skip if already assigned
                }

                // Create assignment
                $assignment = Assignment::create([
                    'report_id' => $reportId,
                    'relawan_id' => $relawanId,
                    'assigned_by' => $adminId,
                    'status' => 'assigned',
                    'notes' => $notes,
                    'assigned_at' => now(),
                ]);

                // Update relawan status
                $relawan->update(['status_ketersediaan' => 'on_duty']);

                $assignments[] = $assignment;
            }

            // Update report status to in_progress
            if (count($assignments) > 0 && $report->status !== 'in_progress') {
                $this->reportService->markAsInProgress($reportId, $adminId);
            }

            DB::commit();
            return $assignments;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update assignment status
     */
    public function updateStatus(int $id, string $status, int $adminId, ?string $notes = null): bool
    {
        DB::beginTransaction();
        try {
            $assignment = $this->findById($id);

            if (!$assignment) {
                return false;
            }

            $updateData = ['status' => $status];

            switch ($status) {
                case 'on_the_way':
                    $updateData['started_at'] = now();
                    break;
                case 'on_site':
                    if (!$assignment->started_at) {
                        $updateData['started_at'] = now();
                    }
                    break;
                case 'completed':
                    $updateData['completed_at'] = now();
                    $updateData['completion_notes'] = $notes;
                    
                    // Update relawan status back to available
                    $assignment->relawan->update(['status_ketersediaan' => 'available']);
                    
                    // Check if all assignments completed, then mark report as resolved
                    $this->checkAndResolveReport($assignment->report_id, $adminId);
                    break;
                case 'cancelled':
                    // Update relawan status back to available
                    $assignment->relawan->update(['status_ketersediaan' => 'available']);
                    break;
            }

            $assignment->update($updateData);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Complete assignment
     */
    public function complete(int $id, int $adminId, ?string $completionNotes = null): bool
    {
        return $this->updateStatus($id, 'completed', $adminId, $completionNotes);
    }

    /**
     * Cancel assignment
     */
    public function cancel(int $id, int $adminId, ?string $reason = null): bool
    {
        return $this->updateStatus($id, 'cancelled', $adminId, $reason);
    }

    /**
     * Get assignments by report
     */
    public function getByReport(int $reportId): Collection
    {
        return Assignment::with(['relawan', 'assigner'])
            ->where('report_id', $reportId)
            ->get();
    }

    /**
     * Get assignments by relawan
     */
    public function getByRelawan(int $relawanId): Collection
    {
        return Assignment::with(['report.disasterType', 'assigner'])
            ->where('relawan_id', $relawanId)
            ->get();
    }

    /**
     * Get active assignments
     */
    public function getActiveAssignments(): Collection
    {
        return Assignment::with(['report.disasterType', 'relawan'])
            ->active()
            ->get();
    }

    /**
     * Check if all assignments completed and resolve report
     */
    private function checkAndResolveReport(int $reportId, int $adminId): void
    {
        $report = Report::find($reportId);

        if (!$report) {
            return;
        }

        // Count active assignments
        $activeAssignments = Assignment::where('report_id', $reportId)
            ->active()
            ->count();

        // If no active assignments, mark report as resolved
        if ($activeAssignments === 0) {
            $this->reportService->markAsResolved($reportId, $adminId, 'Semua penugasan telah selesai');
        }
    }
}