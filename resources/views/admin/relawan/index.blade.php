<x-layouts.admin>
    <div class="p-4 flex justify-between items-center">
        <h1 class="text-xl sm:text-2xl font-bold">Daftar Relawan</h1>
        <a href="{{ route('admin.relawan.create') }}" class="btn btn-primary btn-md rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"></path></svg>
            Tambah
        </a>
    </div>
    <div class="px-4 pb-4">        
        <form method="GET" action="{{ route('admin.relawan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <label class="input w-full rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m20.25 20.25-4.123-4.123m0 0A7.25 7.25 0 1 0 5.873 5.873a7.25 7.25 0 0 0 10.253 10.253Z"></path></svg>
                <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" class="grow bg-transparent outline-none" placeholder="Search...">
            </label>
            
            <label class="select rounded-lg w-full">
                <span class="label">Status</span>
                <select name="status">
                    <option value="">All</option>
                    <option value="available" {{ ($filters['status'] ?? '') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="on_duty" {{ ($filters['status'] ?? '') == 'on_duty' ? 'selected' : '' }}>On Duty</option>
                    <option value="unavailable" {{ ($filters['status'] ?? '') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </label>
            
            <label class="input w-full rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m20.25 20.25-4.123-4.123m0 0A7.25 7.25 0 1 0 5.873 5.873a7.25 7.25 0 0 0 10.253 10.253Z"></path></svg>
                <input type="search" name="kabupaten" value="{{ $filters['kabupaten'] ?? '' }}" class="grow bg-transparent outline-none" placeholder="Kabupaten/Kota">
            </label>
            
            <div class="flex gap-2 justify-end">
                <a href="{{ route('admin.relawan.index') }}" class="btn btn-ghost rounded-lg">
                    Reset
                </a>
                <button type="submit" class="btn btn-info btn-ghost rounded-lg">
                    Filter
                </button>
            </div>
        </form>
    </div>
    
    <div class="w-full overflow-x-auto lg:overflow-visible">
        <table class="w-full">
            <thead class="text-left font-medium uppercase whitespace-nowrap text-xs">
                <tr class="outline outline-base-content/20 bg-base-200">
                    <th class="p-3 text-center">#</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Kontak</th>
                    <th class="p-3">Wilayah</th>
                    <th class="p-3">Skill</th>
                    <th class="p-3">Status</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-500 dark:text-gray-400">
                @forelse ($relawan as $r)
                
                <tr>
                    <td class="p-3 text-center">{{ $loop->iteration }}</td>
                    
                    {{-- Nama --}}
                    <td class="p-3">
                        <div class="font-semibold">
                            {{ $r->nama }}
                        </div>
                        <div class="text-xs text-base-content/60">
                            {{ $r->email }}
                        </div>
                    </td>
                    
                    {{-- Kontak --}}
                    <td class="p-3">
                        {{ $r->no_hp }}
                    </td>
                    
                    {{-- Wilayah --}}
                    <td class="p-3">
                        <div class="text-sm">
                            {{ $r->kecamatan ?? '-' }}
                        </div>
                        <div class="text-xs text-base-content/60">
                            {{ $r->kabupaten_kota ?? '-' }}
                        </div>
                    </td>
                    
                    {{-- Skill --}}
                    <td class="p-3">
                        @if (!empty($r->skill))
                        <div class="flex flex-wrap gap-1">
                            @foreach ($r->skill as $skill)
                            <span class="badge badge-outline badge-sm rounded-sm">
                                {{ $skill }}
                            </span>
                            @endforeach
                        </div>
                        @else
                        <span class="text-xs text-base-content/50">
                            -
                        </span>
                        @endif
                    </td>
                    
                    {{-- Status --}}
                    @php
                    $statusClasses = [
                    'available'   => 'badge-success',
                    'on_duty'     => 'badge-warning',
                    'unavailable' => 'badge-error',
                    ];
                    
                    $status = $r->status_ketersediaan;
                    @endphp
                    <td class="p-3">
                        <span class="badge badge-sm {{ $statusClasses[$status] ?? 'badge-ghost' }} rounded-sm">
                            {{ ucwords(str_replace('_', ' ', $status)) }}
                        </span>
                    </td>
                    
                    {{-- Aksi --}}
                    <td class="p-3 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.relawan.edit', $r) }}" class="btn btn-sm btn-ghost">
                                Edit
                            </a>
                            
                            <form action="{{ route('admin.relawan.destroy', $r) }}" method="POST" onsubmit="return confirm('Hapus relawan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline btn-error">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="7" class="p-3 text-center text-base-content/60">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
                
            </tbody>
        </table>
    </div>
    
    {{-- Pagination --}}
    <div class="p-4">
        {{ $relawan->links() }}
    </div>
</x-layouts.admin>
