@extends('layouts.user')

@section('title', 'Edit Laporan #' . $report->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div>
        <a href="{{ route('user.reports.show', $report->id) }}" class="btn btn-ghost btn-sm mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold">Edit Laporan #{{ $report->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi laporan bencana Anda</p>
    </div>

    <!-- Alert -->
    <div class="alert alert-warning">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span>Laporan hanya dapat diedit jika statusnya masih <strong>Pending</strong></span>
    </div>

    <!-- Form Card -->
    <form method="POST" action="{{ route('user.reports.update', $report->id) }}">
        @csrf
        @method('PUT')
        
        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-6">
                
                <!-- Jenis Bencana -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Jenis Bencana <span class="text-red-500">*</span></label>
                    <select name="disaster_type_id" class="select w-full bg-base-200 @error('disaster_type_id') select-error @enderror" required>
                        <option value="">Pilih Jenis Bencana</option>
                        @foreach($disasterTypes as $type)
                        <option value="{{ $type->id }}" {{ old('disaster_type_id', $report->disaster_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('disaster_type_id')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Kejadian -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Deskripsi Kejadian <span class="text-red-500">*</span></label>
                    <textarea name="description"
                              rows="5"
                              class="textarea w-full bg-base-200 @error('description') textarea-error @enderror"
                              placeholder="Jelaskan detail kejadian bencana yang terjadi..."
                              required>{{ old('description', $report->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi Kejadian -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Alamat Lengkap Lokasi <span class="text-red-500">*</span></label>
                    <textarea name="location_address"
                              rows="3"
                              class="textarea w-full bg-base-200 @error('location_address') textarea-error @enderror"
                              placeholder="Contoh: Jl. Merdeka No. 10, RT 01/RW 02, Kelurahan Tanjung Sari..."
                              required>{{ old('location_address', $report->location_address) }}</textarea>
                    @error('location_address')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal & Waktu Kejadian -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Tanggal & Waktu Kejadian <span class="text-red-500">*</span></label>
                        <input type="datetime-local"
                               name="incident_date"
                               class="input w-full bg-base-200 @error('incident_date') input-error @enderror"
                               value="{{ old('incident_date', $report->incident_date->format('Y-m-d\TH:i')) }}"
                               max="{{ now()->format('Y-m-d\TH:i') }}"
                               required>
                        @error('incident_date')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Tingkat Urgensi <span class="text-red-500">*</span></label>
                        <select name="urgency_level" class="select w-full bg-base-200 @error('urgency_level') select-error @enderror" required>
                            <option value="low" {{ old('urgency_level', $report->urgency_level) == 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="medium" {{ old('urgency_level', $report->urgency_level) == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="high" {{ old('urgency_level', $report->urgency_level) == 'high' ? 'selected' : '' }}>Tinggi</option>
                            <option value="critical" {{ old('urgency_level', $report->urgency_level) == 'critical' ? 'selected' : '' }}>Kritis</option>
                        </select>
                        @error('urgency_level')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Jumlah Korban & Kontak -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Jumlah Korban (Opsional)</label>
                        <input type="number"
                               name="victim_count"
                               class="input w-full bg-base-200 @error('victim_count') input-error @enderror"
                               placeholder="0"
                               min="0"
                               value="{{ old('victim_count', $report->victim_count) }}">
                        @error('victim_count')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Nomor HP yang Bisa Dihubungi <span class="text-red-500">*</span></label>
                        <input type="tel"
                               name="contact_phone"
                               class="input w-full bg-base-200 @error('contact_phone') input-error @enderror"
                               placeholder="081234567890"
                               value="{{ old('contact_phone', $report->contact_phone) }}"
                               required>
                        @error('contact_phone')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi Kerusakan -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Deskripsi Kerusakan (Opsional)</label>
                    <textarea name="damage_description"
                              rows="3"
                              class="textarea w-full bg-base-200 @error('damage_description') textarea-error @enderror"
                              placeholder="Jelaskan kerusakan yang ditimbulkan...">{{ old('damage_description', $report->damage_description) }}</textarea>
                    @error('damage_description')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 justify-end mt-6">
            <a href="{{ route('user.reports.show', $report->id) }}" class="btn btn-ghost">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>

    <!-- Note about attachments -->
    <div class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Untuk menambah/menghapus lampiran, silakan kembali ke halaman detail laporan.</span>
    </div>
</div>
@endsection