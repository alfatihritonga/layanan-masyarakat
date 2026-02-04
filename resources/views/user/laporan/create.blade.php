<x-layouts.user>
    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Laporan Bencana</h2>

                <form
                    action="{{ route('user.laporan.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-4"
                >
                    @csrf

                    {{-- Jenis Bencana --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Jenis Bencana</span>
                        </label>
                        <select
                            name="jenis_bencana"
                            class="select select-bordered w-full @error('jenis_bencana') select-error @enderror"
                            required
                        >
                            <option value="">Pilih Jenis Bencana</option>
                            @foreach ([
                                'banjir' => 'Banjir',
                                'gempa_bumi' => 'Gempa Bumi',
                                'tanah_longsor' => 'Tanah Longsor',
                                'kebakaran' => 'Kebakaran',
                                'tsunami' => 'Tsunami',
                                'gunung_meletus' => 'Gunung Meletus',
                                'angin_puting_beliung' => 'Angin Puting Beliung',
                                'kekeringan' => 'Kekeringan',
                                'lainnya' => 'Lainnya',
                            ] as $key => $label)
                                <option value="{{ $key }}" {{ old('jenis_bencana') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Tanggal Kejadian</span>
                        </label>
                        <input
                            type="date"
                            name="tanggal_kejadian"
                            value="{{ old('tanggal_kejadian') }}"
                            class="input input-bordered w-full @error('tanggal_kejadian') input-error @enderror"
                            required
                        >
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Lokasi Kejadian</span>
                        </label>
                        <input
                            type="text"
                            name="lokasi"
                            value="{{ old('lokasi') }}"
                            class="input input-bordered w-full @error('lokasi') input-error @enderror"
                            required
                        >
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Deskripsi</span>
                        </label>
                        <textarea
                            name="deskripsi"
                            rows="4"
                            class="textarea textarea-bordered w-full @error('deskripsi') textarea-error @enderror"
                            required
                        >{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="divider">Dampak Bencana</div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="number" name="korban_jiwa" min="0"
                            class="input input-bordered"
                            value="{{ old('korban_jiwa', 0) }}"
                            placeholder="Korban Jiwa">

                        <input type="number" name="korban_luka" min="0"
                            class="input input-bordered"
                            value="{{ old('korban_luka', 0) }}"
                            placeholder="Korban Luka">

                        <input type="text" name="kerugian_material"
                            class="input input-bordered"
                            value="{{ old('kerugian_material') }}"
                            placeholder="Kerugian Material">
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Foto Bukti</span>
                        </label>
                        <input
                            type="file"
                            name="foto"
                            class="file-input file-input-bordered w-full"
                        >
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-ghost">
                            Batal
                        </a>
                        <button class="btn btn-primary">
                            Kirim Laporan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-layouts.user>
