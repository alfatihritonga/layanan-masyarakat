<x-layouts.admin>
    <div class="max-w-3xl mx-auto space-y-4">
        
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Detail Laporan</h2>
                
                <p><strong>Pelapor:</strong> {{ $laporan->user->name }}</p>
                <p><strong>Jenis:</strong> {{ str_replace('_', ' ', $laporan->jenis_bencana) }}</p>
                <p><strong>Tanggal:</strong> {{ $laporan->tanggal_kejadian->format('d M Y') }}</p>
                <p><strong>Lokasi:</strong> {{ $laporan->lokasi }}</p>
                
                <div class="mt-2">
                    <p class="font-semibold">Deskripsi</p>
                    <p>{{ $laporan->deskripsi }}</p>
                </div>
            </div>
        </div>
        
        {{-- Dampak --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h3 class="font-semibold">Dampak</h3>
                <ul class="list-disc list-inside">
                    <li>Korban Jiwa: {{ $laporan->dampak['korban_jiwa'] }}</li>
                    <li>Korban Luka: {{ $laporan->dampak['korban_luka'] }}</li>
                    <li>Kerugian Material: {{ $laporan->dampak['kerugian_material'] ?? '-' }}</li>
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
        
        {{-- Aksi --}}
        @if ($laporan->status === 'pending')
        <div class="flex gap-2 justify-end">
            <form
            method="POST"
            action="{{ route('admin.laporan.verifikasi', $laporan) }}"
            >
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="resolved">
            <button class="btn btn-error">
                Tolak
            </button>
        </form>
        
        <form
        method="POST"
        action="{{ route('admin.laporan.verifikasi', $laporan) }}"
        >
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="verified">
        <button class="btn btn-success">
            Verifikasi
        </button>
    </form>
</div>
@endif

@if ($laporan->respon->isNotEmpty())
<div class="card bg-base-100 shadow">
    <div class="card-body">
        <h3 class="font-semibold mb-2">Riwayat Respon</h3>
        
        <ul class="space-y-3">
            @foreach ($laporan->respon as $item)
            <li class="border rounded p-3">
                <p class="text-sm text-base-content/60">
                    {{ $item->user->name }} •
                    {{ $item->created_at->format('d M Y H:i') }}
                </p>
                
                <p class="mt-1">{{ $item->komentar }}</p>
                
                <p class="text-xs mt-2">
                    Status:
                    <span class="badge badge-outline">
                        {{ str_replace('_', ' ', $item->status_respon) }}
                    </span>
                </p>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if ($laporan->status !== 'resolved')
<div class="card bg-base-100 shadow mt-4">
    <div class="card-body">
        <h3 class="font-semibold mb-2">Tambah Respon</h3>
        
        <form
        action="{{ route('admin.laporan.respon', $laporan) }}"
        method="POST"
        class="space-y-3"
        >
        @csrf
        
        <textarea
        name="komentar"
        rows="4"
        class="textarea textarea-bordered w-full"
        placeholder="Tulis respon atau tindak lanjut..."
        required
        ></textarea>
        
        <select
        name="status_respon"
        class="select select-bordered w-full"
        required
        >
        <option value="in_progress">Sedang Ditangani</option>
        <option value="completed">Selesai</option>
    </select>
    
    <div class="flex justify-end">
        <button class="btn btn-primary">
            Simpan Respon
        </button>
    </div>
</form>
</div>
</div>
@endif

@if ($laporan->respon->isNotEmpty())
    @php
        $responAktif = $laporan->respon->last();
    @endphp

    <div class="card bg-base-100 shadow mt-4">
        <div class="card-body">
            <h3 class="font-semibold mb-3">Assign Relawan</h3>

            <form
                action="{{ route('admin.respon.assign-relawan', $responAktif) }}"
                method="POST"
                class="space-y-3"
            >
                @csrf

                @foreach ($relawans as $relawan)
                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="relawan[{{ $loop->index }}][id]"
                            value="{{ $relawan->id }}"
                            class="checkbox"
                        >

                        <span class="flex-1">{{ $relawan->nama }}</span>

                        <input
                            type="text"
                            name="relawan[{{ $loop->index }}][peran]"
                            class="input input-bordered input-sm"
                            placeholder="Peran"
                        >
                    </div>
                @endforeach

                <div class="flex justify-end">
                    <button class="btn btn-primary btn-sm">
                        Simpan Relawan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif



</div>
</x-layouts.admin>
