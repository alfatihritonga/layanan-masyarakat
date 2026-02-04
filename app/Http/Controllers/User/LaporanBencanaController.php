<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LaporanBencana;
use Illuminate\Http\Request;

class LaporanBencanaController extends Controller
{
    public function index()
    {
        $laporans = LaporanBencana::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('user.laporan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_bencana'      => 'required|in:banjir,gempa_bumi,tanah_longsor,kebakaran,tsunami,gunung_meletus,angin_puting_beliung,kekeringan,lainnya',
            'deskripsi'          => 'required|string|min:10',
            'lokasi'             => 'required|string|max:255',
            'tanggal_kejadian'   => 'required|date|before_or_equal:today',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'korban_jiwa'        => 'nullable|integer|min:0',
            'korban_luka'        => 'nullable|integer|min:0',
            'kerugian_material'  => 'nullable|string|max:255',
        ]);

        $data = [
            'user_id'           => auth()->id(),
            'jenis_bencana'     => $validated['jenis_bencana'],
            'deskripsi'         => $validated['deskripsi'],
            'lokasi'            => $validated['lokasi'],
            'tanggal_kejadian'  => $validated['tanggal_kejadian'],
            'status'            => 'pending',

            // JSON dampak
            'dampak' => [
                'korban_jiwa'       => (int) ($validated['korban_jiwa'] ?? 0),
                'korban_luka'       => (int) ($validated['korban_luka'] ?? 0),
                'kerugian_material' => $validated['kerugian_material'] ?? null,
            ],
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('laporan-bencana', 'public');
        }

        LaporanBencana::create($data);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Laporan bencana berhasil dikirim.');
    }

    public function show(LaporanBencana $laporan)
    {
        abort_if($laporan->user_id !== auth()->id(), 403);

        $laporan->load('respon.user');

        return view('user.laporan.show', compact('laporan'));
    }
}
