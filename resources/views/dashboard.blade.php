@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
        <div class="text-sm text-gray-500">
            {{ now()->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    <!-- Statistics Cards - Laporan -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full bg-base-100">
        <div class="stat">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Pending</div>
            <div class="stat-value text-warning">{{ $statistics['reports']['pending'] }}</div>
            <div class="stat-desc">Menunggu verifikasi</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Terverifikasi</div>
            <div class="stat-value text-info">{{ $statistics['reports']['verified'] }}</div>
            <div class="stat-desc">Sudah diverifikasi</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="stat-title">Dalam Proses</div>
            <div class="stat-value text-primary">{{ $statistics['reports']['in_progress'] }}</div>
            <div class="stat-desc">Sedang ditangani</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="stat-title">Selesai</div>
            <div class="stat-value text-success">{{ $statistics['reports']['resolved'] }}</div>
            <div class="stat-desc">Laporan selesai</div>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column - Laporan Berdasarkan Urgensi -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Laporan Berdasarkan Urgensi -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Laporan Berdasarkan Tingkat Urgensi</h2>
                    
                    <div class="space-y-3 mt-4">
                        <div class="flex items-center justify-between p-3 bg-error/10 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="badge badge-error badge-lg">Kritis</div>
                                <span class="font-semibold">{{ $statistics['reports']['by_urgency']['critical'] }} Laporan</span>
                            </div>
                            <div class="text-2xl font-bold text-error">
                                {{ $statistics['reports']['by_urgency']['critical'] }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-warning/10 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="badge badge-error badge-lg">Tinggi</div>
                                <span class="font-semibold">{{ $statistics['reports']['by_urgency']['high'] }} Laporan</span>
                            </div>
                            <div class="text-2xl font-bold text-error">
                                {{ $statistics['reports']['by_urgency']['high'] }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-warning/10 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="badge badge-warning badge-lg">Sedang</div>
                                <span class="font-semibold">{{ $statistics['reports']['by_urgency']['medium'] }} Laporan</span>
                            </div>
                            <div class="text-2xl font-bold text-warning">
                                {{ $statistics['reports']['by_urgency']['medium'] }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="badge badge-ghost badge-lg">Rendah</div>
                                <span class="font-semibold">{{ $statistics['reports']['by_urgency']['low'] }} Laporan</span>
                            </div>
                            <div class="text-2xl font-bold">
                                {{ $statistics['reports']['by_urgency']['low'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Berdasarkan Jenis Bencana -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Laporan Berdasarkan Jenis Bencana</h2>
                    
                    <div class="overflow-x-auto mt-4">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>Jenis Bencana</th>
                                    <th class="text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statistics['reports']['by_disaster_type'] as $item)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $item['disaster_type']->color ?? '#888' }}"></div>
                                            <span class="font-medium">{{ $item['disaster_type'] }}</span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-neutral">{{ $item['total'] }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-gray-500">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            
            <!-- Statistik Relawan -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Statistik Relawan</h2>
                    
                    <div class="stats stats-vertical shadow mt-4">
                        <div class="stat">
                            <div class="stat-title">Total Relawan</div>
                            <div class="stat-value text-2xl">{{ $statistics['relawan']['total'] }}</div>
                        </div>

                        <div class="stat">
                            <div class="stat-title">Tersedia</div>
                            <div class="stat-value text-2xl text-success">{{ $statistics['relawan']['available'] }}</div>
                        </div>

                        <div class="stat">
                            <div class="stat-title">Sedang Bertugas</div>
                            <div class="stat-value text-2xl text-primary">{{ $statistics['relawan']['on_duty'] }}</div>
                        </div>

                        <div class="stat">
                            <div class="stat-title">Tidak Tersedia</div>
                            <div class="stat-value text-2xl text-error">{{ $statistics['relawan']['unavailable'] }}</div>
                        </div>
                    </div>

                    <a href="{{ route('relawan.index') }}" class="btn btn-outline btn-sm mt-4">
                        Lihat Semua Relawan
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Quick Actions</h2>
                    
                    <div class="space-y-2 mt-4">
                        <a href="{{ route('reports.index') }}?status=pending" class="btn btn-outline btn-warning btn-block justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Laporan Pending ({{ $statistics['reports']['pending'] }})
                        </a>

                        <a href="{{ route('reports.index') }}?urgency_level=critical" class="btn btn-outline btn-error btn-block justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Laporan Kritis ({{ $statistics['reports']['by_urgency']['critical'] }})
                        </a>

                        <a href="{{ route('relawan.index') }}" class="btn btn-outline btn-primary btn-block justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Kelola Relawan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Terbaru -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h2 class="card-title">Laporan Terbaru</h2>
                <a href="{{ route('reports.index') }}" class="btn btn-ghost btn-sm">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jenis Bencana</th>
                            <th>Lokasi</th>
                            <th>Urgensi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics['reports']['recent_reports'] as $report)
                        <tr>
                            <td class="font-mono text-xs">#{{ $report->id }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $report->disasterType->color ?? '#888' }}"></div>
                                    <span class="font-medium">{{ $report->disasterType->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm truncate max-w-xs" title="{{ $report->location_address }}">
                                    {{ Str::limit($report->location_address, 40) }}
                                </div>
                            </td>
                            <td>
                                <x-badge urgency="{{ $report->urgency_level }}" />
                            </td>
                            <td>
                                <x-badge status="{{ $report->status }}" />
                            </td>
                            <td class="text-sm text-gray-500">
                                {{ $report->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <a href="{{ route('reports.show', $report->id) }}" class="btn btn-ghost btn-xs">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500">Tidak ada laporan terbaru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection