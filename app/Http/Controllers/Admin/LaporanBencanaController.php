<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanBencana;
use App\Models\Relawan;
use App\Models\ResponLaporan;
use Illuminate\Http\Request;

class LaporanBencanaController extends Controller
{
    public function index()
    {
        $laporans = LaporanBencana::latest()->paginate(10);

        return view('admin.laporan.index', compact('laporans'));
    }

    public function show(LaporanBencana $laporan)
    {
        $relawans = Relawan::all();
        return view('admin.laporan.show', compact('laporan', 'relawans'));
    }

    public function verifikasi(Request $request, LaporanBencana $laporan)
    {
        $validated = $request->validate([
        'komentar'       => 'required|string|min:5',
        'status_respon'  => 'required|in:in_progress,completed',
        'tindakan'       => 'nullable|array',
    ]);

    $respon = ResponLaporan::create([
        'laporan_id'    => $laporan->id,
        'user_id'       => auth()->id(),
        'komentar'      => $validated['komentar'],
        'status_respon' => $validated['status_respon'],
        'tindakan'      => $validated['tindakan'] ?? [],
    ]);

    /* ===== UPDATE STATUS LAPORAN ===== */
    if ($laporan->status === 'pending') {
        $laporan->update(['status' => 'verified']);
    }

    if ($validated['status_respon'] === 'completed') {
        $laporan->update(['status' => 'resolved']);
    }

    /* ===== AUTO UPDATE STATUS RELAWAN ===== */
    $respon->load('relawan');

    foreach ($respon->relawan as $relawan) {
        if ($validated['status_respon'] === 'in_progress') {
            if ($relawan->status_ketersediaan === 'available') {
                $relawan->update([
                    'status_ketersediaan' => 'on_duty',
                ]);
            }
        }

        if ($validated['status_respon'] === 'completed') {
            if ($relawan->status_ketersediaan === 'on_duty') {
                $relawan->update([
                    'status_ketersediaan' => 'available',
                ]);
            }
        }
    }

    return back()->with('success', 'Respon berhasil disimpan.');
    }
}
