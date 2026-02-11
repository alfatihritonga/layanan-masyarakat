<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\ReportHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportService
{
    /**
     * Get paginated reports with filters
     */
    public function getAllPaginated(array $filters = [], int $perPage = 15, ?int $userId = null): LengthAwarePaginator
    {
        $query = Report::with(['user', 'disasterType', 'attachments']);

        // Filter by user (untuk masyarakat, hanya laporan mereka sendiri)
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by disaster type
        if (!empty($filters['disaster_type_id'])) {
            $query->where('disaster_type_id', $filters['disaster_type_id']);
        }

        // Filter by urgency level
        if (!empty($filters['urgency_level'])) {
            $query->where('urgency_level', $filters['urgency_level']);
        }

        // Search by description or location
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('location_address', 'like', "%{$search}%")
                  ->orWhere('contact_phone', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->where('incident_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('incident_date', '<=', $filters['date_to']);
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Get all reports (no pagination)
     */
    public function getAll(array $filters = []): Collection
    {
        $query = Report::with(['user', 'disasterType']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    /**
     * Find report by ID
     */
    public function findById(int $id, bool $withRelations = true): ?Report
    {
        $query = Report::query();

        if ($withRelations) {
            $query->with([
                'user',
                'disasterType',
                'attachments',
                'assignments.relawan',
                'assignments.assigner',
                'histories.changer',
                'comments.user',
                'verifier'
            ]);
        }

        return $query->find($id);
    }

    /**
     * Create new report
     */
    public function create(array $data, int $userId): Report
    {
        DB::beginTransaction();
        try {
            // Create report
            $report = Report::create([
                'user_id' => $userId,
                'disaster_type_id' => $data['disaster_type_id'],
                'description' => $data['description'],
                'location_address' => $data['location_address'],
                'incident_date' => $data['incident_date'],
                'urgency_level' => $data['urgency_level'],
                'victim_count' => $data['victim_count'] ?? null,
                'damage_description' => $data['damage_description'] ?? null,
                'contact_phone' => $data['contact_phone'],
                'status' => 'pending',
            ]);

            // Handle file attachments
            if (!empty($data['attachments'])) {
                $this->handleAttachments($report, $data['attachments']);
            }

            DB::commit();
            return $report->load(['user', 'disasterType', 'attachments']);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update report (only if status is pending)
     */
    public function update(int $id, array $data, int $userId): bool
    {
        DB::beginTransaction();
        try {
            $report = $this->findById($id, false);

            if (!$report) {
                return false;
            }

            // Validasi: hanya pemilik yang bisa edit
            if ($report->user_id !== $userId) {
                throw new \Exception('Unauthorized');
            }

            // Validasi: hanya pending yang bisa diedit
            if (!$report->canBeEdited()) {
                throw new \Exception('Report cannot be edited');
            }

            $report->update([
                'disaster_type_id' => $data['disaster_type_id'] ?? $report->disaster_type_id,
                'description' => $data['description'] ?? $report->description,
                'location_address' => $data['location_address'] ?? $report->location_address,
                'incident_date' => $data['incident_date'] ?? $report->incident_date,
                'urgency_level' => $data['urgency_level'] ?? $report->urgency_level,
                'victim_count' => $data['victim_count'] ?? $report->victim_count,
                'damage_description' => $data['damage_description'] ?? $report->damage_description,
                'contact_phone' => $data['contact_phone'] ?? $report->contact_phone,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete report (only if status is pending)
     */
    public function delete(int $id, int $userId): bool
    {
        DB::beginTransaction();
        try {
            $report = $this->findById($id, false);

            if (!$report) {
                return false;
            }

            // Validasi: hanya pemilik yang bisa hapus
            if ($report->user_id !== $userId) {
                throw new \Exception('Unauthorized');
            }

            // Validasi: hanya pending yang bisa dihapus
            if (!$report->canBeDeleted()) {
                throw new \Exception('Report cannot be deleted');
            }

            // Hapus file attachments
            $this->deleteAllAttachments($report);

            $report->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Verify report (Admin only)
     */
    public function verify(int $id, int $adminId, array $data = []): bool
    {
        DB::beginTransaction();
        try {
            $report = $this->findById($id, false);

            if (!$report) {
                return false;
            }

            // Update urgency level jika ada
            if (!empty($data['urgency_level'])) {
                $this->logHistory($report->id, $adminId, 'urgency_level', $report->urgency_level, $data['urgency_level']);
                $report->urgency_level = $data['urgency_level'];
            }

            // Log status change
            $this->logHistory($report->id, $adminId, 'status', $report->status, 'verified', 'Laporan telah diverifikasi');

            $report->update([
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => $adminId,
                'admin_notes' => $data['admin_notes'] ?? null,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reject report (Admin only)
     */
    public function reject(int $id, int $adminId, string $reason): bool
    {
        DB::beginTransaction();
        try {
            $report = $this->findById($id, false);

            if (!$report) {
                return false;
            }

            // Log status change
            $this->logHistory($report->id, $adminId, 'status', $report->status, 'rejected', $reason);

            $report->update([
                'status' => 'rejected',
                'verified_at' => now(),
                'verified_by' => $adminId,
                'rejection_reason' => $reason,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update status to in_progress (when relawan assigned)
     */
    public function markAsInProgress(int $id, int $adminId): bool
    {
        DB::beginTransaction();
        try {
            $report = $this->findById($id, false);

            if (!$report) {
                return false;
            }

            // Log status change
            $this->logHistory($report->id, $adminId, 'status', $report->status, 'in_progress', 'Relawan telah ditugaskan');

            $report->update([
                'status' => 'in_progress',
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Mark report as resolved
     */
    public function markAsResolved(int $id, int $adminId, ?string $notes = null): bool
    {
        DB::beginTransaction();
        try {
            $report = $this->findById($id, false);

            if (!$report) {
                return false;
            }

            // Log status change
            $this->logHistory($report->id, $adminId, 'status', $report->status, 'resolved', $notes ?? 'Laporan telah selesai ditangani');

            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update admin notes
     */
    public function updateAdminNotes(int $id, string $notes): bool
    {
        $report = $this->findById($id, false);

        if (!$report) {
            return false;
        }

        return $report->update(['admin_notes' => $notes]);
    }

    /**
     * Update urgency level
     */
    public function updateUrgencyLevel(int $id, string $urgencyLevel, int $adminId): bool
    {
        DB::beginTransaction();
        try {
            $report = $this->findById($id, false);

            if (!$report) {
                return false;
            }

            // Log history
            $this->logHistory($report->id, $adminId, 'urgency_level', $report->urgency_level, $urgencyLevel);

            $report->update(['urgency_level' => $urgencyLevel]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Add attachment to report
     */
    public function addAttachment(int $reportId, $file, ?string $description = null): ?ReportAttachment
    {
        $report = $this->findById($reportId, false);

        if (!$report) {
            return null;
        }

        // Check max attachments (3)
        if ($report->attachments()->count() >= 3) {
            throw new \Exception('Maximum 3 attachments allowed');
        }

        return $this->storeAttachment($report, $file, $description);
    }

    /**
     * Delete attachment
     */
    public function deleteAttachment(int $attachmentId, int $userId): bool
    {
        $attachment = ReportAttachment::find($attachmentId);

        if (!$attachment) {
            return false;
        }

        $report = $attachment->report;

        // Validasi: hanya pemilik yang bisa hapus dan hanya jika pending
        if ($report->user_id !== $userId || !$report->canBeEdited()) {
            throw new \Exception('Unauthorized or report cannot be edited');
        }

        // Delete file from storage
        Storage::disk('public')->delete($attachment->file_path);

        return $attachment->delete();
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics(): array
    {
        return [
            'total' => Report::count(),
            'pending' => Report::pending()->count(),
            'verified' => Report::verified()->count(),
            'in_progress' => Report::inProgress()->count(),
            'resolved' => Report::resolved()->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
            'by_urgency' => [
                'critical' => Report::byUrgency('critical')->count(),
                'high' => Report::byUrgency('high')->count(),
                'medium' => Report::byUrgency('medium')->count(),
                'low' => Report::byUrgency('low')->count(),
            ],
            'by_disaster_type' => Report::selectRaw('disaster_type_id, COUNT(*) as total')
                ->with('disasterType:id,name')
                ->groupBy('disaster_type_id')
                ->get()
                ->map(function ($item) {
                    return [
                        'disaster_type' => $item->disasterType->name,
                        'total' => $item->total,
                    ];
                }),
            'recent_reports' => Report::with(['user', 'disasterType'])
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    /**
     * Handle multiple file attachments
     */
    private function handleAttachments(Report $report, array $files): void
    {
        foreach ($files as $file) {
            $this->storeAttachment($report, $file);
        }
    }

    /**
     * Store single attachment
     */
    private function storeAttachment(Report $report, $file, ?string $description = null): ReportAttachment
    {
        $fileType = str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video';
        $folder = $fileType === 'image' ? 'images' : 'videos';
        
        // Generate filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store file
        $path = $file->storeAs("reports/{$report->id}/{$folder}", $filename, 'public');

        return ReportAttachment::create([
            'report_id' => $report->id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $fileType,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'description' => $description,
        ]);
    }

    /**
     * Delete all attachments for a report
     */
    private function deleteAllAttachments(Report $report): void
    {
        foreach ($report->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $report->attachments()->delete();
    }

    /**
     * Log history
     */
    private function logHistory(int $reportId, int $changedBy, string $fieldName, $oldValue, $newValue, ?string $notes = null): void
    {
        ReportHistory::create([
            'report_id' => $reportId,
            'changed_by' => $changedBy,
            'field_name' => $fieldName,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'notes' => $notes,
        ]);
    }
}