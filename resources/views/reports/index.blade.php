@extends('layouts.app')

@section('title', 'Kelola Laporan Bencana')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Laporan Bencana</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan verifikasi laporan bencana dari masyarakat</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full bg-base-100">
        <a href="{{ route('reports.index', ['status' => 'pending']) }}" class="stat cursor-pointer hover:bg-base-200">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Pending</div>
            <div class="stat-value text-warning">{{ \App\Models\Report::where('status', 'pending')->count() }}</div>
            <div class="stat-desc">Menunggu verifikasi</div>
        </a>

        <a href="{{ route('reports.index', ['status' => 'verified']) }}" class="stat cursor-pointer hover:bg-base-200">
            <div class="stat-figure text-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Terverifikasi</div>
            <div class="stat-value text-info">{{ \App\Models\Report::where('status', 'verified')->count() }}</div>
            <div class="stat-desc">Siap ditugaskan</div>
        </a>

        <a href="{{ route('reports.index', ['status' => 'in_progress']) }}" class="stat cursor-pointer hover:bg-base-200">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="stat-title">Dalam Proses</div>
            <div class="stat-value text-primary">{{ \App\Models\Report::where('status', 'in_progress')->count() }}</div>
            <div class="stat-desc">Sedang ditangani</div>
        </a>

        <a href="{{ route('reports.index', ['status' => 'resolved']) }}" class="stat cursor-pointer hover:bg-base-200">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="stat-title">Selesai</div>
            <div class="stat-value text-success">{{ \App\Models\Report::where('status', 'resolved')->count() }}</div>
            <div class="stat-desc">Laporan selesai</div>
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Cari Laporan</span>
                        </label>
                        <input type="text" 
                               name="search"
                               value="{{ $filters['search'] ?? '' }}"
                               placeholder="Cari berdasarkan deskripsi, lokasi, atau nomor HP..." 
                               class="input input-bordered">
                    </div>

                    <!-- Status Filter -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Status</span>
                        </label>
                        <select name="status" class="select select-bordered">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ ($filters['status'] ?? '') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="in_progress" {{ ($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="resolved" {{ ($filters['status'] ?? '') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ ($filters['status'] ?? '') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <!-- Disaster Type Filter -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Jenis Bencana</span>
                        </label>
                        <select name="disaster_type_id" class="select select-bordered">
                            <option value="">Semua Jenis</option>
                            @foreach($disasterTypes as $type)
                            <option value="{{ $type->id }}" {{ ($filters['disaster_type_id'] ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Urgency Filter -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Urgensi</span>
                        </label>
                        <select name="urgency_level" class="select select-bordered">
                            <option value="">Semua Urgensi</option>
                            <option value="critical" {{ ($filters['urgency_level'] ?? '') == 'critical' ? 'selected' : '' }}>Kritis</option>
                            <option value="high" {{ ($filters['urgency_level'] ?? '') == 'high' ? 'selected' : '' }}>Tinggi</option>
                            <option value="medium" {{ ($filters['urgency_level'] ?? '') == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="low" {{ ($filters['urgency_level'] ?? '') == 'low' ? 'selected' : '' }}>Rendah</option>
                        </select>
                    </div>
                </div>

                <!-- Advanced Filters (Collapsible) -->
                <div x-data="{ show: {{ !empty($filters['date_from']) || !empty($filters['date_to']) ? 'true' : 'false' }} }">
                    <div x-show="show" x-collapse class="mt-4 pt-4 border-t">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Tanggal Dari</span>
                                </label>
                                <input type="date" 
                                       name="date_from" 
                                       value="{{ $filters['date_from'] ?? '' }}"
                                       class="input input-bordered">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Tanggal Sampai</span>
                                </label>
                                <input type="date" 
                                       name="date_to" 
                                       value="{{ $filters['date_to'] ?? '' }}"
                                       class="input input-bordered">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Urutkan</span>
                                </label>
                                <select name="sort_by" class="select select-bordered">
                                    <option value="created_at" {{ ($filters['sort_by'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                    <option value="incident_date" {{ ($filters['sort_by'] ?? '') == 'incident_date' ? 'selected' : '' }}>Tanggal Kejadian</option>
                                    <option value="urgency_level" {{ ($filters['sort_by'] ?? '') == 'urgency_level' ? 'selected' : '' }}>Urgensi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex justify-between items-center mt-4">
                        <button type="button" @click="show = !show" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            <span x-text="show ? 'Sembunyikan Filter' : 'Filter Lanjutan'"></span>
                        </button>

                        <div class="flex gap-2">
                            <a href="{{ route('reports.index') }}" class="btn btn-ghost btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelapor</th>
                            <th>Jenis Bencana</th>
                            <th>Lokasi</th>
                            <th>Urgensi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr class="hover">
                            <td>
                                <span class="font-mono text-xs">#{{ $report->id }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral text-neutral-content rounded-full w-8 items-center justify-center flex">
                                            @if($report->user->avatar)
                                            <img src="{{ $report->user->avatar }}" alt="{{ $report->user->name }}">
                                            @else
                                            <span class="text-xs">{{ $report->user->initials() }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-sm">{{ $report->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $report->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    {{-- <div class="w-3 h-3 rounded-full" style="background-color: {{ $report->disasterType->color ?? '#888' }}"></div> --}}
                                    <span class="status" style="background-color: {{ $report->disasterType->color ?? '#888' }}"></span>
                                    <span class="font-medium">{{ $report->disasterType->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="max-w-xs truncate text-sm" title="{{ $report->location_address }}">
                                    {{ Str::limit($report->location_address, 40) }}
                                </div>
                            </td>
                            <td>
                                <x-badge urgency="{{ $report->urgency_level }}" class="badge-sm" />
                            </td>
                            <td>
                                <x-badge status="{{ $report->status }}" class="badge-sm whitespace-nowrap" />
                            </td>
                            <td>
                                <div class="text-sm">{{ $report->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $report->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-ghost btn-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    
                                    @if($report->isPending())
                                    <button onclick="verifyModal_{{ $report->id }}.showModal()" class="btn btn-success btn-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button onclick="rejectModal_{{ $report->id }}.showModal()" class="btn btn-error btn-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Verify Modal -->
                        <dialog id="verifyModal_{{ $report->id }}" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg">Verifikasi Laporan #{{ $report->id }}</h3>
                                <form method="POST" action="{{ route('reports.verify', $report->id) }}">
                                    @csrf
                                    <div class="py-4 space-y-4">
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text">Tingkat Urgensi</span>
                                            </label>
                                            <select name="urgency_level" class="select select-bordered">
                                                <option value="">Tidak Diubah</option>
                                                <option value="low">Rendah</option>
                                                <option value="medium">Sedang</option>
                                                <option value="high">Tinggi</option>
                                                <option value="critical">Kritis</option>
                                            </select>
                                        </div>
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text">Catatan Admin (Opsional)</span>
                                            </label>
                                            <textarea name="admin_notes" rows="3" class="textarea textarea-bordered" placeholder="Catatan verifikasi..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-action">
                                        <button type="button" class="btn" onclick="verifyModal_{{ $report->id }}.close()">Batal</button>
                                        <button type="submit" class="btn btn-success">Verifikasi</button>
                                    </div>
                                </form>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>

                        <!-- Reject Modal -->
                        <dialog id="rejectModal_{{ $report->id }}" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg">Tolak Laporan #{{ $report->id }}</h3>
                                <form method="POST" action="{{ route('reports.reject', $report->id) }}">
                                    @csrf
                                    <div class="py-4">
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text">Alasan Penolakan <span class="text-error">*</span></span>
                                            </label>
                                            <textarea name="rejection_reason" rows="4" class="textarea textarea-bordered" placeholder="Jelaskan alasan penolakan..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-action">
                                        <button type="button" class="btn" onclick="rejectModal_{{ $report->id }}.close()">Batal</button>
                                        <button type="submit" class="btn btn-error">Tolak Laporan</button>
                                    </div>
                                </form>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500">Tidak ada laporan ditemukan</p>
                                @if(!empty(array_filter($filters)))
                                <a href="{{ route('reports.index') }}" class="btn btn-ghost btn-sm mt-4">
                                    Reset Filter
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reports->hasPages())
            <div class="flex justify-center mt-6">
                {{ $reports->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection