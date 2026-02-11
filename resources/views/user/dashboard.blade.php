@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="card bg-gradient-to-r from-primary to-secondary text-primary-content shadow-xl">
        <div class="card-body">
            <h1 class="card-title text-3xl">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-lg opacity-90">Anda dapat melaporkan kejadian bencana dan memantau status laporan Anda di sini.</p>
            <div class="card-actions mt-4">
                <a href="{{ route('user.reports.create') }}" class="btn btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Laporan Baru
                </a>
                <a href="{{ route('user.reports.index') }}" class="btn btn-ghost">
                    Lihat Laporan Saya
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full bg-base-100">
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="stat-title">Total Laporan</div>
            <div class="stat-value text-primary">{{ $statistics['total'] }}</div>
            <div class="stat-desc">Semua laporan yang dibuat</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Pending</div>
            <div class="stat-value text-warning">{{ $statistics['pending'] }}</div>
            <div class="stat-desc">Menunggu verifikasi</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="stat-title">Dalam Proses</div>
            <div class="stat-value text-info">{{ $statistics['in_progress'] }}</div>
            <div class="stat-desc">Sedang ditangani</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="stat-title">Selesai</div>
            <div class="stat-value text-success">{{ $statistics['resolved'] }}</div>
            <div class="stat-desc">Laporan selesai</div>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Laporan Terbaru -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="card-title">Laporan Terbaru Saya</h2>
                        <a href="{{ route('user.reports.index') }}" class="btn btn-ghost btn-sm">
                            Lihat Semua
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    @if($recent_reports->count() > 0)
                    <div class="space-y-3">
                        @foreach($recent_reports as $report)
                        <div class="card bg-base-200 hover:bg-base-300 transition cursor-pointer" onclick="window.location='{{ route('user.reports.show', $report->id) }}'">
                            <div class="card-body p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $report->disasterType->color ?? '#888' }}"></div>
                                            <h3 class="font-semibold">{{ $report->disasterType->name }}</h3>
                                            <x-badge status="{{ $report->status }}" class="badge-sm" />
                                        </div>
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $report->description }}</p>
                                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ Str::limit($report->location_address, 30) }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $report->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <x-badge urgency="{{ $report->urgency_level }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 mb-4">Belum ada laporan</p>
                        <a href="{{ route('user.reports.create') }}" class="btn btn-primary btn-sm">
                            Buat Laporan Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Informasi -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title text-lg">ℹ️ Informasi</h2>
                    <div class="space-y-3 text-sm">
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Laporan Anda akan segera diverifikasi oleh admin</span>
                        </div>
                        
                        <div class="space-y-2">
                            <p class="font-semibold">Status Laporan:</p>
                            <ul class="space-y-1 ml-4">
                                <li class="flex items-center gap-2">
                                    <x-badge status="pending" class="badge-sm" />
                                    <span class="text-xs">Menunggu verifikasi</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-badge status="verified" class="badge-sm" />
                                    <span class="text-xs">Sudah diverifikasi</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-badge status="in_progress" class="badge-sm" />
                                    <span class="text-xs">Sedang ditangani</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-badge status="resolved" class="badge-sm" />
                                    <span class="text-xs">Selesai ditangani</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panduan -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title text-lg">📝 Cara Melaporkan</h2>
                    <ol class="list-decimal list-inside space-y-2 text-sm">
                        <li>Klik tombol "Buat Laporan"</li>
                        <li>Pilih jenis bencana</li>
                        <li>Isi detail kejadian</li>
                        <li>Upload foto/video (maks 3)</li>
                        <li>Submit laporan</li>
                    </ol>
                    <a href="{{ route('user.reports.create') }}" class="btn btn-primary btn-sm mt-4">
                        Buat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection