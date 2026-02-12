<?php

namespace App\Services;

use App\Models\DisasterType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DisasterTypeService
{
    /**
     * Get all disaster types
     */
    public function getAll(): Collection
    {
        return DisasterType::orderBy('name')->get();
    }

    /**
     * Get paginated disaster types with filters
     */
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = DisasterType::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name')->paginate($perPage);
    }

    /**
     * Find by ID
     */
    public function findById(int $id): ?DisasterType
    {
        return DisasterType::find($id);
    }

    /**
     * Create disaster type
     */
    public function create(array $data): DisasterType
    {
        return DisasterType::create($data);
    }

    /**
     * Update disaster type
     */
    public function update(int $id, array $data): bool
    {
        $disasterType = $this->findById($id);

        if (!$disasterType) {
            return false;
        }

        return $disasterType->update($data);
    }

    /**
     * Delete disaster type
     */
    public function delete(int $id): bool
    {
        $disasterType = $this->findById($id);

        if (!$disasterType) {
            return false;
        }

        // Check if has reports
        if ($disasterType->reports()->count() > 0) {
            throw new \Exception('Cannot delete disaster type with existing reports');
        }

        return $disasterType->delete();
    }
}