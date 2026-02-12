@extends('layouts.app')

@section('title', 'Data Relawan')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Data Relawan'],
    ];

    $statusOptions = [
        'available' => 'Tersedia',
        'on_duty' => 'Sedang Bertugas',
        'unavailable' => 'Tidak Tersedia',
    ];

    $statusBadges = [
        'available' => 'badge-success',
        'on_duty' => 'badge-primary',
        'unavailable' => 'badge-error',
    ];

    $currentRelawan = $relawan->getCollection();
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold">Data Relawan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data relawan untuk operasional penanganan bencana</p>
        </div>
        <a href="{{ route('relawan.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Relawan
        </a>
    </div>

    <div class="stats stats-vertical md:stats-horizontal shadow w-full bg-base-100">
        <div class="stat">
            <div class="stat-title">Total Data</div>
            <div class="stat-value text-primary">{{ $relawan->total() }}</div>
            <div class="stat-desc">Semua relawan</div>
        </div>
        <div class="stat">
            <div class="stat-title">Tersedia (halaman ini)</div>
            <div class="stat-value text-success">{{ $currentRelawan->where('status_ketersediaan', 'available')->count() }}</div>
            <div class="stat-desc">Siap ditugaskan</div>
        </div>
        <div class="stat">
            <div class="stat-title">Sedang Bertugas (halaman ini)</div>
            <div class="stat-value text-primary">{{ $currentRelawan->where('status_ketersediaan', 'on_duty')->count() }}</div>
            <div class="stat-desc">Sedang aktif di lapangan</div>
        </div>
        <div class="stat">
            <div class="stat-title">Tidak Tersedia (halaman ini)</div>
            <div class="stat-value text-error">{{ $currentRelawan->where('status_ketersediaan', 'unavailable')->count() }}</div>
            <div class="stat-desc">Tidak dapat ditugaskan</div>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form method="GET" action="{{ route('relawan.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                <div class="form-control xl:col-span-2">
                    <label class="label"><span class="label-text">Cari</span></label>
                    <input
                        type="text"
                        name="search"
                        class="input input-bordered"
                        placeholder="Nama, email, atau no HP"
                        value="{{ $filters['search'] ?? '' }}"
                    >
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Status</span></label>
                    <select name="status" class="select select-bordered">
                        <option value="">Semua</option>
                        @foreach($statusOptions as $statusValue => $statusLabel)
                            <option value="{{ $statusValue }}" {{ ($filters['status'] ?? '') === $statusValue ? 'selected' : '' }}>
                                {{ $statusLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Kabupaten/Kota</span></label>
                    <input
                        type="text"
                        name="kabupaten"
                        class="input input-bordered"
                        placeholder="Contoh: Kota Medan"
                        value="{{ $filters['kabupaten'] ?? '' }}"
                    >
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Tahun Bergabung</span></label>
                    <input
                        type="number"
                        name="tahun"
                        class="input input-bordered"
                        min="2000"
                        max="{{ now()->year }}"
                        value="{{ $filters['tahun'] ?? '' }}"
                    >
                </div>

                <div class="form-control md:col-span-2 xl:col-span-5">
                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('relawan.index') }}" class="btn btn-ghost">Reset</a>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Wilayah</th>
                            <th>Status</th>
                            <th>Skill</th>
                            <th>Tahun</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($relawan as $item)
                            @php
                                $skills = is_array($item->skill) ? $item->skill : [];
                            @endphp
                            <tr>
                                <td>{{ $relawan->firstItem() ? $relawan->firstItem() + $loop->index : $loop->iteration }}</td>
                                <td>
                                    <div class="font-semibold">{{ $item->nama }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $item->id }}</div>
                                </td>
                                <td>
                                    <div>{{ $item->no_hp }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->email }}</div>
                                </td>
                                <td>
                                    <div>{{ $item->kecamatan }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->kabupaten_kota }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $statusBadges[$item->status_ketersediaan] ?? 'badge-ghost' }}">
                                        {{ $statusOptions[$item->status_ketersediaan] ?? ucfirst($item->status_ketersediaan) }}
                                    </span>
                                </td>
                                <td>
                                    @if(count($skills) > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($skills as $skill)
                                                <span class="badge badge-outline badge-sm">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->tahun_bergabung }}</td>
                                <td>
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('relawan.show', $item->id) }}" class="btn btn-ghost btn-xs">Detail</a>
                                        <a href="{{ route('relawan.edit', $item->id) }}" class="btn btn-ghost btn-xs">Edit</a>
                                        <form method="POST" action="{{ route('relawan.destroy', $item->id) }}" onsubmit="return confirm('Hapus relawan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-500 py-10">Data relawan tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($relawan->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $relawan->appends($filters)->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
