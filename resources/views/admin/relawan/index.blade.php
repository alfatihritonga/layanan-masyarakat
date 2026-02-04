<x-layouts.admin>
    <div class="card bg-base-100 shadow">
        <div class="card-body">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">
                <h2 class="card-title">Data Relawan</h2>

                <a
                    href="{{ route('admin.relawan.create') }}"
                    class="btn btn-primary btn-sm"
                >
                    + Tambah Relawan
                </a>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Wilayah</th>
                            <th>Skill</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($relawans as $relawan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- Nama --}}
                                <td>
                                    <div class="font-semibold">
                                        {{ $relawan->nama }}
                                    </div>
                                    <div class="text-xs text-base-content/60">
                                        {{ $relawan->email }}
                                    </div>
                                </td>

                                {{-- Kontak --}}
                                <td>
                                    {{ $relawan->no_hp }}
                                </td>

                                {{-- Wilayah --}}
                                <td>
                                    <div class="text-sm">
                                        {{ $relawan->kecamatan }}
                                    </div>
                                    <div class="text-xs text-base-content/60">
                                        {{ $relawan->kabupaten_kota }}
                                    </div>
                                </td>

                                {{-- Skill --}}
                                <td>
                                    @if (!empty($relawan->skill))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($relawan->skill as $skill)
                                                <span class="badge badge-outline badge-sm">
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
                                <td>
                                    <span class="badge
                                        @class([
                                            'badge-success' => $relawan->status_ketersediaan === 'available',
                                            'badge-warning' => $relawan->status_ketersediaan === 'on_duty',
                                            'badge-error'   => $relawan->status_ketersediaan === 'unavailable',
                                        ])
                                    ">
                                        {{ str_replace('_', ' ', ucfirst($relawan->status_ketersediaan)) }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-right">
                                    <div class="flex justify-end gap-1">
                                        <a
                                            href="{{ route('admin.relawan.edit', $relawan) }}"
                                            class="btn btn-ghost btn-xs"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.relawan.destroy', $relawan) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus relawan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-ghost btn-xs text-error">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-base-content/60">
                                    Belum ada data relawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $relawans->links() }}
            </div>

        </div>
    </div>
</x-layouts.admin>
