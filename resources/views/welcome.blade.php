@extends('layouts.guest')

@section('title', 'SIGAP Bencana - Sistem Informasi Tanggap Bencana')

@section('content')
@php
    $reports = $landingStats['reports'] ?? [];
    $topDisasterTypes = collect($landingStats['top_disaster_types'] ?? []);
    $yearRange = $landingStats['year_range'] ?? ['start' => now()->year, 'end' => now()->year];
    $trend = $landingStats['trend'] ?? ['years' => [], 'totals' => [], 'max' => 0];
    $yearlyTable = collect($landingStats['table'] ?? []);
    $cta = $cta ?? [
        'route' => auth()->check()
            ? (auth()->user()->isAdmin() ? route('dashboard') : route('user.dashboard'))
            : route('login'),
        'label' => auth()->check()
            ? (auth()->user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard Saya')
            : 'Lapor Bencana',
    ];
@endphp

<div class="min-h-screen bg-slate-950 text-white">
    <nav class="navbar navbar-glass">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="#beranda" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.356 3.066a1 1 0 0 0-.712 0l-7 2.666A1 1 0 0 0 4 6.68a17.695 17.695 0 0 0 2.022 7.98 17.405 17.405 0 0 0 5.403 6.158 1 1 0 0 0 1.15 0 17.406 17.406 0 0 0 5.402-6.157A17.694 17.694 0 0 0 20 6.68a1 1 0 0 0-.644-.949l-7-2.666Z"/>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <span class="navbar-brand">SIGAP BENCANA</span>
                        <span class="block text-xs text-white/70 font-medium -mt-1">Sistem Informasi Tanggap Bencana</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-2">
                    <a href="#beranda" class="navbar-link">Beranda</a>
                    <a href="#statistik" class="navbar-link">Statistik Bencana</a>
                </div>

                <a href="{{ $cta['route'] }}" class="hidden md:flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-all duration-200">
                    <span>{{ $cta['label'] }}</span>
                </a>

                <button class="md:hidden p-2 text-white hover:bg-white/10 rounded-lg transition-colors" aria-label="Toggle menu">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <section id="beranda" class="hero-section pt-20">
        <div class="hero-overlay"></div>
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative z-10 container mx-auto px-4 text-center">
            <h1 class="hero-title">
                Respon cepat laporan bencana untuk keselamatan bersama
            </h1>

            <p class="hero-subtitle">
                Laporkan kejadian bencana secara real-time, pantau status penanganan, dan terima update terbaru dari tim tanggap darurat.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
                <a href="{{ $cta['route'] }}" class="btn-emergency pulse-emergency">
                    {{ $cta['label'] }}
                </a>
                <a href="#statistik" class="inline-flex items-center gap-2 px-6 py-4 text-white/90 hover:text-white font-medium transition-colors">
                    Lihat Statistik Bencana
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m20 9-8 8-8-8"></path></svg>
                </a>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-5" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.75v2m0 12.5A6.25 6.25 0 0 1 5.75 15V9a6.25 6.25 0 1 1 12.5 0v6A6.25 6.25 0 0 1 12 21.25"></path></svg>
        </div>
    </section>

    <section id="statistik" class="py-20 bg-white/5">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/20 text-primary rounded-full text-sm font-medium mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 25" class="intentui-icons size-5" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m16 22.5-.857-3M8 22.5l.857-3m-1.107-6V15M12 8.5V15m4.25-3.5V15m5-10.5V19H2.75V4.5z"></path></svg>
                    Data & Statistik
                </div>
                <h2 class="section-title">Statistik Bencana</h2>
                <p class="section-subtitle max-w-2xl mx-auto">
                    Ringkasan data kejadian bencana ({{ $yearRange['start'] }}-{{ $yearRange['end'] }})
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-6" data-slot="icon" aria-hidden="true"><path fill="currentColor" d="m20.97 6.202-8.25-4.514a1.49 1.49 0 0 0-1.44 0L3.03 6.204a1.5 1.5 0 0 0-.78 1.312v8.966a1.5 1.5 0 0 0 .78 1.313l8.25 4.516a1.49 1.49 0 0 0 1.44 0l8.25-4.516a1.5 1.5 0 0 0 .78-1.313V7.517a1.5 1.5 0 0 0-.78-1.315M12 3l7.532 4.125-2.791 1.528-7.533-4.125zm0 8.25L4.468 7.125l3.178-1.74 7.532 4.125zM3.75 8.438l7.5 4.104v8.043l-7.5-4.102zm16.5 8.042-7.5 4.105v-8.04l3-1.64v3.345a.75.75 0 1 0 1.5 0v-4.167l3-1.645z"></path></svg>
                        <span class="text-xs font-medium bg-white/20 px-2 py-1 rounded-full">Total</span>
                    </div>
                    <div class="text-4xl font-bold mb-1">{{ number_format($reports['total'] ?? 0) }}</div>
                    <div class="text-white/80 text-sm">Total Laporan Masuk</div>
                </div>

                <div class="stat-card-danger">
                    <div class="flex items-center justify-between mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-6" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.528 17.25 1.75 20.107m5-.571L5.083 21.25m-2.333-9s3.77 1.77 5.5 3.5 3.5 5.5 3.5 5.5l3.18-2.953a1 1 0 0 0 .32-.733V15c4-2 6.5-5.25 6-12.25-7-.5-10.25 2-12.25 6H6.436a1 1 0 0 0-.733.32zm14.5-3.75a1.75 1.75 0 1 1-3.5 0 1.75 1.75 0 0 1 3.5 0"></path></svg>
                        <span class="text-xs font-medium bg-white/20 px-2 py-1 rounded-full">Proses</span>
                    </div>
                    <div class="text-4xl font-bold mb-1">{{ number_format($reports['in_progress'] ?? 0) }}</div>
                    <div class="text-white/80 text-sm">Sedang Ditangani</div>
                </div>

                <div class="stat-card-warning">
                    <div class="flex items-center justify-between mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-6" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6 9 17l-5-5"></path></svg>
                        <span class="text-xs font-medium bg-white/20 px-2 py-1 rounded-full">Selesai</span>
                    </div>
                    <div class="text-4xl font-bold mb-1">{{ number_format($reports['resolved'] ?? 0) }}</div>
                    <div class="text-white/80 text-sm">Laporan Terselesaikan</div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-6" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5v14m-5.996-8L3 19M21 8v11m-6.002-5v5"></path></svg>
                        <span class="text-xs font-medium bg-white/20 px-2 py-1 rounded-full">Aktif</span>
                    </div>
                    <div class="text-4xl font-bold mb-1">{{ number_format($reports['active'] ?? 0) }}</div>
                    <div class="text-white/80 text-sm">Laporan Aktif</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-6">Tren Kejadian Bencana per Tahun</h3>
                    <div class="h-64">
                        <canvas
                            id="yearlyTrendChart"
                            data-years='@json($trend['years'])'
                            data-totals='@json($trend['totals'])'
                        ></canvas>
                    </div>
                    <p class="text-xs text-white/50 mt-4 text-center">* Data berdasarkan laporan masuk per tahun</p>
                </div>

                <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-6">Jenis Bencana ({{ $yearRange['end'] }})</h3>
                    <div class="space-y-4">
                        @forelse($topDisasterTypes as $type)
                            @php
                                $percentage = ($reports['total'] ?? 0) > 0 ? round(($type['total'] / $reports['total']) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 2l10 18H2L12 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-medium text-white">{{ $type['disaster_type'] }}</span>
                                        <span class="text-sm text-white/60">{{ number_format($type['total']) }} kejadian</span>
                                    </div>
                                    <div class="w-full bg-white/10 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-primary w-12 text-right">{{ $percentage }}%</span>
                            </div>
                        @empty
                            <div class="text-center text-sm text-white/70">Belum ada data bencana.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white/5 rounded-2xl overflow-hidden border border-white/10">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-bold text-white">Data Kejadian per Tahun</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Jumlah Kejadian</th>
                                <th>Dominan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($yearlyTable as $row)
                                @php
                                    $highlight = (int) $row['year'] === (int) $yearRange['end'];
                                @endphp
                                <tr class="{{ $highlight ? 'bg-red-500/10' : '' }}">
                                    <td class="font-medium {{ $highlight ? 'text-red-300' : '' }}">{{ $row['year'] }}</td>
                                    <td class="{{ $highlight ? 'text-red-300 font-bold' : '' }}">{{ number_format($row['total']) }} kejadian</td>
                                    <td class="{{ $highlight ? 'text-red-300' : '' }}">{{ $row['dominant_type'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-white/60 py-6">Belum ada data kejadian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer footer-horizontal footer-center bg-slate-950 border-t border-white/10 text-white pt-16 pb-10 px-10">
        <aside>
            <svg class="w-[48px] h-[48px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.356 3.066a1 1 0 0 0-.712 0l-7 2.666A1 1 0 0 0 4 6.68a17.695 17.695 0 0 0 2.022 7.98 17.405 17.405 0 0 0 5.403 6.158 1 1 0 0 0 1.15 0 17.406 17.406 0 0 0 5.402-6.157A17.694 17.694 0 0 0 20 6.68a1 1 0 0 0-.644-.949l-7-2.666Z"/>
            </svg>
            <p class="font-bold">
                <span class="uppercase">
                    {{ config('app.name') }}
                </span>
            <br />
            Sistem Informasi Tanggap Bencana
            </p>
            <p>Copyright © {{ date('Y') }} - All right reserved</p>
        </aside>
        <nav>
            <div class="grid grid-flow-col gap-4">
            <a>
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                class="fill-current">
                <path
                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                </svg>
            </a>
            <a>
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                class="fill-current">
                <path
                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                </svg>
            </a>
            <a>
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                class="fill-current">
                <path
                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                </svg>
            </a>
            </div>
        </nav>
    </footer>
</div>
@endsection
