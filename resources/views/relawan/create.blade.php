@extends('layouts.app')

@section('title', 'Tambah Relawan')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Data Relawan', 'url' => route('relawan.index')],
        ['title' => 'Tambah Relawan'],
    ];

    $skillOptions = [
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

    $selectedSkills = collect((array) old('skill', []))
        ->filter(fn ($skill) => filled($skill))
        ->values()
        ->all();
@endphp

@section('content')
<div class="max-w-5xl space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Tambah Relawan</h1>
        <p class="text-sm text-gray-500 mt-1">Tambahkan data relawan baru ke sistem</p>
    </div>

    <!-- Form Card -->
    <form method="POST" action="{{ route('relawan.store') }}">
        @csrf
        
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
                        value="{{ old('nama') }}"
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
                        value="{{ old('no_hp') }}"
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
                        value="{{ old('email') }}"
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
                    >{{ old('alamat') }}</textarea>
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
                            value="{{ old('kecamatan') }}"
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
                            value="{{ old('kabupaten_kota') }}"
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
                            <option value="available" {{ old('status_ketersediaan', 'available') == 'available' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="on_duty" {{ old('status_ketersediaan') == 'on_duty' ? 'selected' : '' }}>
                                Sedang Bertugas
                            </option>
                            <option value="unavailable" {{ old('status_ketersediaan') == 'unavailable' ? 'selected' : '' }}>
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
                            value="{{ old('tahun_bergabung', date('Y')) }}"
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
            <a href="{{ route('relawan.index') }}" class="btn btn-ghost">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan Relawan
            </button>
        </div>
    </form>
</div>
@endsection