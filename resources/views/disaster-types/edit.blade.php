@extends('layouts.app')

@section('title', 'Edit Jenis Bencana')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Jenis Bencana', 'url' => route('disaster-types.index')],
        ['title' => 'Detail Jenis Bencana', 'url' => route('disaster-types.show', $disasterType->id)],
        ['title' => 'Edit'],
    ];

    $currentColor = old('color', $disasterType->color);
    $previewColor = is_string($currentColor) && preg_match('/^#[0-9A-Fa-f]{6}$/', $currentColor)
        ? $currentColor
        : null;
@endphp

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold">Edit Jenis Bencana</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data jenis bencana #{{ $disasterType->id }}</p>
        </div>
        <a href="{{ route('disaster-types.show', $disasterType->id) }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Detail
        </a>
    </div>

    <form method="POST" action="{{ route('disaster-types.update', $disasterType->id) }}">
        @csrf
        @method('PUT')

        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-5">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Nama <span class="text-error">*</span></span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="input input-bordered @error('name') input-error @enderror"
                        value="{{ old('name', $disasterType->name) }}"
                        maxlength="100"
                        required
                    >
                    @error('name')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Deskripsi</span>
                    </label>
                    <textarea
                        name="description"
                        rows="4"
                        class="textarea textarea-bordered @error('description') textarea-error @enderror"
                        maxlength="500"
                    >{{ old('description', $disasterType->description) }}</textarea>
                    @error('description')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Icon</span>
                        </label>
                        <input
                            type="text"
                            name="icon"
                            class="input input-bordered @error('icon') input-error @enderror"
                            value="{{ old('icon', $disasterType->icon) }}"
                            maxlength="100"
                            placeholder="Contoh: flood, house-damage"
                        >
                        @error('icon')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Warna (Hex)</span>
                        </label>
                        <input
                            type="text"
                            name="color"
                            class="input input-bordered @error('color') input-error @enderror"
                            value="{{ old('color', $disasterType->color) }}"
                            maxlength="7"
                            placeholder="#FF5733"
                        >
                        @error('color')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                @if($previewColor)
                    <div class="flex items-center gap-2 text-sm">
                        <span class="font-semibold text-gray-500">Preview warna:</span>
                        <span class="inline-block w-5 h-5 rounded border border-base-300" style="background-color: {{ $previewColor }}"></span>
                        <span class="font-mono">{{ strtoupper($previewColor) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('disaster-types.show', $disasterType->id) }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
