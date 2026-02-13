<?php

namespace Database\Seeders;

use App\Models\Relawan;
use Illuminate\Database\Seeder;

class RelawanSeeder extends Seeder
{
    public function run(): void
    {
        $kabupatenKota = [
            ['name' => 'Medan', 'kecamatan' => ['Medan Baru', 'Medan Timur', 'Medan Barat', 'Medan Selatan', 'Medan Utara', 'Medan Denai']],
            ['name' => 'Binjai', 'kecamatan' => ['Binjai Utara', 'Binjai Selatan', 'Binjai Timur']],
            ['name' => 'Pematangsiantar', 'kecamatan' => ['Siantar Barat', 'Siantar Timur', 'Siantar Utara']],
            ['name' => 'Tebing Tinggi', 'kecamatan' => ['Tebing Tinggi Kota', 'Rambutan', 'Bajenis']],
            ['name' => 'Sibolga', 'kecamatan' => ['Sibolga Utara', 'Sibolga Selatan', 'Sibolga Kota']],
            ['name' => 'Tanjung Balai', 'kecamatan' => ['Tanjung Balai Selatan', 'Tanjung Balai Utara', 'Datuk Bandar']],
            ['name' => 'Padang Sidempuan', 'kecamatan' => ['Padang Sidempuan Utara', 'Padang Sidempuan Selatan', 'Batunadua']],
            ['name' => 'Gunungsitoli', 'kecamatan' => ['Gunungsitoli Utara', 'Gunungsitoli Selatan', 'Gunungsitoli Idanoi']],
            ['name' => 'Deli Serdang', 'kecamatan' => ['Lubuk Pakam', 'Percut Sei Tuan', 'Tanjung Morawa']],
            ['name' => 'Langkat', 'kecamatan' => ['Stabat', 'Tanjung Pura', 'Brandan Barat']],
            ['name' => 'Karo', 'kecamatan' => ['Kabanjahe', 'Berastagi', 'Tigapanah']],
            ['name' => 'Simalungun', 'kecamatan' => ['Siantar', 'Raya', 'Dolok Panribuan']],
            ['name' => 'Asahan', 'kecamatan' => ['Kisaran Barat', 'Kisaran Timur', 'Air Batu']],
            ['name' => 'Serdang Bedagai', 'kecamatan' => ['Sei Rampah', 'Perbaungan', 'Tanjung Beringin']],
            ['name' => 'Batu Bara', 'kecamatan' => ['Lima Puluh', 'Talawi', 'Tanjung Tiram']],
            ['name' => 'Labuhanbatu', 'kecamatan' => ['Rantauprapat', 'Bilah Hulu', 'Panai Hilir']],
            ['name' => 'Labuhanbatu Utara', 'kecamatan' => ['Aek Kanopan', 'Kualuh Hulu', 'Kualuh Selatan']],
            ['name' => 'Labuhanbatu Selatan', 'kecamatan' => ['Kotapinang', 'Torgamba', 'Sungai Kanan']],
            ['name' => 'Tapanuli Utara', 'kecamatan' => ['Tarutung', 'Sipoholon', 'Pahae Jae']],
            ['name' => 'Tapanuli Tengah', 'kecamatan' => ['Pandan', 'Barus', 'Sirandorung']],
            ['name' => 'Tapanuli Selatan', 'kecamatan' => ['Sipirok', 'Batang Toru', 'Angkola Timur']],
            ['name' => 'Mandailing Natal', 'kecamatan' => ['Panyabungan', 'Kotanopan', 'Natal']],
            ['name' => 'Padang Lawas', 'kecamatan' => ['Sibuhuan', 'Sosa', 'Barumun']],
            ['name' => 'Padang Lawas Utara', 'kecamatan' => ['Gunung Tua', 'Padang Bolak', 'Halongonan']],
            ['name' => 'Humbang Hasundutan', 'kecamatan' => ['Dolok Sanggul', 'Lintong Nihuta', 'Baktiraja']],
            ['name' => 'Samosir', 'kecamatan' => ['Pangururan', 'Simanindo', 'Harian']],
            ['name' => 'Toba', 'kecamatan' => ['Balige', 'Laguboti', 'Porsea']],
            ['name' => 'Dairi', 'kecamatan' => ['Sidikalang', 'Parbuluan', 'Berampu']],
            ['name' => 'Pakpak Bharat', 'kecamatan' => ['Salak', 'Sitellu Tali Urang Jehe', 'Kerajaan']],
            ['name' => 'Nias', 'kecamatan' => ['Gido', 'Idano Gawo', 'Hiliduho']],
            ['name' => 'Nias Selatan', 'kecamatan' => ['Teluk Dalam', 'Lahusa', 'Gomo']],
            ['name' => 'Nias Barat', 'kecamatan' => ['Lahomi', 'Sirombu', 'Mandrehe']],
            ['name' => 'Nias Utara', 'kecamatan' => ['Lotu', 'Lahewa', 'Namohalu Esiwa']],
        ];

        $firstNames = ['Agus', 'Dewi', 'Eko', 'Fitri', 'Hendra', 'Indah', 'Joko', 'Kartika', 'Lukman', 'Maya', 'Nanda', 'Putri', 'Rizky', 'Sari', 'Teguh', 'Wulan'];
        $lastNames = ['Prasetyo', 'Lestari', 'Santoso', 'Hidayat', 'Permata', 'Gunawan', 'Siregar', 'Hasibuan', 'Nasution', 'Lubis', 'Saragih', 'Panjaitan'];
        $streets = ['Merdeka', 'Gatot Subroto', 'Ahmad Yani', 'Sisingamangaraja', 'Veteran', 'Sudirman', 'Diponegoro', 'Imam Bonjol', 'Kartini', 'Cendana', 'Pelajar', 'Karya'];
        $statuses = ['available', 'on_duty', 'unavailable'];
        $skillSets = [
            ['P3K', 'Evakuasi', 'Komunikasi'],
            ['Medis', 'P3K', 'Trauma Healing'],
            ['Logistik', 'Distribusi', 'Dapur Umum'],
            ['SAR', 'Penyelamatan', 'Navigasi'],
            ['Dokumentasi', 'Media Sosial', 'Koordinasi'],
            ['Perbaikan Infrastruktur', 'Listrik', 'Mekanik'],
            ['Psikologi', 'Pendamping Anak', 'Edukasi'],
            ['Driver', 'Navigasi', 'Logistik'],
            ['Administrasi', 'Data Entry', 'Komunikasi'],
            ['Penyelamatan Air', 'Perahu Karet', 'Evakuasi'],
        ];

        $totalRelawan = 110;
        $relawanData = [];

        for ($i = 0; $i < $totalRelawan; $i++) {
            $region = $kabupatenKota[$i % count($kabupatenKota)];
            $kecamatanList = $region['kecamatan'];

            $firstName = $firstNames[$i % count($firstNames)];
            $lastName = $lastNames[intdiv($i, count($firstNames)) % count($lastNames)];
            $street = $streets[$i % count($streets)];

            $relawanData[] = [
                'nama' => $firstName . ' ' . $lastName,
                'no_hp' => '08' . str_pad((string) (1200000000 + $i), 10, '0', STR_PAD_LEFT),
                'email' => strtolower($firstName) . '.' . strtolower($lastName) . ($i + 1) . '@example.com',
                'alamat' => 'Jl. ' . $street . ' No. ' . (10 + ($i % 90)) . ', RT ' . str_pad((string) (1 + ($i % 9)), 2, '0', STR_PAD_LEFT) . '/RW ' . str_pad((string) (1 + (($i + 3) % 9)), 2, '0', STR_PAD_LEFT),
                'kecamatan' => $kecamatanList[$i % count($kecamatanList)],
                'kabupaten_kota' => $region['name'],
                'status_ketersediaan' => $statuses[$i % count($statuses)],
                'skill' => $skillSets[$i % count($skillSets)],
                'tahun_bergabung' => 2015 + ($i % 11),
            ];
        }

        foreach ($relawanData as $data) {
            Relawan::create($data);
        }
    }
}
