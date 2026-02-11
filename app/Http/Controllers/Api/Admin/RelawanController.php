<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelawanRequest;
use App\Http\Requests\UpdateRelawanRequest;
use App\Http\Resources\RelawanListResource;
use App\Http\Resources\RelawanResource;
use App\Services\RelawanService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    use ApiResponse;

    public function __construct(
        private RelawanService $relawanService
    ) {}

    /**
     * Get all relawan with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'status', 'kabupaten', 'tahun']);
        $perPage = $request->input('per_page', 15);

        $relawan = $this->relawanService->getAllPaginated($filters, $perPage);

        return $this->paginatedResponse(
            $relawan,
            RelawanListResource::class,
            'Daftar relawan berhasil diambil'
        );
    }

    /**
     * Create new relawan
     */
    public function store(StoreRelawanRequest $request): JsonResponse
    {
        $relawan = $this->relawanService->create($request->validated());

        return $this->resourceResponse(
            new RelawanResource($relawan),
            'Relawan berhasil ditambahkan',
            201
        );
    }

    /**
     * Get relawan detail
     */
    public function show(int $id): JsonResponse
    {
        $relawan = $this->relawanService->findById($id);

        if (!$relawan) {
            return $this->notFoundResponse('Relawan tidak ditemukan');
        }

        return $this->resourceResponse(
            new RelawanResource($relawan->load(['assignments', 'activeAssignments'])),
            'Detail relawan berhasil diambil'
        );
    }

    /**
     * Update relawan
     */
    public function update(UpdateRelawanRequest $request, int $id): JsonResponse
    {
        $updated = $this->relawanService->update($id, $request->validated());

        if (!$updated) {
            return $this->notFoundResponse('Relawan tidak ditemukan');
        }

        $relawan = $this->relawanService->findById($id);

        return $this->resourceResponse(
            new RelawanResource($relawan),
            'Relawan berhasil diperbarui'
        );
    }

    /**
     * Delete relawan
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->relawanService->delete($id);

        if (!$deleted) {
            return $this->notFoundResponse('Relawan tidak ditemukan');
        }

        return $this->successResponse(null, 'Relawan berhasil dihapus');
    }

    /**
     * Get available relawan
     */
    public function available(): JsonResponse
    {
        $relawan = $this->relawanService->getAll(['status' => 'available']);

        return $this->successResponse(
            RelawanListResource::collection($relawan),
            'Daftar relawan tersedia berhasil diambil'
        );
    }

    /**
     * Get relawan statistics
     */
    public function statistics(): JsonResponse
    {
        $statistics = $this->relawanService->getStatistics();

        return $this->successResponse(
            $statistics,
            'Statistik relawan berhasil diambil'
        );
    }
}