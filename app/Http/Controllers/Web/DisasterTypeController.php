<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDisasterTypeRequest;
use App\Http\Requests\UpdateDisasterTypeRequest;
use App\Services\DisasterTypeService;
use Illuminate\Http\Request;

class DisasterTypeController extends Controller
{
    public function __construct(
        private DisasterTypeService $disasterTypeService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search']);
        $disasterTypes = $this->disasterTypeService->getAllPaginated($filters, 10);

        return view('disaster-types.index', compact('disasterTypes', 'filters'));
    }

    public function create()
    {
        return view('disaster-types.create');
    }

    public function store(StoreDisasterTypeRequest $request)
    {
        $this->disasterTypeService->create($request->validated());

        return redirect()
            ->route('disaster-types.index')
            ->with('success', 'Jenis bencana berhasil ditambahkan');
    }

    public function show(int $id)
    {
        $disasterType = $this->disasterTypeService->findById($id);

        if (!$disasterType) {
            abort(404, 'Jenis bencana tidak ditemukan');
        }

        return view('disaster-types.show', compact('disasterType'));
    }

    public function edit(int $id)
    {
        $disasterType = $this->disasterTypeService->findById($id);

        if (!$disasterType) {
            abort(404, 'Jenis bencana tidak ditemukan');
        }

        return view('disaster-types.edit', compact('disasterType'));
    }

    public function update(UpdateDisasterTypeRequest $request, int $id)
    {
        $updated = $this->disasterTypeService->update($id, $request->validated());

        if (!$updated) {
            abort(404, 'Jenis bencana tidak ditemukan');
        }

        return redirect()
            ->route('disaster-types.index')
            ->with('success', 'Jenis bencana berhasil diperbarui');
    }

    public function destroy(int $id)
    {
        try {
            $deleted = $this->disasterTypeService->delete($id);

            if (!$deleted) {
                abort(404, 'Jenis bencana tidak ditemukan');
            }

            return redirect()
                ->route('disaster-types.index')
                ->with('success', 'Jenis bencana berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('disaster-types.index')
                ->with('error', 'Gagal menghapus jenis bencana: ' . $e->getMessage());
        }
    }
}
