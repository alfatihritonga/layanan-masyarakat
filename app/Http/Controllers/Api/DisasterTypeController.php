<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}