<x-layouts.user>
    <div class="max-w-3xl mx-auto space-y-4">

        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Detail Laporan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-base-content/60">Jenis Bencana</p>
                        <p class="font-semibold capitalize">
                            {{ str_replace('_', ' ', $laporan->jenis_bencana) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-base-content/60">Tanggal Kejadian</p>
                        <p class="font-semibold">
                            {{ $laporan->tanggal_kejadian->format('d M Y') }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-base-content/60">Lokasi</p>
                        <p class="font-semibold">{{ $laporan->lokasi }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-base-content/60">Deskripsi</p>
                        <p>{{ $laporan->deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dampak --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h3 class="font-semibold mb-2">Dampak</h3>

                <ul class="list-disc list-inside">
                    <li>Korban Jiwa: {{ $laporan->dampak['korban_jiwa'] }}</li>
                    <li>Korban Luka: {{ $laporan->dampak['korban_luka'] }}</li>
                    <li>
                        Kerugian Material:
                        {{ $laporan->dampak['kerugian_material'] ?? '-' }}
                    </li>
                </ul>
            </div>
        </div>

        {{-- Foto --}}
        @if ($laporan->foto)
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <img
                        src="{{ asset('storage/' . $laporan->foto) }}"
                        class="rounded-lg max-h-96 object-cover"
                    >
                </div>
            </div>
        @endif

        @if ($laporan->respon->isNotEmpty())
    <div class="card bg-base-100 shadow mt-4">
        <div class="card-body">
            <h3 class="font-semibold mb-2">Respon Admin</h3>

            <ul class="space-y-3">
                @foreach ($laporan->respon as $item)
                    <li class="border rounded p-3">
                        <p class="text-sm text-base-content/60">
                            {{ $item->created_at->format('d M Y H:i') }}
                        </p>

                        <p>{{ $item->komentar }}</p>

                        <span class="badge badge-outline mt-2">
                            {{ str_replace('_', ' ', $item->status_respon) }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if ($laporan->respon->isNotEmpty())
    <div class="card bg-base-100 shadow mt-4">
        <div class="card-body">
            <h3 class="font-semibold mb-2">Relawan Bertugas</h3>

            <ul class="list-disc list-inside">
                @foreach ($laporan->respon as $respon)
                    @foreach ($respon->relawan as $relawan)
                        <li>
                            {{ $relawan->nama }}
                            <span class="text-sm text-base-content/60">
                                ({{ $relawan->pivot->peran }})
                            </span>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if ($laporan->timeline())
    <div class="card bg-base-100 shadow mt-4">
        <div class="card-body">
            <h3 class="font-semibold mb-4">Timeline Progres</h3>

            <ul class="timeline timeline-vertical">
                @foreach ($laporan->timeline() as $item)
                    <li>
                        <div class="timeline-start text-xs">
                            {{ $item['time']->format('d M Y H:i') }}
                        </div>

                        <div class="timeline-middle">
                            <div class="badge
                                @class([
                                    'badge-warning' => $item['status'] === 'pending',
                                    'badge-info' => $item['status'] === 'verified',
                                    'badge-success' => $item['status'] === 'resolved',
                                ])
                            ">
                            </div>
                        </div>

                        <div class="timeline-end timeline-box">
                            <p class="font-semibold">{{ $item['label'] }}</p>
                            <p class="text-sm text-base-content/70">
                                {{ $item['desc'] }}
                            </p>
                        </div>

                        <hr />
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


        <div class="flex justify-end">
            <a href="{{ route('user.laporan.index') }}" class="btn btn-ghost">
                Kembali
            </a>
        </div>

    </div>
</x-layouts.user>
