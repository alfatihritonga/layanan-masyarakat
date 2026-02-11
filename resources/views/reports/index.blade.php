@extends('layouts.app')

@section('title', 'Kelola Laporan Bencana')

@section('content')
<div class="space-y-6" x-data="reportFilter()">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Laporan Bencana</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan verifikasi laporan bencana dari masyarakat</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full bg-base-100">
        <div class="stat cursor-pointer hover:bg-base-200" @click="setFilter('status', 'pending')">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Pending</div>
            <div class="stat-value text-warning" x-text="stats.pending"></div>
            <div class="stat-desc">Menunggu verifikasi</div>
        </div>

        <div class="stat cursor-pointer hover:bg-base-200" @click="setFilter('status', 'verified')">
            <div class="stat-figure text-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Terverifikasi</div>
            <div class="stat-value text-info" x-text="stats.verified"></div>
            <div class="stat-desc">Siap ditugaskan</div>
        </div>

        <div class="stat cursor-pointer hover:bg-base-200" @click="setFilter('status', 'in_progress')">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="stat-title">Dalam Proses</div>
            <div class="stat-value text-primary" x-text="stats.in_progress"></div>
            <div class="stat-desc">Sedang ditangani</div>
        </div>

        <div class="stat cursor-pointer hover:bg-base-200" @click="setFilter('status', 'resolved')">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="stat-title">Selesai</div>
            <div class="stat-value text-success" x-text="stats.resolved"></div>
            <div class="stat-desc">Laporan selesai</div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="form-control md:col-span-2">
                    <label class="label">
                        <span class="label-text">Cari Laporan</span>
                    </label>
                    <input type="text" 
                           x-model="filters.search"
                           @input.debounce.500ms="fetchReports()"
                           placeholder="Cari berdasarkan deskripsi, lokasi, atau nomor HP..." 
                           class="input input-bordered">
                </div>

                <!-- Status Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select x-model="filters.status" @change="fetchReports()" class="select select-bordered">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="verified">Terverifikasi</option>
                        <option value="in_progress">Dalam Proses</option>
                        <option value="resolved">Selesai</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>

                <!-- Disaster Type Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Jenis Bencana</span>
                    </label>
                    <select x-model="filters.disaster_type_id" @change="fetchReports()" class="select select-bordered">
                        <option value="">Semua Jenis</option>
                        @foreach($disasterTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Urgency Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Urgensi</span>
                    </label>
                    <select x-model="filters.urgency_level" @change="fetchReports()" class="select select-bordered">
                        <option value="">Semua Urgensi</option>
                        <option value="critical">Kritis</option>
                        <option value="high">Tinggi</option>
                        <option value="medium">Sedang</option>
                        <option value="low">Rendah</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filters (Collapsible) -->
            <div x-show="showAdvanced" x-collapse class="mt-4 pt-4 border-t">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tanggal Dari</span>
                        </label>
                        <input type="date" 
                               x-model="filters.date_from" 
                               @change="fetchReports()"
                               class="input input-bordered">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tanggal Sampai</span>
                        </label>
                        <input type="date" 
                               x-model="filters.date_to" 
                               @change="fetchReports()"
                               class="input input-bordered">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Urutkan</span>
                        </label>
                        <select x-model="filters.sort_by" @change="fetchReports()" class="select select-bordered">
                            <option value="created_at">Tanggal Dibuat</option>
                            <option value="incident_date">Tanggal Kejadian</option>
                            <option value="urgency_level">Urgensi</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex justify-between items-center mt-4">
                <button @click="showAdvanced = !showAdvanced" class="btn btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span x-text="showAdvanced ? 'Sembunyikan Filter' : 'Filter Lanjutan'"></span>
                </button>

                <button @click="resetFilters()" class="btn btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <!-- Loading State -->
            <div x-show="loading" class="flex justify-center py-12">
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <!-- Table -->
            <div x-show="!loading" class="overflow-x-auto">
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
                        <template x-for="report in reports" :key="report.id">
                            <tr class="hover">
                                <td>
                                    <span class="font-mono text-xs" x-text="'#' + report.id"></span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                <span class="text-xs" x-text="report.user.name.substring(0, 2).toUpperCase()"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-sm" x-text="report.user.name"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full" :style="`background-color: ${report.disaster_type.color}`"></div>
                                        <span class="font-medium" x-text="report.disaster_type.name"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="max-w-xs truncate text-sm" x-text="report.location_address"></div>
                                </td>
                                <td>
                                    <span class="badge badge-sm" 
                                          :class="{
                                              'badge-ghost': report.urgency_level === 'low',
                                              'badge-warning': report.urgency_level === 'medium',
                                              'badge-error': report.urgency_level === 'high',
                                              'badge-error animate-pulse': report.urgency_level === 'critical'
                                          }"
                                          x-text="getUrgencyLabel(report.urgency_level)">
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-sm"
                                          :class="{
                                              'badge-warning': report.status === 'pending',
                                              'badge-info': report.status === 'verified',
                                              'badge-primary': report.status === 'in_progress',
                                              'badge-success': report.status === 'resolved',
                                              'badge-error': report.status === 'rejected'
                                          }"
                                          x-text="getStatusLabel(report.status)">
                                    </span>
                                </td>
                                <td>
                                    <div class="text-sm" x-text="formatDate(report.created_at)"></div>
                                </td>
                                <td>
                                    <a :href="`/reports/${report.id}`" class="btn btn-ghost btn-xs">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Empty State -->
                <div x-show="reports.length === 0" class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500">Tidak ada laporan ditemukan</p>
                </div>
            </div>

            <!-- Pagination -->
            <div x-show="!loading && meta.last_page > 1" class="flex justify-center mt-6">
                <div class="join">
                    <button @click="changePage(meta.current_page - 1)" 
                            :disabled="meta.current_page === 1"
                            class="join-item btn btn-sm">«</button>
                    
                    <template x-for="page in getPageNumbers()" :key="page">
                        <button @click="changePage(page)"
                                class="join-item btn btn-sm"
                                :class="{ 'btn-active': page === meta.current_page }"
                                x-text="page">
                        </button>
                    </template>
                    
                    <button @click="changePage(meta.current_page + 1)"
                            :disabled="meta.current_page === meta.last_page"
                            class="join-item btn btn-sm">»</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function reportFilter() {
    return {
        loading: false,
        showAdvanced: false,
        reports: [],
        meta: {
            current_page: 1,
            last_page: 1,
            per_page: 15,
            total: 0
        },
        stats: {
            pending: 0,
            verified: 0,
            in_progress: 0,
            resolved: 0
        },
        filters: {
            search: '',
            status: '',
            disaster_type_id: '',
            urgency_level: '',
            date_from: '',
            date_to: '',
            sort_by: 'created_at',
            sort_order: 'desc',
            page: 1,
            per_page: 15
        },

        init() {
            this.fetchReports();
            this.fetchStats();
        },

        async fetchReports() {
            this.loading = true;
            
            try {
                const params = new URLSearchParams();
                Object.keys(this.filters).forEach(key => {
                    if (this.filters[key]) {
                        params.append(key, this.filters[key]);
                    }
                });

                const response = await fetch(`/api/admin/reports?${params.toString()}`, {
                    headers: {
                        'Authorization': `Bearer ${this.getToken()}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    this.reports = data.data;
                    this.meta = data.meta;
                }
            } catch (error) {
                console.error('Error fetching reports:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchStats() {
            try {
                const response = await fetch('/api/admin/dashboard/statistics', {
                    headers: {
                        'Authorization': `Bearer ${this.getToken()}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    this.stats = {
                        pending: data.data.pending_reports,
                        verified: data.data.verified_reports,
                        in_progress: data.data.in_progress_reports,
                        resolved: data.data.resolved_reports
                    };
                }
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        },

        setFilter(key, value) {
            this.filters[key] = this.filters[key] === value ? '' : value;
            this.filters.page = 1;
            this.fetchReports();
        },

        resetFilters() {
            this.filters = {
                search: '',
                status: '',
                disaster_type_id: '',
                urgency_level: '',
                date_from: '',
                date_to: '',
                sort_by: 'created_at',
                sort_order: 'desc',
                page: 1,
                per_page: 15
            };
            this.fetchReports();
        },

        changePage(page) {
            if (page >= 1 && page <= this.meta.last_page) {
                this.filters.page = page;
                this.fetchReports();
            }
        },

        getPageNumbers() {
            const pages = [];
            const current = this.meta.current_page;
            const last = this.meta.last_page;
            
            // Always show first page
            pages.push(1);
            
            // Show pages around current page
            for (let i = Math.max(2, current - 1); i <= Math.min(last - 1, current + 1); i++) {
                if (!pages.includes(i)) {
                    pages.push(i);
                }
            }
            
            // Always show last page
            if (last > 1 && !pages.includes(last)) {
                pages.push(last);
            }
            
            return pages;
        },

        getToken() {
            // Get token from cookie or localStorage
            // Untuk demo, kita return empty string
            // Dalam production, ambil dari session/cookie
            return '';
        },

        getStatusLabel(status) {
            const labels = {
                'pending': 'Pending',
                'verified': 'Terverifikasi',
                'in_progress': 'Dalam Proses',
                'resolved': 'Selesai',
                'rejected': 'Ditolak'
            };
            return labels[status] || status;
        },

        getUrgencyLabel(urgency) {
            const labels = {
                'low': 'Rendah',
                'medium': 'Sedang',
                'high': 'Tinggi',
                'critical': 'Kritis'
            };
            return labels[urgency] || urgency;
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection