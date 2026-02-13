@extends('layouts.app')

@section('title', 'Tambah Jenis Bencana')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Jenis Bencana', 'url' => route('disaster-types.index')],
        ['title' => 'Tambah Jenis Bencana'],
    ];

    $oldColor = old('color');
    $previewColor = is_string($oldColor) && preg_match('/^#[0-9A-Fa-f]{6}$/', $oldColor)
        ? $oldColor
        : null;
@endphp

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Tambah Jenis Bencana</h1>
        <p class="text-sm text-gray-500 mt-1">Tambahkan jenis bencana baru ke master data</p>
    </div>

    <form method="POST" action="{{ route('disaster-types.store') }}">
        @csrf

        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Nama <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="name"
                        class="input w-full bg-base-200 @error('name') input-error @enderror"
                        value="{{ old('name') }}"
                        maxlength="100"
                        required
                    >
                    @error('name')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="textarea w-full bg-base-200 @error('description') textarea-error @enderror"
                        maxlength="500"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Icon SVG</label>
                        <textarea
                            name="icon_svg"
                            rows="4"
                            class="textarea w-full bg-base-200 @error('icon_svg') textarea-error @enderror"
                            placeholder="Tempelkan SVG di sini"
                        >{{ old('icon_svg') }}</textarea>
                        @error('icon_svg')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Warna (Hex)</label>
                        <input
                            type="text"
                            name="color"
                            class="input w-full bg-base-200 @error('color') input-error @enderror"
                            value="{{ old('color') }}"
                            maxlength="7"
                            placeholder="#FF5733"
                        >
                        @error('color')
                            <p class="text-xs text-red-500">{{ $message }}</p>
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

        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ route('disaster-types.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Jenis Bencana</button>
        </div>
    </form>
</div>
@endsection
