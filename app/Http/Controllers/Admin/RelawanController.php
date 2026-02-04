<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Relawan;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function index()
    {
        $relawans = Relawan::latest()->paginate(10);
        return view('admin.relawan.index', compact('relawans'));
    }

    public function create()
    {
        return view('admin.relawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'            => 'nullable|exists:users,id',
            'nama'               => 'required|string|max:100',
            'no_hp'              => 'required|string|max:20',
            'email'              => 'required|email|unique:relawan,email',
            'alamat'             => 'required|string',
            'kecamatan'          => 'required|string|max:100',
            'kabupaten_kota'     => 'required|string|max:100',
            'status_ketersediaan'=> 'required|in:available,on_duty,unavailable',
            'skill'              => 'nullable|array',
            'skill.*'            => 'string|max:50',
            'tahun_bergabung'    => 'required|digits:4|integer|min:2000|max:' . date('Y'),
        ]);

        Relawan::create($validated);

        return redirect()
            ->route('admin.relawan.index')
            ->with('success', 'Relawan berhasil ditambahkan.');
    }

    public function edit(Relawan $relawan)
    {
        return view('admin.relawan.edit', compact('relawan'));
    }

    public function update(Request $request, Relawan $relawan)
    {
        $validated = $request->validate([
            'user_id'            => 'nullable|exists:users,id',
            'nama'               => 'required|string|max:100',
            'no_hp'              => 'required|string|max:20',
            'email'              => 'required|email|unique:relawan,email,' . $relawan->id,
            'alamat'             => 'required|string',
            'kecamatan'          => 'required|string|max:100',
            'kabupaten_kota'     => 'required|string|max:100',
            'status_ketersediaan'=> 'required|in:available,on_duty,unavailable',
            'skill'              => 'nullable|array',
            'skill.*'            => 'string|max:50',
            'tahun_bergabung'    => 'required|digits:4|integer|min:2000|max:' . date('Y'),
        ]);

        $relawan->update($validated);

        return redirect()
            ->route('admin.relawan.index')
            ->with('success', 'Data relawan diperbarui.');
    }

    public function destroy(Relawan $relawan)
    {
        $relawan->delete();

        return back()->with('success', 'Relawan berhasil dihapus.');
    }
}

