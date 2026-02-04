<x-layouts.admin>
    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body space-y-3">
                <h2 class="card-title">Tambah Relawan</h2>

                <form method="POST" action="{{ route('admin.relawan.store') }}" class="space-y-3">
                    @csrf

                    <input name="nama" class="input input-bordered w-full" placeholder="Nama" required>
                    <input name="no_hp" class="input input-bordered w-full" placeholder="No HP" required>
                    <input name="email" class="input input-bordered w-full" placeholder="Email" required>

                    <textarea name="alamat" class="textarea textarea-bordered w-full" placeholder="Alamat" required></textarea>

                    <div class="grid grid-cols-2 gap-2">
                        <input name="kecamatan" class="input input-bordered" placeholder="Kecamatan" required>
                        <input name="kabupaten_kota" class="input input-bordered" placeholder="Kab/Kota" required>
                    </div>

                    <input name="tahun_bergabung" type="number" class="input input-bordered w-full"
                           placeholder="Tahun Bergabung" required>

                    <select name="status_ketersediaan" class="select select-bordered w-full">
                        <option value="available">Available</option>
                        <option value="on_duty">On Duty</option>
                        <option value="unavailable">Unavailable</option>
                    </select>

                    {{-- skill --}}
                    <input name="skill[]" class="input input-bordered w-full" placeholder="Skill (mis: Medis)">
                    <input name="skill[]" class="input input-bordered w-full" placeholder="Skill lain (opsional)">

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.relawan.index') }}" class="btn btn-ghost">Batal</a>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
