<?php

namespace Database\Seeders;

use App\Models\Relawan;
use Illuminate\Database\Seeder;

class RelawanSeeder extends Seeder
{
    public function run(): void
    {
        $relawan = [
            [
                'nama' => 'Agus Prasetyo',
                'no_hp' => '081234567890',
                'email' => 'agus.relawan@example.com',
                'alamat' => 'Jl. Merdeka No. 10, RT 01/RW 02',
                'kecamatan' => 'Medan Baru',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['P3K', 'Evakuasi', 'Komunikasi', 'Penyelamatan Air'],
                'tahun_bergabung' => 2019,
            ],
            [
                'nama' => 'Dewi Lestari',
                'no_hp' => '082345678901',
                'email' => 'dewi.relawan@example.com',
                'alamat' => 'Jl. Gatot Subroto No. 25, RT 03/RW 01',
                'kecamatan' => 'Medan Timur',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['Medis', 'P3K', 'Psikologi', 'Trauma Healing'],
                'tahun_bergabung' => 2020,
            ],
            [
                'nama' => 'Eko Prasetyo',
                'no_hp' => '083456789012',
                'email' => 'eko.relawan@example.com',
                'alamat' => 'Jl. Sisingamangaraja No. 50, RT 02/RW 03',
                'kecamatan' => 'Medan Barat',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['Logistik', 'Distribusi', 'Dapur Umum'],
                'tahun_bergabung' => 2021,
            ],
            [
                'nama' => 'Fitri Handayani',
                'no_hp' => '084567890123',
                'email' => 'fitri.relawan@example.com',
                'alamat' => 'Jl. Ahmad Yani No. 15, RT 04/RW 02',
                'kecamatan' => 'Medan Selatan',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['Komunikasi', 'Dokumentasi', 'Media Sosial'],
                'tahun_bergabung' => 2022,
            ],
            [
                'nama' => 'Hendra Gunawan',
                'no_hp' => '085678901234',
                'email' => 'hendra.relawan@example.com',
                'alamat' => 'Jl. Veteran No. 30, RT 01/RW 01',
                'kecamatan' => 'Medan Utara',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['SAR', 'Penyelamatan', 'Climbing', 'Navigasi'],
                'tahun_bergabung' => 2018,
            ],
            [
                'nama' => 'Indah Permata',
                'no_hp' => '086789012345',
                'email' => 'indah.relawan@example.com',
                'alamat' => 'Jl. Suprapto No. 45, RT 02/RW 04',
                'kecamatan' => 'Medan Denai',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'on_duty',
                'skill' => ['Perawat', 'P3K', 'Medis Darurat'],
                'tahun_bergabung' => 2020,
            ],
            [
                'nama' => 'Joko Widodo',
                'no_hp' => '087890123456',
                'email' => 'joko.relawan@example.com',
                'alamat' => 'Jl. Sudirman No. 20, RT 03/RW 02',
                'kecamatan' => 'Medan Kota',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['Mekanik', 'Listrik', 'Perbaikan Infrastruktur'],
                'tahun_bergabung' => 2019,
            ],
            [
                'nama' => 'Kartika Sari',
                'no_hp' => '088901234567',
                'email' => 'kartika.relawan@example.com',
                'alamat' => 'Jl. Diponegoro No. 12, RT 01/RW 03',
                'kecamatan' => 'Medan Polonia',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['Pendamping Anak', 'Edukasi', 'Trauma Healing'],
                'tahun_bergabung' => 2021,
            ],
            [
                'nama' => 'Lukman Hakim',
                'no_hp' => '089012345678',
                'email' => 'lukman.relawan@example.com',
                'alamat' => 'Jl. Imam Bonjol No. 8, RT 04/RW 01',
                'kecamatan' => 'Medan Tembung',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'unavailable',
                'skill' => ['Driver', 'Logistik', 'Navigasi'],
                'tahun_bergabung' => 2020,
            ],
            [
                'nama' => 'Maya Sari',
                'no_hp' => '081123456789',
                'email' => 'maya.relawan@example.com',
                'alamat' => 'Jl. Cirebon No. 35, RT 02/RW 02',
                'kecamatan' => 'Medan Area',
                'kabupaten_kota' => 'Medan',
                'status_ketersediaan' => 'available',
                'skill' => ['Administrasi', 'Data Entry', 'Koordinasi'],
                'tahun_bergabung' => 2022,
            ],
        ];

        foreach ($relawan as $data) {
            Relawan::create($data);
        }
    }
}