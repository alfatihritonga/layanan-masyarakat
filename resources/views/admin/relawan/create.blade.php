<x-layouts.admin>
    @php
        $isEdit = isset($relawan);

        $pageTitle = $isEdit ? 'Edit Relawan' : 'Tambah Relawan';
        $pageDesc  = $isEdit
            ? 'Perbarui data relawan yang sudah terdaftar.'
            : 'Lengkapi formulir dibawah ini untuk mencatat data relawan baru.';

        $statuses = [
            'available'   => 'Available',
            'on_duty'     => 'On Duty',
            'unavailable' => 'Unavailable',
        ];

        $skills = old(
            'skill',
            $isEdit ? ($relawan->skill ?? []) : ['']
        );
    @endphp

    <div class="p-4">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="text-lg sm:text-xl font-semibold">
                {{ $pageTitle }}
            </h1>
            <p class="text-sm text-gray-500">
                {{ $pageDesc }}
            </p>
        </div>

        <!-- Form -->
        <form
            action="{{ $isEdit
                ? route('admin.relawan.update', $relawan)
                : route('admin.relawan.store') }}"
            method="POST"
            class="flex flex-col gap-4"
        >
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <!-- Nama -->
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">
                    Nama <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama"
                    class="input w-full bg-base-200 @error('nama') input-error @enderror"
                    value="{{ old('nama', $relawan->nama ?? '') }}"
                    required
                >
                @error('nama')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="input w-full bg-base-200"
                        value="{{ old('email', $relawan->email ?? '') }}"
                        required
                    >
                    @error('email')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Nomor HP <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="no_hp"
                        class="input w-full bg-base-200"
                        value="{{ old('no_hp', $relawan->no_hp ?? '') }}"
                        required
                    >
                    @error('no_hp')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="alamat"
                    rows="3"
                    class="textarea w-full bg-base-200"
                    required
                >{{ old('alamat', $relawan->alamat ?? '') }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Kecamatan -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Kecamatan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="kecamatan"
                        class="input w-full bg-base-200"
                        value="{{ old('kecamatan', $relawan->kecamatan ?? '') }}"
                        required
                    >
                    @error('kecamatan')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kabupaten -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">
                        Kabupaten/Kota <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="kabupaten_kota"
                        class="input w-full bg-base-200"
                        value="{{ old('kabupaten_kota', $relawan->kabupaten_kota ?? '') }}"
                        required
                    >
                    @error('kabupaten_kota')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tahun Bergabung -->
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">
                    Tahun Bergabung <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    name="tahun_bergabung"
                    min="2000"
                    max="{{ now()->year }}"
                    class="input w-full bg-base-200"
                    value="{{ old('tahun_bergabung', $relawan->tahun_bergabung ?? '') }}"
                    required
                >
                @error('tahun_berh')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">
                    Status Ketersediaan
                </label>
                <select name="status_ketersediaan" class="select w-full">
                    @foreach ($statuses as $value => $label)
                        <option
                            value="{{ $value }}"
                            @selected(old('status_ketersediaan', $relawan->status_ketersediaan ?? '') === $value)
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Skill -->
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold">
                    Skill <span class="text-red-500">*</span>
                </label>

                <div id="skill-wrapper" class="flex flex-col gap-2">
                    @foreach ($skills as $skill)
                        <div class="flex gap-2">
                            <input
                                type="text"
                                name="skill[]"
                                value="{{ $skill }}"
                                class="input w-full bg-base-200"
                                required
                            >
                            <button
                                type="button"
                                onclick="removeSkill(this)"
                                class="btn btn-error text-white"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path fill="currentColor" d="m5.69 20.314-.749.049zm12.62 0 .749.049zM2.75 5a.75.75 0 0 0 0 1.5zm18.5 1.5a.75.75 0 0 0 0-1.5zM10.5 10.75a.75.75 0 0 0-1.5 0zM9 16.25a.75.75 0 0 0 1.5 0zm6-5.5a.75.75 0 0 0-1.5 0zm-1.5 5.5a.75.75 0 0 0 1.5 0zm1.648-10.313a.75.75 0 1 0 1.452-.374zM4.002 5.798l.94 14.565 1.496-.097-.94-14.564zM6.688 22h10.624v-1.5H6.688zm12.37-1.637.94-14.565-1.496-.096-.94 14.564 1.497.097ZM19.25 5H4.75v1.5h14.5zM2.75 6.5h2V5h-2zm16.5 0h2V5h-2zM17.312 22a1.75 1.75 0 0 0 1.747-1.637l-1.497-.097a.25.25 0 0 1-.25.234zm-12.37-1.637A1.75 1.75 0 0 0 6.687 22v-1.5a.25.25 0 0 1-.25-.234l-1.497.097ZM9 10.75v5.5h1.5v-5.5zm4.5 0v5.5H15v-5.5zM12 3.5a3.25 3.25 0 0 1 3.148 2.437l1.452-.374A4.75 4.75 0 0 0 12 2zM8.852 5.937A3.25 3.25 0 0 1 12 3.5V2a4.75 4.75 0 0 0-4.6 3.563z"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="text-sm opacity-60">
                    Kemampuan yang dimiliki relawan. Tambahkan minimal satu skill.
                </div>

                <button
                    type="button"
                    onclick="addSkill()"
                    class="btn btn-info w-fit mt-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"></path></svg>
                    Tambah Skill
                </button>
            </div>

            <!-- Action -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                <a
                    href="{{ route('admin.relawan.index') }}"
                    class="btn btn-soft"
                >
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    {{ $isEdit ? 'Update Relawan' : 'Simpan Relawan' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Script -->
    <script>
        function addSkill() {
            const wrapper = document.getElementById('skill-wrapper');

            const div = document.createElement('div');
            div.className = 'flex gap-2';

            div.innerHTML = `
                <input type="text" name="skill[]" class="input w-full bg-base-200" required>
                <button type="button" onclick="removeSkill(this)" class="btn btn-error text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path fill="currentColor" d="m5.69 20.314-.749.049zm12.62 0 .749.049zM2.75 5a.75.75 0 0 0 0 1.5zm18.5 1.5a.75.75 0 0 0 0-1.5zM10.5 10.75a.75.75 0 0 0-1.5 0zM9 16.25a.75.75 0 0 0 1.5 0zm6-5.5a.75.75 0 0 0-1.5 0zm-1.5 5.5a.75.75 0 0 0 1.5 0zm1.648-10.313a.75.75 0 1 0 1.452-.374zM4.002 5.798l.94 14.565 1.496-.097-.94-14.564zM6.688 22h10.624v-1.5H6.688zm12.37-1.637.94-14.565-1.496-.096-.94 14.564 1.497.097ZM19.25 5H4.75v1.5h14.5zM2.75 6.5h2V5h-2zm16.5 0h2V5h-2zM17.312 22a1.75 1.75 0 0 0 1.747-1.637l-1.497-.097a.25.25 0 0 1-.25.234zm-12.37-1.637A1.75 1.75 0 0 0 6.687 22v-1.5a.25.25 0 0 1-.25-.234l-1.497.097ZM9 10.75v5.5h1.5v-5.5zm4.5 0v5.5H15v-5.5zM12 3.5a3.25 3.25 0 0 1 3.148 2.437l1.452-.374A4.75 4.75 0 0 0 12 2zM8.852 5.937A3.25 3.25 0 0 1 12 3.5V2a4.75 4.75 0 0 0-4.6 3.563z"></path></svg>
                </button>
            `;

            wrapper.appendChild(div);
        }

        function removeSkill(button) {
            const wrapper = document.getElementById('skill-wrapper');
            if (wrapper.children.length > 1) {
                button.parentElement.remove();
            }
        }
    </script>
</x-layouts.admin>
