@extends('layouts.app')

@section('title', 'Jenis Bencana')

@php
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Jenis Bencana'],
    ];
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold">Jenis Bencana</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola master data jenis bencana</p>
        </div>
        <a href="{{ route('disaster-types.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jenis Bencana
        </a>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form method="GET" action="{{ route('disaster-types.index') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Cari</span></label>
                    <input
                        type="text"
                        name="search"
                        class="input input-bordered"
                        placeholder="Nama atau deskripsi"
                        value="{{ $filters['search'] ?? '' }}"
                    >
                </div>

                <div class="form-control md:col-span-2">
                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('disaster-types.index') }}" class="btn btn-ghost">Reset</a>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Icon</th>
                            <th>Warna</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($disasterTypes as $item)
                            @php
                                $color = is_string($item->color) && preg_match('/^#[0-9A-Fa-f]{6}$/', $item->color)
                                    ? $item->color
                                    : null;
                            @endphp
                            <tr>
                                <td>{{ $disasterTypes->firstItem() ? $disasterTypes->firstItem() + $loop->index : $loop->iteration }}</td>
                                <td>
                                    <div class="font-semibold">{{ $item->name }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $item->id }}</div>
                                </td>
                                <td>
                                    @if($item->description)
                                        <div class="max-w-md">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->icon)
                                        <span class="font-mono text-xs">{{ $item->icon }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($color)
                                        <div class="flex items-center gap-2">
                                            <span class="inline-block w-4 h-4 rounded border border-base-300" style="background-color: {{ $color }}"></span>
                                            <span class="font-mono text-xs">{{ strtoupper($color) }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('disaster-types.show', $item->id) }}" class="btn btn-ghost btn-xs">Detail</a>
                                        <a href="{{ route('disaster-types.edit', $item->id) }}" class="btn btn-ghost btn-xs">Edit</a>
                                        <form method="POST" action="{{ route('disaster-types.destroy', $item->id) }}" onsubmit="return confirm('Hapus jenis bencana ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-10">Data jenis bencana tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($disasterTypes->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $disasterTypes->appends($filters)->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
