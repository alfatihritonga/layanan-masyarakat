@extends('layouts.app')

@section('title', 'Detail Relawan')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Data Relawan', 'url' => route('relawan.index')],
        ['title' => 'Detail Relawan'],
    ];

    $statusConfig = [
        'available' => ['label' => 'Tersedia', 'class' => 'badge-success'],
        'on_duty' => ['label' => 'Sedang Bertugas', 'class' => 'badge-primary'],
        'unavailable' => ['label' => 'Tidak Tersedia', 'class' => 'badge-error'],
    ];

    $assignmentStatusConfig = [
        'assigned' => ['label' => 'Ditugaskan', 'class' => 'badge-info'],
        'on_the_way' => ['label' => 'Menuju Lokasi', 'class' => 'badge-warning'],
        'on_site' => ['label' => 'Di Lokasi', 'class' => 'badge-primary'],
        'completed' => ['label' => 'Selesai', 'class' => 'badge-success'],
        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'badge-error'],
    ];

    $status = $statusConfig[$relawan->status_ketersediaan] ?? [
        'label' => ucfirst($relawan->status_ketersediaan),
        'class' => 'badge-ghost',
    ];

    $skills = is_array($relawan->skill) ? $relawan->skill : [];
    $activeAssignments = $relawan->assignments->whereIn('status', ['assigned', 'on_the_way', 'on_site'])->count();
    $completedAssignments = $relawan->assignments->where('status', 'completed')->count();
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
        <a href="{{ route('relawan.index') }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Relawan
        </a>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('relawan.edit', $relawan->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <form method="POST" action="{{ route('relawan.destroy', $relawan->id) }}" onsubmit="return confirm('Hapus relawan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-sm">Hapus</button>
            </form>
        </div>
    </div>

    <div class="stats stats-vertical md:stats-horizontal shadow w-full bg-base-100">
        <div class="stat">
            <div class="stat-title">Status Ketersediaan</div>
            <div class="stat-value text-lg">
                <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
            </div>
            <div class="stat-desc">Kondisi relawan saat ini</div>
        </div>
        <div class="stat">
            <div class="stat-title">Total Penugasan</div>
            <div class="stat-value text-primary">{{ $relawan->assignments->count() }}</div>
            <div class="stat-desc">Riwayat penugasan relawan</div>
        </div>
        <div class="stat">
            <div class="stat-title">Penugasan Aktif</div>
            <div class="stat-value text-warning">{{ $activeAssignments }}</div>
            <div class="stat-desc">Masih berjalan</div>
        </div>
        <div class="stat">
            <div class="stat-title">Penugasan Selesai</div>
            <div class="stat-value text-success">{{ $completedAssignments }}</div>
            <div class="stat-desc">Sudah diselesaikan</div>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body space-y-5">
            <div class="flex items-center justify-between gap-3 border-b border-base-200 pb-4">
                <div>
                    <h1 class="text-2xl font-bold">{{ $relawan->nama }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Relawan ID #{{ $relawan->id }}</p>
                </div>
                <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-semibold text-gray-500">No HP</div>
                        <div class="mt-1">{{ $relawan->no_hp }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Email</div>
                        <div class="mt-1">{{ $relawan->email }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Alamat</div>
                        <div class="mt-1 whitespace-pre-line">{{ $relawan->alamat }}</div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Kecamatan</div>
                        <div class="mt-1">{{ $relawan->kecamatan }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Kabupaten/Kota</div>
                        <div class="mt-1">{{ $relawan->kabupaten_kota }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Tahun Bergabung</div>
                        <div class="mt-1">{{ $relawan->tahun_bergabung }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Masa Kerja</div>
                        <div class="mt-1">{{ $relawan->masa_kerja }} tahun</div>
                    </div>
                </div>
            </div>

            <div>
                <div class="text-sm font-semibold text-gray-500 mb-2">Skill</div>
                @if(count($skills) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($skills as $skill)
                            <span class="badge badge-outline">{{ $skill }}</span>
                        @endforeach
                    </div>
                @else
                    <div class="text-sm text-gray-500">Belum ada data skill.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="p-6 pb-0">
                <h2 class="text-xl font-bold">Riwayat Penugasan</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar penugasan relawan untuk laporan bencana</p>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Laporan</th>
                            <th>Jenis Bencana</th>
                            <th>Status</th>
                            <th>Ditugaskan</th>
                            <th>Catatan</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($relawan->assignments as $assignment)
                            @php
                                $assignmentStatus = $assignmentStatusConfig[$assignment->status] ?? [
                                    'label' => ucfirst(str_replace('_', ' ', $assignment->status)),
                                    'class' => 'badge-ghost',
                                ];
                                $report = $assignment->report;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($report)
                                        <span class="font-mono text-xs">#{{ $report->id }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>{{ $report?->disasterType?->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $assignmentStatus['class'] }}">{{ $assignmentStatus['label'] }}</span>
                                </td>
                                <td>
                                    <div>{{ $assignment->assigned_at?->format('d M Y, H:i') ?? $assignment->created_at->format('d M Y, H:i') }}</div>
                                    @if($assignment->assigner)
                                        <div class="text-xs text-gray-500">oleh {{ $assignment->assigner->name }}</div>
                                    @endif
                                </td>
                                <td class="max-w-xs">
                                    @if($assignment->completion_notes)
                                        <div class="text-xs">
                                            <span class="font-semibold">Selesai:</span>
                                            {{ \Illuminate\Support\Str::limit($assignment->completion_notes, 90) }}
                                        </div>
                                    @elseif($assignment->notes)
                                        <div class="text-xs">{{ \Illuminate\Support\Str::limit($assignment->notes, 90) }}</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-end">
                                        @if($report)
                                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-ghost btn-xs">Lihat Laporan</a>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-10">Relawan ini belum memiliki riwayat penugasan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
