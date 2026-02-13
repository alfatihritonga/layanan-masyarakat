@extends('layouts.app')

@section('title', 'Edit Relawan')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Data Relawan', 'url' => route('relawan.index')],
        ['title' => 'Detail Relawan', 'url' => route('relawan.show', $relawan->id)],
        ['title' => 'Edit'],
    ];

    $defaultSkillOptions = [
        'P3K',
        'Evakuasi',
        'Medis',
        'Komunikasi',
        'Logistik',
        'SAR',
        'Trauma Healing',
        'Dapur Umum',
        'Administrasi',
    ];

    $selectedSkills = collect((array) old('skill', $relawan->skill ?? []))
        ->filter(fn ($skill) => filled($skill))
        ->values()
        ->all();

    $skillOptions = collect(array_merge($defaultSkillOptions, $selectedSkills))
        ->unique()
        ->values()
        ->all();
@endphp

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold">Edit Relawan</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi relawan #{{ $relawan->id }}</p>
        </div>
        <a href="{{ route('relawan.show', $relawan->id) }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Detail
        </a>
    </div>

    <!-- Form Card -->
    <form method="POST" action="{{ route('relawan.update', $relawan->id) }}">
        @csrf
        @method('PUT')
        
        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-6">
                
                <!-- Nama -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama"
                        class="input w-full bg-base-200 @error('nama') input-error @enderror"
                        value="{{ old('nama', $relawan->nama) }}"
                        placeholder="Masukkan nama lengkap relawan"
                        required
                    >
                    @error('nama')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor HP -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Nomor HP <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="tel"
                        name="no_hp"
                        class="input w-full bg-base-200 @error('no_hp') input-error @enderror"
                        value="{{ old('no_hp', $relawan->no_hp) }}"
                        placeholder="08123456789"
                        required
                    >
                    @error('no_hp')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="input w-full bg-base-200 @error('email') input-error @enderror"
                        value="{{ old('email', $relawan->email) }}"
                        placeholder="email@example.com"
                        required
                    >
                    @error('email')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="alamat"
                        rows="3"
                        class="textarea w-full bg-base-200 @error('alamat') textarea-error @enderror"
                        placeholder="Masukkan alamat lengkap"
                        required
                    >{{ old('alamat', $relawan->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kecamatan & Kabupaten/Kota -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kecamatan -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="kecamatan"
                            class="input w-full bg-base-200 @error('kecamatan') input-error @enderror"
                            value="{{ old('kecamatan', $relawan->kecamatan) }}"
                            placeholder="Contoh: Medan Selayang"
                            required
                        >
                        @error('kecamatan')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kabupaten/Kota -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">
                            Kabupaten/Kota <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="kabupaten_kota"
                            class="input w-full bg-base-200 @error('kabupaten_kota') input-error @enderror"
                            value="{{ old('kabupaten_kota', $relawan->kabupaten_kota) }}"
                            placeholder="Contoh: Kota Medan"
                            required
                        >
                        @error('kabupaten_kota')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Skill -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Keahlian/Skill <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-2">Pilih minimal 1 keahlian yang dimiliki</p>
                    
                    <!-- Skill Options Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 rounded-lg border border-base-300 p-3 bg-base-200">
                        @foreach($skillOptions as $skill)
                            <label class="label cursor-pointer justify-start gap-2 rounded px-2 hover:bg-base-100 transition">
                                <input
                                    type="checkbox"
                                    name="skill[]"
                                    value="{{ $skill }}"
                                    class="checkbox checkbox-sm"
                                    {{ in_array($skill, $selectedSkills, true) ? 'checked' : '' }}
                                >
                                <span class="label-text">{{ $skill }}</span>
                            </label>
                        @endforeach
                    </div>

                    <!-- Manual Skill Input -->
                    <div class="mt-3">
                        <label class="text-xs text-gray-500 mb-1 block">
                            Skill lainnya (pisahkan dengan koma)
                        </label>
                        <input
                            type="text"
                            name="skill_manual"
                            class="input w-full bg-base-200 input-sm @error('skill_manual') input-error @enderror"
                            value="{{ old('skill_manual') }}"
                            placeholder="Contoh: Pemetaan, Drone, Bahasa Isyarat"
                        >
                        @error('skill_manual')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @error('skill')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    @error('skill.*')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="divider"></div>

                <!-- Status Ketersediaan & Tahun Bergabung -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Status Ketersediaan -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">
                            Status Ketersediaan <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="status_ketersediaan"
                            class="select w-full bg-base-200 @error('status_ketersediaan') select-error @enderror"
                            required
                        >
                            <option value="">Pilih Status</option>
                            <option value="available" {{ old('status_ketersediaan', $relawan->status_ketersediaan) == 'available' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="on_duty" {{ old('status_ketersediaan', $relawan->status_ketersediaan) == 'on_duty' ? 'selected' : '' }}>
                                Sedang Bertugas
                            </option>
                            <option value="unavailable" {{ old('status_ketersediaan', $relawan->status_ketersediaan) == 'unavailable' ? 'selected' : '' }}>
                                Tidak Tersedia
                            </option>
                        </select>
                        @error('status_ketersediaan')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Bergabung -->
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">
                            Tahun Bergabung <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="tahun_bergabung"
                            class="input w-full bg-base-200 @error('tahun_bergabung') input-error @enderror"
                            value="{{ old('tahun_bergabung', $relawan->tahun_bergabung) }}"
                            min="2000"
                            max="{{ date('Y') }}"
                            placeholder="{{ date('Y') }}"
                            required
                        >
                        @error('tahun_bergabung')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 justify-end mt-6">
            <a href="{{ route('relawan.show', $relawan->id) }}" class="btn btn-ghost">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection