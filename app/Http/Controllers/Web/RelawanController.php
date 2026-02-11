<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelawanRequest;
use App\Http\Requests\UpdateRelawanRequest;
use App\Services\RelawanService;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function __construct(
        private RelawanService $relawanService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'kabupaten', 'tahun']);
        $relawan = $this->relawanService->getAllPaginated($filters, 10);

        return view('admin.relawan.index', compact('relawan', 'filters'));
    }

    public function create()
    {
        return view('admin.relawan.create');
    }

    public function store(StoreRelawanRequest $request)
    {
        $this->relawanService->create($request->validated());

        return redirect()
            ->route('admin.relawan.index')
            ->with('success', 'Relawan berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $relawan = $this->relawanService->findById($id);

        if (!$relawan) {
            abort(404, 'Relawan tidak ditemukan');
        }

        return view('admin.relawan.edit', compact('relawan'));
    }

    public function update(UpdateRelawanRequest $request, int $id)
    {
        $updated = $this->relawanService->update($id, $request->validated());

        if (!$updated) {
            abort(404, 'Relawan tidak ditemukan');
        }

        return redirect()
            ->route('admin.relawan.index')
            ->with('success', 'Relawan berhasil diupdate');
    }

    public function destroy(int $id)
    {
        $deleted = $this->relawanService->delete($id);

        if (!$deleted) {
            abort(404, 'Relawan tidak ditemukan');
        }

        return redirect()
            ->route('admin.relawan.index')
            ->with('success', 'Relawan berhasil dihapus');
    }
}