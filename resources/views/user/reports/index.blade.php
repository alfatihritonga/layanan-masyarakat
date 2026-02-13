@extends('layouts.user')

@section('title', 'Laporan Saya')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Laporan Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan pantau laporan bencana yang Anda buat</p>
        </div>
        <a href="{{ route('user.reports.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Laporan Baru
        </a>
    </div>

    <!-- Filters -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form method="GET" action="{{ route('user.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Cari</label>
                    <input type="text"
                           name="search"
                           placeholder="Cari laporan..."
                           class="input w-full bg-base-200"
                           value="{{ $filters['search'] ?? '' }}">
                </div>

                <!-- Status Filter -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Status</label>
                    <select name="status" class="select w-full bg-base-200">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ ($filters['status'] ?? '') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="in_progress" {{ ($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="resolved" {{ ($filters['status'] ?? '') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ ($filters['status'] ?? '') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Disaster Type Filter -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Jenis Bencana</label>
                    <select name="disaster_type_id" class="select w-full bg-base-200">
                        <option value="">Semua Jenis</option>
                        @foreach($disasterTypes as $type)
                        <option value="{{ $type->id }}" {{ ($filters['disaster_type_id'] ?? '') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">&nbsp;</label>
                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('user.reports.index') }}" class="btn btn-ghost">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports List -->
    @if($reports->count() > 0)
    <div class="grid grid-cols-1 gap-4">
        @foreach($reports as $report)
        <div class="card bg-base-100 shadow hover:shadow-lg transition cursor-pointer" onclick="window.location='{{ route('user.reports.show', $report->id) }}'">
            <div class="card-body">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                    <!-- Left Content -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $report->disasterType->color ?? '#888' }}"></div>
                            <h3 class="font-bold text-lg">{{ $report->disasterType->name }}</h3>
                            <span class="text-xs text-gray-500">#{{ $report->id }}</span>
                        </div>

                        <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                            {{ $report->description }}
                        </p>

                        <div class="flex flex-wrap gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ Str::limit($report->location_address, 50) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $report->incident_date->format('d M Y, H:i') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $report->created_at->diffForHumans() }}
                            </span>
                            @if($report->attachments_count > 0)
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                {{ $report->attachments_count }} Lampiran
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Right Content - Badges & Actions -->
                    <div class="flex lg:flex-col items-start gap-2">
                        <x-badge status="{{ $report->status }}" />
                        <x-badge urgency="{{ $report->urgency_level }}" />
                        
                        @if($report->canBeEdited())
                        <div class="dropdown dropdown-end lg:dropdown-bottom">
                            <label tabindex="0" class="btn btn-ghost btn-sm btn-circle" onclick="event.stopPropagation()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </label>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52" onclick="event.stopPropagation()">
                                <li>
                                    <a href="{{ route('user.reports.edit', $report->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <button onclick="confirmDelete({{ $report->id }})" class="text-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $reports->links() }}
    </div>

    @else
    <!-- Empty State -->
    <div class="card bg-base-100 shadow">
        <div class="card-body text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-xl font-bold mb-2">Belum Ada Laporan</h3>
            <p class="text-gray-500 mb-6">Anda belum membuat laporan bencana. Mulai buat laporan pertama Anda!</p>
            <a href="{{ route('user.reports.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Laporan Pertama
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<dialog id="delete_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
        <p class="py-4">Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-action">
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-ghost" onclick="delete_modal.close()">Batal</button>
                <button type="submit" class="btn btn-error">Hapus</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@push('scripts')
<script>
function confirmDelete(reportId) {
    event.stopPropagation();
    const form = document.getElementById('delete-form');
    form.action = `/my/reports/${reportId}`;
    delete_modal.showModal();
}
</script>
@endpush
@endsection