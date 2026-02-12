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

    <form method="POST" action="{{ route('relawan.store') }}">
        @csrf

        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Nama <span class="text-error">*</span></span>
                        </label>
                        <input
                            type="text"
                            name="nama"
                            class="input input-bordered @error('nama') input-error @enderror"
                            value="{{ old('nama') }}"
                            maxlength="100"
                            required
                        >
                        @error('nama')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">No HP <span class="text-error">*</span></span>
                        </label>
                        <input
                            type="text"
                            name="no_hp"
                            class="input input-bordered @error('no_hp') input-error @enderror"
                            value="{{ old('no_hp') }}"
                            maxlength="20"
                            required
                        >
                        @error('no_hp')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Email <span class="text-error">*</span></span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="input input-bordered @error('email') input-error @enderror"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Alamat <span class="text-error">*</span></span>
                    </label>
                    <textarea
                        name="alamat"
                        rows="3"
                        class="textarea textarea-bordered @error('alamat') textarea-error @enderror"
                        required
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Kecamatan <span class="text-error">*</span></span>
                        </label>
                        <input
                            type="text"
                            name="kecamatan"
                            class="input input-bordered @error('kecamatan') input-error @enderror"
                            value="{{ old('kecamatan') }}"
                            maxlength="100"
                            required
                        >
                        @error('kecamatan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Kabupaten/Kota <span class="text-error">*</span></span>
                        </label>
                        <input
                            type="text"
                            name="kabupaten_kota"
                            class="input input-bordered @error('kabupaten_kota') input-error @enderror"
                            value="{{ old('kabupaten_kota') }}"
                            maxlength="100"
                            required
                        >
                        @error('kabupaten_kota')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Status Ketersediaan <span class="text-error">*</span></span>
                        </label>
                        <select name="status_ketersediaan" class="select select-bordered @error('status_ketersediaan') select-error @enderror" required>
                            <option value="available" {{ old('status_ketersediaan', 'available') === 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="on_duty" {{ old('status_ketersediaan') === 'on_duty' ? 'selected' : '' }}>Sedang Bertugas</option>
                            <option value="unavailable" {{ old('status_ketersediaan') === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                        @error('status_ketersediaan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Tahun Bergabung <span class="text-error">*</span></span>
                        </label>
                        <input
                            type="number"
                            name="tahun_bergabung"
                            class="input input-bordered @error('tahun_bergabung') input-error @enderror"
                            value="{{ old('tahun_bergabung', now()->year) }}"
                            min="2000"
                            max="{{ now()->year }}"
                            required
                        >
                        @error('tahun_bergabung')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Skill</span>
                    </label>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 rounded-lg border border-base-300 p-3">
                        @foreach($skillOptions as $skill)
                            <label class="label cursor-pointer justify-start gap-2 rounded px-2 hover:bg-base-200">
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

                    <div class="mt-3">
                        <label class="label">
                            <span class="label-text">Skill lainnya (pisahkan dengan koma)</span>
                        </label>
                        <input
                            type="text"
                            name="skill_manual"
                            class="input input-bordered @error('skill_manual') input-error @enderror"
                            value="{{ old('skill_manual') }}"
                            placeholder="Contoh: Pemetaan, Drone, Bahasa Isyarat"
                        >
                        @error('skill_manual')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    @error('skill')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                    @error('skill.*')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('relawan.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Relawan</button>
        </div>
    </form>
</div>
@endsection
