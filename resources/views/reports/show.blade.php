@extends('layouts.app')

@section('title', 'Detail Laporan #' . $report->id)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Button & Quick Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('reports.index') }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="flex gap-2">
            @if($report->isPending())
            <button onclick="verify_modal.showModal()" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verifikasi
            </button>
            <button onclick="reject_modal.showModal()" class="btn btn-error btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tolak
            </button>
            @endif

            @if($report->isVerified())
            <button onclick="assign_modal.showModal()" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tugaskan Relawan
            </button>
            @endif

            @if($report->isInProgress())
            <button onclick="resolve_modal.showModal()" class="btn btn-success btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Tandai Selesai
            </button>
            @endif

            <button onclick="urgency_modal.showModal()" class="btn btn-ghost btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Ubah Urgensi
            </button>
        </div>
    </div>

    <!-- Main Info Card -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 pb-4 border-b border-base-content/10">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-sm text-gray-500">Laporan #{{ $report->id }}</span>
                        <span class="text-gray-300">•</span>
                        <span class="text-sm text-gray-500">{{ $report->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $report->disasterType->color ?? '#888' }}"></div>
                        <h1 class="text-2xl font-bold">{{ $report->disasterType->name }}</h1>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <x-badge status="{{ $report->status }}" />
                        <x-badge urgency="{{ $report->urgency_level }}" />
                    </div>
                </div>

                <!-- Status Info -->
                <div class="space-y-2">
                    @if($report->verified_at)
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-xs">
                            <div class="font-semibold">Diverifikasi oleh {{ $report->verifier->name }}</div>
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

                    @if($report->isResolved() && $report->resolved_at)
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div class="text-xs">
                            <div class="font-semibold">Selesai Ditangani</div>
                            <div>{{ $report->resolved_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Pelapor</label>
                        <div class="mt-1 flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded-full w-12 flex justify-center items-center">
                                    @if($report->user->avatar)
                                    <img src="{{ $report->user->avatar }}" alt="{{ $report->user->name }}">
                                    @else
                                    <span class="text-lg">{{ $report->user->initials() }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="font-semibold">{{ $report->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $report->user->email }}</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500">Deskripsi Kejadian</label>
                        <p class="mt-1 text-base">{{ $report->description }}</p>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500">Lokasi Kejadian</label>
                        <p class="mt-1 text-base">
                            <span>{{ $report->location_address }}</span>
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
                        <p class="mt-1 text-base font-semibold text-error">{{ $report->victim_count }} orang</p>
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
                        <p class="mt-1 text-base">
                            <a href="tel:{{ $report->contact_phone }}" class="link link-primary">{{ $report->contact_phone }}</a>
                        </p>
                    </div>

                    @if($report->admin_notes)
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Catatan Admin</label>
                        <div class="mt-1 p-3 bg-base-200 rounded-lg">
                            <p class="text-sm">{{ $report->admin_notes }}</p>
                        </div>
                    </div>
                    @endif

                    <div>
                        <label class="text-xs font-semibold text-gray-500">Dilaporkan</label>
                        <p class="mt-1 text-base">{{ $report->created_at->diffForHumans() }}</p>
                        <p class="text-sm text-gray-500">{{ $report->created_at->format('d F Y, H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            @if($report->attachments->count() > 0)
            <div class="border-t border-base-content/10 pt-6">
                <h3 class="text-lg font-semibold mb-4">Lampiran ({{ $report->attachments->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($report->attachments as $attachment)
                    <div class="relative group">
                        @if($attachment->isImage())
                        <a href="{{ $attachment->url }}" target="_blank" class="block aspect-square rounded-lg overflow-hidden bg-base-200 border-2 border-transparent hover:border-primary transition">
                            <img src="{{ $attachment->url }}" alt="{{ $attachment->file_name }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                        </a>
                        @else
                        <a href="{{ $attachment->url }}" target="_blank" class="block aspect-square rounded-lg overflow-hidden bg-base-200 flex items-center justify-center hover:bg-base-300 transition border-2 border-transparent hover:border-primary">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">Video</span>
                            </div>
                        </a>
                        @endif
                        <div class="mt-1 text-xs text-center truncate" title="{{ $attachment->file_name }}">{{ $attachment->file_name }}</div>
                        <div class="text-xs text-center text-gray-500">{{ $attachment->file_size_in_mb }} MB</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Assignments Section -->
    @if($report->assignments->count() > 0 || $report->isVerified() || $report->isInProgress())
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Tim Penanganan ({{ $report->assignments->count() }})</h3>
                @if($report->isVerified() || $report->isInProgress())
                <button onclick="assign_modal.showModal()" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Relawan
                </button>
                @endif
            </div>

            @if($report->assignments->count() > 0)
            <div class="space-y-3">
                @foreach($report->assignments as $assignment)
                <div class="card bg-base-200">
                    <div class="card-body p-4">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <!-- Relawan Info -->
                            <div class="flex items-center gap-3 flex-1">
                                <div class="avatar placeholder">
                                    <div class="bg-neutral text-neutral-content rounded-full w-14 flex items-center justify-center">
                                        <span class="text-xl">{{ substr($assignment->relawan->nama, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-lg">{{ $assignment->relawan->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $assignment->relawan->no_hp }}</div>
                                    <div class="text-sm text-gray-500">{{ $assignment->relawan->kabupaten_kota }}</div>
                                    @if($assignment->relawan->skill)
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($assignment->relawan->skill as $skill)
                                        <span class="badge badge-xs badge-outline">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="flex flex-col items-end gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="badge {{ $assignment->isCompleted() ? 'badge-success' : 'badge-primary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                                    </span>
                                    @if(!$assignment->isCompleted() && $assignment->status != 'cancelled')
                                    <div class="dropdown dropdown-end">
                                        <label tabindex="0" class="btn btn-ghost btn-sm btn-square">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </label>
                                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            @if($assignment->status === 'assigned')
                                            <li>
                                                <button type="submit" form="assignment-status-{{ $assignment->id }}-on_the_way" class="w-full text-left">
                                                    Dalam Perjalanan
                                                </button>
                                                <form id="assignment-status-{{ $assignment->id }}-on_the_way" method="POST" action="{{ route('reports.updateAssignmentStatus', [$report->id, $assignment->id]) }}" class="hidden">
                                                    @csrf
                                                    <input type="hidden" name="status" value="on_the_way">
                                                </form>
                                            </li>
                                            @endif
                                            @if($assignment->status === 'on_the_way')
                                            <li>
                                                <button type="submit" form="assignment-status-{{ $assignment->id }}-on_site" class="w-full text-left">
                                                    Tiba di Lokasi
                                                </button>
                                                <form id="assignment-status-{{ $assignment->id }}-on_site" method="POST" action="{{ route('reports.updateAssignmentStatus', [$report->id, $assignment->id]) }}" class="hidden">
                                                    @csrf
                                                    <input type="hidden" name="status" value="on_site">
                                                </form>
                                            </li>
                                            @endif
                                            @if($assignment->status === 'on_site')
                                            <li>
                                                <button onclick="complete_assignment_{{ $assignment->id }}.showModal()" class="w-full text-left">
                                                    Selesai
                                                </button>
                                            </li>
                                            @endif
                                            <li>
                                                <button type="submit" form="assignment-status-{{ $assignment->id }}-cancelled" class="w-full text-left text-error">
                                                    Batalkan
                                                </button>
                                                <form id="assignment-status-{{ $assignment->id }}-cancelled" method="POST" action="{{ route('reports.updateAssignmentStatus', [$report->id, $assignment->id]) }}" class="hidden">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">
                                    Ditugaskan {{ $assignment->assigned_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($assignment->notes)
                        <div class="mt-3 pt-3 border-t border-base-content/10">
                            <div class="text-sm">
                                <span class="font-semibold">Catatan Penugasan:</span>
                                <p class="text-gray-600 mt-1">{{ $assignment->notes }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Completion Notes -->
                        @if($assignment->completion_notes)
                        <div class="alert alert-success mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-xs">
                                <div class="font-semibold">Laporan Penyelesaian:</div>
                                <div>{{ $assignment->completion_notes }}</div>
                                @if($assignment->completed_at)
                                <div class="text-gray-500 mt-1">{{ $assignment->completed_at->format('d M Y, H:i') }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Complete Assignment Modal -->
                <dialog id="complete_assignment_{{ $assignment->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">Selesaikan Penugasan</h3>
                        <form method="POST" action="{{ route('reports.completeAssignment', [$report->id, $assignment->id]) }}">
                            @csrf
                            <div class="py-4">
                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-semibold">Laporan Penyelesaian <span class="text-red-500">*</span></label>
                                    <textarea name="completion_notes" rows="4" class="textarea w-full bg-base-200" placeholder="Jelaskan hasil penanganan dan tindakan yang telah dilakukan..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-action">
                                <button type="button" class="btn btn-ghost" onclick="complete_assignment_{{ $assignment->id }}.close()">Batal</button>
                                <button type="submit" class="btn btn-success">Selesai</button>
                            </div>
                        </form>
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-gray-500 mb-4">Belum ada relawan yang ditugaskan</p>
                <button onclick="assign_modal.showModal()" class="btn btn-primary btn-sm">
                    Tugaskan Relawan
                </button>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Comments & Communication -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-title px-5 py-3 border-b border-base-content/10">
            <h2 class="text-lg font-semibold">Komentar & Komunikasi</h2>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Add Comment Form -->
                <form method="POST" action="{{ route('reports.addComment', $report->id) }}" class="order-2 md:order-1">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="comment" class="text-sm font-semibold">Komentar</label>
                        <textarea id="comment" name="comment" rows="3" class="textarea w-full bg-base-200" placeholder="Tulis komentar atau update..." required></textarea>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_internal" value="1" class="checkbox checkbox-sm" />
                            <span class="text-sm">Komentar Internal (Hanya untuk admin)</span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linejoin="round" stroke-width="1.5" d="M9 11.75 1.966 5.497c-.687-.61-.255-1.747.664-1.747h18.65a1 1 0 0 1 .868 1.495l-9.146 16.039c-.45.79-1.636.617-1.843-.269zm0 0L22.586 4"></path></svg>
                            Kirim
                        </button>
                    </div>
                </form>

                <!-- Comments List -->
                <div class="order-1 md:order-2">
                    @if($report->comments->count() > 0)
                    <div class="space-y-4 bg-base-300 p-4 rounded max-h-96 overflow-y-auto">
                        @foreach($report->comments as $comment)
                        <div class="flex gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded-full w-10 h-10 flex justify-center items-center">
                                    @if($comment->user->avatar)
                                    <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}">
                                    @else
                                    <span class="text-sm">{{ $comment->user->initials() }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="bg-base-200 rounded-lg px-4 py-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-sm">{{ $comment->user->name }}</span>
                                        @if($comment->user->isAdmin())
                                        <span class="badge badge-primary badge-xs">Admin</span>
                                        @endif
                                        @if($comment->is_internal)
                                        <span class="badge badge-warning badge-xs">Internal</span>
                                        @endif
                                    </div>
                                    <p class="text-sm">{{ $comment->comment }}</p>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 ml-4">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p>Belum ada komentar</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- History Timeline -->
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

<!-- Modals -->

<!-- Verify Modal -->
<dialog id="verify_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Verifikasi Laporan</h3>
        <form method="POST" action="{{ route('reports.verify', $report->id) }}">
            @csrf
            <div class="py-4 space-y-4">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Tingkat Urgensi</label>
                    <select name="urgency_level" class="select w-full bg-base-200">
                        <option value="">Tidak Diubah ({{ ucfirst($report->urgency_level) }})</option>
                        <option value="low">Rendah</option>
                        <option value="medium">Sedang</option>
                        <option value="high">Tinggi</option>
                        <option value="critical">Kritis</option>
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Catatan Admin (Opsional)</label>
                    <textarea name="admin_notes" rows="3" class="textarea w-full bg-base-200" placeholder="Catatan verifikasi..."></textarea>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="verify_modal.close()">Batal</button>
                <button type="submit" class="btn btn-success">Verifikasi Laporan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Reject Modal -->
<dialog id="reject_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Tolak Laporan</h3>
        <form method="POST" action="{{ route('reports.reject', $report->id) }}">
            @csrf
            <div class="py-4">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="rejection_reason" rows="4" class="textarea w-full bg-base-200" placeholder="Jelaskan alasan penolakan..." required></textarea>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="reject_modal.close()">Batal</button>
                <button type="submit" class="btn btn-error">Tolak Laporan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Assign Relawan Modal -->
<dialog id="assign_modal" class="modal">
    <div class="modal-box max-w-2xl">
        <h3 class="font-bold text-lg mb-4">Tugaskan Relawan</h3>
        <form method="POST" action="{{ route('reports.assign', $report->id) }}">
            @csrf
            <div class="py-4 space-y-4">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Pilih Relawan <span class="text-red-500">*</span></label>
                    <div class="max-h-60 overflow-y-auto space-y-2 p-2 border rounded-lg">
                        @foreach($availableRelawan as $relawan)
                        <label class="flex items-center gap-3 p-3 hover:bg-base-200 rounded-lg cursor-pointer">
                            <input type="checkbox" name="relawan_ids[]" value="{{ $relawan->id }}" class="checkbox">
                            <div class="flex-1">
                                <div class="font-semibold">{{ $relawan->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $relawan->no_hp }} • {{ $relawan->kabupaten_kota }}</div>
                                @if($relawan->skill)
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($relawan->skill as $skill)
                                    <span class="badge badge-xs badge-outline">{{ $skill }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <span class="badge badge-success badge-sm">{{ $relawan->status_ketersediaan }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Catatan Penugasan (Opsional)</label>
                    <textarea name="notes" rows="3" class="textarea w-full bg-base-200" placeholder="Catatan untuk relawan..."></textarea>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="assign_modal.close()">Batal</button>
                <button type="submit" class="btn btn-primary">Tugaskan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Update Urgency Modal -->
<dialog id="urgency_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Ubah Tingkat Urgensi</h3>
        <form method="POST" action="{{ route('reports.updateUrgency', $report->id) }}">
            @csrf
            <div class="py-4">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Tingkat Urgensi Baru <span class="text-red-500">*</span></label>
                    <select name="urgency_level" class="select w-full bg-base-200" required>
                        <option value="low" {{ $report->urgency_level == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ $report->urgency_level == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ $report->urgency_level == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="critical" {{ $report->urgency_level == 'critical' ? 'selected' : '' }}>Kritis</option>
                    </select>
                    <p class="text-xs text-gray-500">Saat ini: <strong>{{ ucfirst($report->urgency_level) }}</strong></p>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="urgency_modal.close()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Resolve Modal -->
<dialog id="resolve_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Selesaikan Laporan</h3>
        <form method="POST" action="{{ route('reports.resolve', $report->id) }}">
            @csrf
            <div class="py-4">
                <p class="mb-4">Apakah Anda yakin laporan ini sudah selesai ditangani?</p>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Catatan Penyelesaian (Opsional)</label>
                    <textarea name="notes" rows="3" class="textarea w-full bg-base-200" placeholder="Catatan akhir penanganan..."></textarea>
                </div>
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="resolve_modal.close()">Batal</button>
                <button type="submit" class="btn btn-success">Tandai Selesai</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@endsection
