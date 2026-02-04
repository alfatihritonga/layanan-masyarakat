<x-layouts.user>
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Riwayat Laporan Bencana</h2>

                <a href="{{ route('user.laporan.create') }}" class="btn btn-primary btn-sm">
                    + Buat Laporan
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
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
                                            'badge-primary' => $laporan->status === 'diproses',
                                            'badge-success' => $laporan->status === 'selesai',
                                            'badge-error' => $laporan->status === 'ditolak',
                                        ])
                                    ">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a
                                        href="{{ route('user.laporan.show', $laporan) }}"
                                        class="btn btn-ghost btn-xs"
                                    >
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-base-content/60">
                                    Belum ada laporan.
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
</x-layouts.user>
