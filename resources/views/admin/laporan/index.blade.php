<x-layouts.admin>
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title mb-4">Laporan Masyarakat</h2>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pelapor</th>
                            <th>Jenis</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporans as $laporan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $laporan->user->name }}</td>
                                <td class="capitalize">
                                    {{ str_replace('_', ' ', $laporan->jenis_bencana) }}
                                </td>
                                <td>{{ $laporan->lokasi }}</td>
                                <td>{{ $laporan->tanggal_kejadian->format('d M Y') }}</td>
                                <td>
                                    <span class="badge
                                        @class([
                                            'badge-warning' => $laporan->status === 'menunggu',
                                            'badge-info' => $laporan->status === 'diverifikasi',
                                            'badge-success' => $laporan->status === 'selesai',
                                            'badge-error' => $laporan->status === 'ditolak',
                                        ])
                                    ">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a
                                        href="{{ route('admin.laporan.show', $laporan) }}"
                                        class="btn btn-ghost btn-xs"
                                    >
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-base-content/60">
                                    Tidak ada laporan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
