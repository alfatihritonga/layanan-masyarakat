<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResponLaporan;
use Illuminate\Http\Request;

class ResponController extends Controller
{
    public function assignRelawan(Request $request, ResponLaporan $respon)
    {
        $validated = $request->validate([
            'relawan'           => 'required|array',
            'relawan.*.id'      => 'required|exists:relawan,id',
            'relawan.*.peran'   => 'required|string|max:100',
        ]);

        $syncData = [];

        foreach ($validated['relawan'] as $item) {
            $syncData[$item['id']] = [
                'peran' => $item['peran'],
            ];
        }

        // syncWithoutDetaching → tidak hapus relawan lama
        $respon->relawan()->syncWithoutDetaching($syncData);

        return back()->with('success', 'Relawan berhasil ditugaskan.');
    }
}
