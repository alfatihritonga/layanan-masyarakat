<?php

namespace App\Services;

use App\Models\Relawan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RelawanService
{
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Relawan::query();

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['status'])) {
            $query->where('status_ketersediaan', $filters['status']);
        }

        if (!empty($filters['kabupaten'])) {
            $query->byKabupaten($filters['kabupaten']);
        }

        if (!empty($filters['tahun'])) {
            $query->where('tahun_bergabung', $filters['tahun']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getAll(): Collection
    {
        return Relawan::all();
    }

    public function findById(int $id): ?Relawan
    {
        return Relawan::find($id);
    }

    public function create(array $data): Relawan
    {
        return Relawan::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $relawan = $this->findById($id);
        if (!$relawan) {
            return false;
        }

        return $relawan->update($data);
    }

    public function delete(int $id): bool
    {
        $relawan = $this->findById($id);
        if (!$relawan) {
            return false;
        }

        return $relawan->delete();
    }

    public function getStatistics(): array
    {
        return [
            'total' => Relawan::count(),
            'available' => Relawan::available()->count(),
            'on_duty' => Relawan::where('status_ketersediaan', 'on_duty')->count(),
            'unavailable' => Relawan::where('status_ketersediaan', 'unavailable')->count(),
            'by_kabupaten' => Relawan::selectRaw('kabupaten_kota, COUNT(*) as total')
                ->groupBy('kabupaten_kota')
                ->get(),
        ];
    }
}