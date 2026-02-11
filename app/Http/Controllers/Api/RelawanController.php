<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelawanRequest;
use App\Http\Requests\UpdateRelawanRequest;
use App\Http\Resources\RelawanResource;
use App\Services\RelawanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function __construct(
        private RelawanService $relawanService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'status', 'kabupaten', 'tahun']);
        $perPage = $request->input('per_page', 15);
        
        $relawan = $this->relawanService->getAllPaginated($filters, $perPage);

        return response()->json([
            'success' => true,
            'data' => RelawanResource::collection($relawan),
            'meta' => [
                'current_page' => $relawan->currentPage(),
                'last_page' => $relawan->lastPage(),
                'per_page' => $relawan->perPage(),
                'total' => $relawan->total(),
            ]
        ]);
    }

    public function store(StoreRelawanRequest $request): JsonResponse
    {
        $relawan = $this->relawanService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Relawan berhasil ditambahkan',
            'data' => new RelawanResource($relawan)
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $relawan = $this->relawanService->findById($id);

        if (!$relawan) {
            return response()->json([
                'success' => false,
                'message' => 'Relawan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new RelawanResource($relawan)
        ]);
    }

    public function update(UpdateRelawanRequest $request, int $id): JsonResponse
    {
        $updated = $this->relawanService->update($id, $request->validated());

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Relawan tidak ditemukan'
            ], 404);
        }

        $relawan = $this->relawanService->findById($id);

        return response()->json([
            'success' => true,
            'message' => 'Relawan berhasil diupdate',
            'data' => new RelawanResource($relawan)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->relawanService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Relawan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Relawan berhasil dihapus'
        ]);
    }

    public function statistics(): JsonResponse
    {
        $stats = $this->relawanService->getStatistics();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}