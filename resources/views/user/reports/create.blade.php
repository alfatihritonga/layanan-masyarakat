@extends('layouts.user')

@section('title', 'Buat Laporan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-3xl font-bold">Buat Laporan Bencana</h1>
        <p class="text-sm text-gray-500 mt-1">Laporkan kejadian bencana yang Anda temui atau alami</p>
    </div>

    <!-- Form Card -->
    <form method="POST" action="{{ route('user.reports.store') }}" enctype="multipart/form-data" x-data="reportForm()">
        @csrf
        
        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-6">
                
                <!-- Jenis Bencana -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Jenis Bencana <span class="text-red-500">*</span></label>
                    <select name="disaster_type_id" class="select w-full bg-base-200 @error('disaster_type_id') select-error @enderror" required>
                        <option value="">Pilih Jenis Bencana</option>
                        @foreach($disasterTypes as $type)
                        <option value="{{ $type->id }}" {{ old('disaster_type_id') == $type->id ? 'selected' : '' }}>
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
                              required>{{ old('description') }}</textarea>
                    <p class="text-xs text-gray-500">Minimal 10 karakter</p>
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
                              placeholder="Contoh: Jl. Merdeka No. 10, RT 01/RW 02, Kelurahan Tanjung Sari, Kecamatan Medan Selayang, Kota Medan, Sumatera Utara"
                              required>{{ old('location_address') }}</textarea>
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
                               value="{{ old('incident_date', now()->format('Y-m-d\TH:i')) }}"
                               max="{{ now()->format('Y-m-d\TH:i') }}"
                               required>
                        @error('incident_date')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Tingkat Urgensi <span class="text-red-500">*</span></label>
                        <select name="urgency_level" class="select w-full bg-base-200 @error('urgency_level') select-error @enderror" required>
                            <option value="low" {{ old('urgency_level') == 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="medium" {{ old('urgency_level', 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="high" {{ old('urgency_level') == 'high' ? 'selected' : '' }}>Tinggi</option>
                            <option value="critical" {{ old('urgency_level') == 'critical' ? 'selected' : '' }}>Kritis</option>
                        </select>
                        @error('urgency_level')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Jumlah Korban & Kerusakan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Jumlah Korban (Opsional)</label>
                        <input type="number"
                               name="victim_count"
                               class="input w-full bg-base-200 @error('victim_count') input-error @enderror"
                               placeholder="0"
                               min="0"
                               value="{{ old('victim_count') }}">
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
                               value="{{ old('contact_phone') }}"
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
                              placeholder="Jelaskan kerusakan yang ditimbulkan (rumah, kendaraan, infrastruktur, dll)">{{ old('damage_description') }}</textarea>
                    @error('damage_description')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="divider"></div>

                <!-- Upload Foto/Video -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Lampiran Foto/Video (Opsional)</label>

                    <div class="alert alert-info mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-xs">
                            <p>• Maksimal 3 file (foto/video)</p>
                            <p>• Foto: JPG, PNG, GIF, WebP (max 3MB)</p>
                            <p>• Video: MP4, MOV, AVI (max 10MB)</p>
                        </div>
                    </div>

                    <input type="file"
                           name="attachments[]"
                           class="file-input w-full bg-base-200 @error('attachments') file-input-error @enderror"
                           accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,video/mp4,video/mpeg,video/quicktime,video/x-msvideo"
                           multiple
                           @change="handleFiles($event)"
                           x-ref="fileInput">

                    @error('attachments')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    @error('attachments.*')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <!-- File Preview -->
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4" x-show="files.length > 0">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative">
                                <div class="aspect-square rounded-lg overflow-hidden bg-base-200">
                                    <template x-if="file.type.startsWith('image/')">
                                        <img :src="file.preview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="file.type.startsWith('video/')">
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" 
                                        @click="removeFile(index)"
                                        class="btn btn-sm btn-circle btn-error absolute -top-2 -right-2">
                                    ✕
                                </button>
                                <div class="mt-1 text-xs text-center truncate" x-text="file.name"></div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 justify-end mt-6">
            <a href="{{ route('user.reports.index') }}" class="btn btn-ghost">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kirim Laporan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function reportForm() {
    return {
        files: [],
        
        handleFiles(event) {
            const fileInput = event.target;
            const selectedFiles = Array.from(fileInput.files);
            
            // Max 3 files
            if (selectedFiles.length > 3) {
                alert('Maksimal 3 file yang dapat dilampirkan');
                fileInput.value = '';
                return;
            }
            
            this.files = selectedFiles.map(file => ({
                name: file.name,
                type: file.type,
                preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null
            }));
        },
        
        removeFile(index) {
            this.files.splice(index, 1);
            this.$refs.fileInput.value = '';
            
            if (this.files.length === 0) {
                return;
            }
            
            // Recreate file list
            const dt = new DataTransfer();
            const fileInput = this.$refs.fileInput;
            const originalFiles = Array.from(fileInput.files);
            
            originalFiles.forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            
            fileInput.files = dt.files;
        }
    }
}
</script>
@endpush
@endsection