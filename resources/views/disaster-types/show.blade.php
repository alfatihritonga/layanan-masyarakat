@extends('layouts.app')

@section('title', 'Detail Jenis Bencana')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Jenis Bencana', 'url' => route('disaster-types.index')],
        ['title' => 'Detail Jenis Bencana'],
    ];

    $color = is_string($disasterType->color) && preg_match('/^#[0-9A-Fa-f]{6}$/', $disasterType->color)
        ? $disasterType->color
        : null;
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
        <a href="{{ route('disaster-types.index') }}" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Jenis Bencana
        </a>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('disaster-types.edit', $disasterType->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <form method="POST" action="{{ route('disaster-types.destroy', $disasterType->id) }}" onsubmit="return confirm('Hapus jenis bencana ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-sm">Hapus</button>
            </form>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body space-y-5">
            <div class="border-b border-base-200 pb-4">
                <h1 class="text-2xl font-bold">{{ $disasterType->name }}</h1>
                <p class="text-sm text-gray-500 mt-1">Jenis bencana ID #{{ $disasterType->id }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Nama</div>
                        <div class="mt-1">{{ $disasterType->name }}</div>
                    </div>

                    <div>
                        <div class="text-sm font-semibold text-gray-500">Deskripsi</div>
                        @if($disasterType->description)
                            <div class="mt-1 whitespace-pre-line">{{ $disasterType->description }}</div>
                        @else
                            <div class="mt-1 text-gray-400">-</div>
                        @endif
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-semibold text-gray-500">Icon</div>
                        @if($disasterType->icon)
                            <div class="mt-1 font-mono text-sm">{{ $disasterType->icon }}</div>
                        @else
                            <div class="mt-1 text-gray-400">-</div>
                        @endif
                    </div>

                    <div>
                        <div class="text-sm font-semibold text-gray-500">Warna</div>
                        @if($color)
                            <div class="mt-1 flex items-center gap-2">
                                <span class="inline-block w-6 h-6 rounded border border-base-300" style="background-color: {{ $color }}"></span>
                                <span class="font-mono text-sm">{{ strtoupper($color) }}</span>
                            </div>
                        @else
                            <div class="mt-1 text-gray-400">-</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
