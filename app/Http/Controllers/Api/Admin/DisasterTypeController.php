<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDisasterTypeRequest;
use App\Http\Requests\UpdateDisasterTypeRequest;
use App\Http\Resources\DisasterTypeResource;
use App\Services\DisasterTypeService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class DisasterTypeController extends Controller
{
    use ApiResponse;

    public function __construct(
        private DisasterTypeService $disasterTypeService
    ) {}

    /**
     * Get all disaster types
     */
    public function index(): JsonResponse
    {
        $disasterTypes = $this->disasterTypeService->getAll();

        return $this->successResponse(
            DisasterTypeResource::collection($disasterTypes),
            'Daftar jenis bencana berhasil diambil'
        );
    }

    /**
     * Create disaster type
     */
    public function store(StoreDisasterTypeRequest $request): JsonResponse
    {
        $disasterType = $this->disasterTypeService->create($request->validated());

        return $this->resourceResponse(
            new DisasterTypeResource($disasterType),
            'Jenis bencana berhasil dibuat',
            201
        );
    }

    /**
     * Get disaster type detail
     */
    public function show(int $id): JsonResponse
    {
        $disasterType = $this->disasterTypeService->findById($id);

        if (!$disasterType) {
            return $this->notFoundResponse('Jenis bencana tidak ditemukan');
        }

        return $this->resourceResponse(
            new DisasterTypeResource($disasterType),
            'Detail jenis bencana berhasil diambil'
        );
    }

    /**
     * Update disaster type
     */
    public function update(UpdateDisasterTypeRequest $request, int $id): JsonResponse
    {
        $updated = $this->disasterTypeService->update($id, $request->validated());

        if (!$updated) {
            return $this->notFoundResponse('Jenis bencana tidak ditemukan');
        }

        $disasterType = $this->disasterTypeService->findById($id);

        return $this->resourceResponse(
            new DisasterTypeResource($disasterType),
            'Jenis bencana berhasil diperbarui'
        );
    }

    /**
     * Delete disaster type
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->disasterTypeService->delete($id);

            if (!$deleted) {
                return $this->notFoundResponse('Jenis bencana tidak ditemukan');
            }

            return $this->successResponse(null, 'Jenis bencana berhasil dihapus');
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal menghapus: ' . $e->getMessage(), 422);
        }
    }
}