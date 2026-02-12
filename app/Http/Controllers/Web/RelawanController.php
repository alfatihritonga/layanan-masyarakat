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

        return view('relawan.index', compact('relawan', 'filters'));
    }

    public function create()
    {
        return view('relawan.create');
    }

    public function store(StoreRelawanRequest $request)
    {
        $data = $request->validated();
        $manualSkills = collect(explode(',', $data['skill_manual'] ?? ''))
            ->map(fn ($skill) => trim($skill))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $skills = array_values(array_unique(array_merge($data['skill'] ?? [], $manualSkills)));
        $data['skill'] = $skills ?: null;
        unset($data['skill_manual']);

        $this->relawanService->create($data);

        return redirect()
            ->route('relawan.index')
            ->with('success', 'Relawan berhasil ditambahkan');
    }

    public function show(int $id)
    {
        $relawan = $this->relawanService->findById($id);

        if (!$relawan) {
            abort(404, 'Relawan tidak ditemukan');
        }

        $relawan->load([
            'assignments' => fn ($query) => $query
                ->with(['report.disasterType', 'assigner'])
                ->latest('assigned_at')
                ->latest('created_at'),
        ]);

        return view('relawan.show', compact('relawan'));
    }

    public function edit(int $id)
    {
        $relawan = $this->relawanService->findById($id);

        if (!$relawan) {
            abort(404, 'Relawan tidak ditemukan');
        }

        return view('relawan.edit', compact('relawan'));
    }

    public function update(UpdateRelawanRequest $request, int $id)
    {
        $updated = $this->relawanService->update($id, $request->validated());

        if (!$updated) {
            abort(404, 'Relawan tidak ditemukan');
        }

        return redirect()
            ->route('relawan.index')
            ->with('success', 'Relawan berhasil diupdate');
    }

    public function destroy(int $id)
    {
        $deleted = $this->relawanService->delete($id);

        if (!$deleted) {
            abort(404, 'Relawan tidak ditemukan');
        }

        return redirect()
            ->route('relawan.index')
            ->with('success', 'Relawan berhasil dihapus');
    }
}
