<?php

namespace App\Services;

use App\Models\ReportComment;
use Illuminate\Database\Eloquent\Collection;

class ReportCommentService
{
    /**
     * Get comments by report
     */
    public function getByReport(int $reportId, bool $includeInternal = false): Collection
    {
        $query = ReportComment::with('user')
            ->where('report_id', $reportId);

        if (!$includeInternal) {
            $query->public();
        }

        return $query->orderBy('created_at', 'asc')->get();
    }

    /**
     * Add comment
     */
    public function addComment(int $reportId, int $userId, string $comment, bool $isInternal = false): ReportComment
    {
        return ReportComment::create([
            'report_id' => $reportId,
            'user_id' => $userId,
            'comment' => $comment,
            'is_internal' => $isInternal,
        ]);
    }

    /**
     * Delete comment
     */
    public function delete(int $id, int $userId): bool
    {
        $comment = ReportComment::find($id);

        if (!$comment) {
            return false;
        }

        // Only owner can delete
        if ($comment->user_id !== $userId) {
            throw new \Exception('Unauthorized');
        }

        return $comment->delete();
    }
}