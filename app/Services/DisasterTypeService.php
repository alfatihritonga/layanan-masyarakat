<?php

namespace App\Services;

use App\Models\DisasterType;
use Illuminate\Database\Eloquent\Collection;

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