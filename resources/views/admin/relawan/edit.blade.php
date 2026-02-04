<x-layouts.admin>
    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-4">

                <h2 class="card-title">Edit Relawan</h2>

                <form
                    method="POST"
                    action="{{ route('admin.relawan.update', $relawan) }}"
                    class="space-y-4"
                >
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Nama</span>
                        </label>
                        <input
                            type="text"
                            name="nama"
                            class="input input-bordered w-full @error('nama') input-error @enderror"
                            value="{{ old('nama', $relawan->nama) }}"
                            required
                        >
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">No HP</span>
                        </label>
                        <input
                            type="text"
                            name="no_hp"
                            class="input input-bordered w-full @error('no_hp') input-error @enderror"
                            value="{{ old('no_hp', $relawan->no_hp) }}"
                            required
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Email</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            class="input input-bordered w-full @error('email') input-error @enderror"
                            value="{{ old('email', $relawan->email) }}"
                            required
                        >
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Alamat</span>
                        </label>
                        <textarea
                            name="alamat"
                            class="textarea textarea-bordered w-full @error('alamat') textarea-error @enderror"
                            rows="3"
                            required
                        >{{ old('alamat', $relawan->alamat) }}</textarea>
                    </div>

                    {{-- Wilayah --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label">
                                <span class="label-text font-semibold">Kecamatan</span>
                            </label>
                            <input
                                type="text"
                                name="kecamatan"
                                class="input input-bordered w-full @error('kecamatan') input-error @enderror"
                                value="{{ old('kecamatan', $relawan->kecamatan) }}"
                                required
                            >
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text font-semibold">Kabupaten / Kota</span>
                            </label>
                            <input
                                type="text"
                                name="kabupaten_kota"
                                class="input input-bordered w-full @error('kabupaten_kota') input-error @enderror"
                                value="{{ old('kabupaten_kota', $relawan->kabupaten_kota) }}"
                                required
                            >
                        </div>
                    </div>

                    {{-- Tahun Bergabung --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Tahun Bergabung</span>
                        </label>
                        <input
                            type="number"
                            name="tahun_bergabung"
                            class="input input-bordered w-full @error('tahun_bergabung') input-error @enderror"
                            value="{{ old('tahun_bergabung', $relawan->tahun_bergabung) }}"
                            min="2000"
                            max="{{ date('Y') }}"
                            required
                        >
                    </div>

                    {{-- Status Ketersediaan --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Status Ketersediaan</span>
                        </label>
                        <select
                            name="status_ketersediaan"
                            class="select select-bordered w-full @error('status_ketersediaan') select-error @enderror"
                            required
                        >
                            <option value="available" @selected(old('status_ketersediaan', $relawan->status_ketersediaan) === 'available')>
                                Available
                            </option>
                            <option value="on_duty" @selected(old('status_ketersediaan', $relawan->status_ketersediaan) === 'on_duty')>
                                On Duty
                            </option>
                            <option value="unavailable" @selected(old('status_ketersediaan', $relawan->status_ketersediaan) === 'unavailable')>
                                Unavailable
                            </option>
                        </select>
                    </div>

                    {{-- Skill (JSON Array) --}}
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Skill</span>
                        </label>

                        @php
                            $skills = old('skill', $relawan->skill ?? []);
                        @endphp

                        <div class="space-y-2">
                            @forelse ($skills as $skill)
                                <input
                                    type="text"
                                    name="skill[]"
                                    class="input input-bordered w-full"
                                    value="{{ $skill }}"
                                >
                            @empty
                                <input
                                    type="text"
                                    name="skill[]"
                                    class="input input-bordered w-full"
                                    placeholder="Contoh: Medis"
                                >
                            @endforelse

                            {{-- tambahan input kosong --}}
                            <input
                                type="text"
                                name="skill[]"
                                class="input input-bordered w-full"
                                placeholder="Skill tambahan (opsional)"
                            >
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="flex justify-end gap-2">
                        <a
                            href="{{ route('admin.relawan.index') }}"
                            class="btn btn-ghost"
                        >
                            Batal
                        </a>

                        <button class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
