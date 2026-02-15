@extends('layouts.user')

@section('title', 'Detail Laporan #' . $report->id)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Button & Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('user.reports.index') }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        @if($report->canBeEdited())
        <div class="flex gap-2">
            <a href="{{ route('user.reports.edit', $report->id) }}" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <button onclick="delete_modal.showModal()" class="btn btn-error btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus
            </button>
        </div>
        @endif
    </div>

    <!-- Main Card -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <!-- Header Info -->
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 pb-4 border-b border-base-content/10">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-sm text-gray-500">Laporan #{{ $report->id }}</span>
                        <span class="text-gray-300">•</span>
                        <span class="text-sm text-gray-500">{{ $report->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $report->disasterType->color ?? '#888' }}">
                            
                        </div>
                        <h1 class="text-2xl font-bold">{{ $report->disasterType->name }}</h1>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <x-badge status="{{ $report->status }}" />
                        <x-badge urgency="{{ $report->urgency_level }}" />
                    </div>
                </div>

                @if($report->verified_at)
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-xs">
                        <div class="font-semibold">Terverifikasi</div>
                        <div>{{ $report->verified_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                @endif

                @if($report->isRejected() && $report->rejection_reason)
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-xs">
                        <div class="font-semibold">Ditolak</div>
                        <div>{{ $report->rejection_reason }}</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Detail Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Deskripsi Kejadian</label>
                        <p class="mt-1 text-base">{{ $report->description }}</p>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500">Lokasi Kejadian</label>
                        <p class="mt-1 text-base">
                            {{ $report->location_address }}
                        </p>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500">Waktu Kejadian</label>
                        <p class="mt-1 text-base">{{ $report->incident_date->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    @if($report->victim_count)
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Jumlah Korban</label>
                        <p class="mt-1 text-base">{{ $report->victim_count }} orang</p>
                    </div>
                    @endif

                    @if($report->damage_description)
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Deskripsi Kerusakan</label>
                        <p class="mt-1 text-base">{{ $report->damage_description }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="text-xs font-semibold text-gray-500">Kontak yang Dapat Dihubungi</label>
                        <p class="mt-1 text-base">{{ $report->contact_phone }}</p>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500">Dilaporkan</label>
                        <p class="mt-1 text-base">{{ $report->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            @if($report->attachments->count() > 0 || $report->canBeEdited())
            <div class="pt-6 border-t border-base-content/10">
                <h3 class="text-lg font-semibold mb-4">Lampiran ({{ $report->attachments->count() }})</h3>
                @if($report->attachments->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($report->attachments as $attachment)
                    <div class="relative group">
                        @if($attachment->isImage())
                        <a href="{{ $attachment->url }}" target="_blank" class="block aspect-square rounded-lg overflow-hidden bg-base-200">
                            <img src="{{ $attachment->url }}" alt="{{ $attachment->file_name }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                        </a>
                        @else
                        <a href="{{ $attachment->url }}" target="_blank" class="block aspect-square rounded-lg overflow-hidden bg-base-200 relative group">
                            <video class="w-full h-full object-cover" preload="metadata" muted>
                                <source src="{{ $attachment->url }}#t=0.5" type="{{ $attachment->mime_type }}">
                            </video>
                            {{-- Icon play overlay --}}
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition flex items-center justify-center pointer-events-none">
                                <svg class="w-12 h-12 text-white opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        </a>
                        @endif
                        <div class="mt-1 text-xs text-center truncate">{{ $attachment->file_name }}</div>
                        <div class="text-xs text-center text-gray-500">{{ $attachment->file_size_in_mb }} MB</div>

                        @if($report->canBeEdited())
                        <button onclick="confirmDeleteAttachment({{ $attachment->id }})" class="btn btn-sm btn-circle btn-error absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition">
                            ✕
                        </button>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Add More Attachments -->
                @if($report->canBeEdited() && $report->attachments->count() < 3)
                <form method="POST" action="{{ route('user.reports.addAttachment', $report->id) }}" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <div class="flex gap-2">
                        <input type="file" name="file" class="file-input w-full bg-base-200 flex-1" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,video/mp4,video/mpeg,video/quicktime,video/x-msvideo" required>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah
                        </button>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Foto (max 3MB) atau Video (max 10MB). Maksimal {{ 3 - $report->attachments->count() }} file lagi.</div>
                </form>
                @endif
            </div>
            @endif

            <!-- Assignments (if any) -->
            @if($report->assignments->count() > 0)
            <div class="pt-6 border-t border-base-content/10">
                <h3 class="text-lg font-semibold mb-4">Tim Penanganan</h3>
                <div class="space-y-3">
                    @foreach($report->assignments as $assignment)
                    <div class="card bg-base-200">
                        <div class="card-body p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral text-neutral-content rounded-full w-12 flex items-center justify-center">
                                            <span class="text-xl">{{ substr($assignment->relawan->nama, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-semibold">{{ $assignment->relawan->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $assignment->relawan->no_hp }}</div>
                                        @if($assignment->relawan->skill)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($assignment->relawan->skill as $skill)
                                            <span class="badge badge-xs">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <x-badge :text="ucfirst(str_replace('_', ' ', $assignment->status))" class="badge-sm" />
                                    <div class="text-xs text-gray-500 mt-1">{{ $assignment->assigned_at->format('d M Y') }}</div>
                                </div>
                            </div>
                            @if($assignment->notes)
                            <div class="text-sm text-gray-600 mt-2">
                                <span class="font-semibold">Catatan:</span> {{ $assignment->notes }}
                            </div>
                            @endif
                            @if($assignment->completion_notes)
                            <div class="alert alert-success mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-xs">
                                    <div class="font-semibold">Laporan Penyelesaian:</div>
                                    <div>{{ $assignment->completion_notes }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Comments Section -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-title px-5 py-3 border-b border-base-content/10">
            <h2 class="text-lg font-semibold">Diskusi Laporan</h2>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Add Comment Form -->
                <form method="POST" action="{{ route('user.reports.addComment', $report->id) }}" class="order-2 md:order-1">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="comment" class="text-sm font-semibold">Komentar</label>
                        <textarea id="comment" name="comment" rows="3" class="textarea w-full bg-base-200" placeholder="Tulis komentar atau pertanyaan..." required></textarea>
                    </div>
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linejoin="round" stroke-width="1.5" d="M9 11.75 1.966 5.497c-.687-.61-.255-1.747.664-1.747h18.65a1 1 0 0 1 .868 1.495l-9.146 16.039c-.45.79-1.636.617-1.843-.269zm0 0L22.586 4"></path></svg>
                            Kirim
                        </button>
                    </div>
                </form>

                <!-- Comments List -->
                <div class="order-1 md:order-2">
                    @if($comments->count() > 0)
                    <div class="space-y-4 bg-base-300 p-4 rounded max-h-96 overflow-y-auto">
                        @foreach($comments as $comment)
                        <div class="flex gap-3 {{ $comment->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded-full w-10 h-10 flex items-center justify-center">
                                    @if($comment->user->avatar)
                                    <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}">
                                    @else
                                    <span class="text-sm">{{ $comment->user->initials() }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 {{ $comment->user_id === auth()->id() ? 'text-right' : '' }}">
                                <div class="inline-block {{ $comment->user_id === auth()->id() ? 'bg-primary text-primary-content' : 'bg-base-200' }} rounded-lg px-4 py-2 max-w-lg">
                                    <div class="font-semibold text-sm">{{ $comment->user->name }}</div>
                                    <p class="text-sm mt-1">{{ $comment->comment }}</p>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons h-12 w-12 mx-auto mb-2 opacity-50" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 14.25h3.002a1 1 0 0 0 1-1v-8.5a1 1 0 0 0-1-1H8.002a1 1 0 0 0-1 1v3m9.25 0h-12.5a1 1 0 0 0-1 1v8.5a1 1 0 0 0 1 1h2.25v2.5l4.5-2.5h5.75a1 1 0 0 0 1-1v-8.5a1 1 0 0 0-1-1"></path></svg>
                        <p>Belum ada komentar</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline/History -->
    @if($report->histories->count() > 0)
    <div class="card bg-base-100 shadow-lg">
        <div class="card-title px-5 py-3 border-b border-base-content/10">
            <h2 class="text-lg font-semibold">Riwayat Perubahan</h2>
        </div>
        <div class="card-body">
            <ul class="timeline timeline-vertical">
                @foreach($report->histories as $history)
                <li>
                    <div class="timeline-start text-sm">{{ $history->created_at->format('d M Y, H:i') }}</div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end timeline-box">
                        <div class="font-semibold">{{ ucfirst(str_replace('_', ' ', $history->field_name)) }}</div>
                        <div class="text-sm text-gray-600">
                            @if($history->old_value)
                            <span class="line-through">{{ $history->old_value }}</span> →
                            @endif
                            <span class="font-semibold">{{ $history->new_value }}</span>
                        </div>
                        @if($history->notes)
                        <div class="text-sm text-gray-500 mt-1">{{ $history->notes }}</div>
                        @endif
                        <div class="text-xs text-gray-400 mt-1">oleh {{ $history->changer->name }}</div>
                    </div>
                    <hr/>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>

<!-- Delete Report Modal -->
<dialog id="delete_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Hapus Laporan</h3>
        <p class="py-4">Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-action">
            <form method="POST" action="{{ route('user.reports.destroy', $report->id) }}">
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

<!-- Delete Attachment Modal -->
<dialog id="delete_attachment_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Hapus Lampiran</h3>
        <p class="py-4">Apakah Anda yakin ingin menghapus lampiran ini?</p>
        <div class="modal-action">
            <form id="delete-attachment-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-ghost" onclick="delete_attachment_modal.close()">Batal</button>
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
function confirmDeleteAttachment(attachmentId) {
    const form = document.getElementById('delete-attachment-form');
    form.action = `/my/reports/{{ $report->id }}/attachments/${attachmentId}`;
    delete_attachment_modal.showModal();
}
</script>
@endpush
@endsection