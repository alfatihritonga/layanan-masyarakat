<?php

namespace Database\Seeders;

use App\Models\DisasterType;
use App\Models\Report;
use App\Models\ReportComment;
use App\Models\ReportHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get()->values();
        $admin = User::where('role', 'admin')->first();
        $disasterTypes = DisasterType::all()->values();

        if ($users->isEmpty() || !$admin || $disasterTypes->isEmpty()) {
            return;
        }

        $regions = [
            ['name' => 'Medan', 'kecamatan' => ['Medan Baru', 'Medan Timur', 'Medan Barat', 'Medan Selayang']],
            ['name' => 'Binjai', 'kecamatan' => ['Binjai Utara', 'Binjai Selatan', 'Binjai Timur']],
            ['name' => 'Deli Serdang', 'kecamatan' => ['Lubuk Pakam', 'Percut Sei Tuan', 'Tanjung Morawa']],
            ['name' => 'Langkat', 'kecamatan' => ['Stabat', 'Tanjung Pura', 'Besitang']],
            ['name' => 'Karo', 'kecamatan' => ['Kabanjahe', 'Berastagi', 'Tigapanah']],
            ['name' => 'Simalungun', 'kecamatan' => ['Siantar', 'Raya', 'Dolok Panribuan']],
            ['name' => 'Asahan', 'kecamatan' => ['Kisaran Barat', 'Kisaran Timur', 'Air Batu']],
            ['name' => 'Serdang Bedagai', 'kecamatan' => ['Sei Rampah', 'Perbaungan', 'Pantai Cermin']],
            ['name' => 'Batu Bara', 'kecamatan' => ['Lima Puluh', 'Talawi', 'Tanjung Tiram']],
            ['name' => 'Tapanuli Utara', 'kecamatan' => ['Tarutung', 'Sipoholon', 'Pahae Jae']],
            ['name' => 'Tapanuli Tengah', 'kecamatan' => ['Pandan', 'Barus', 'Sirandorung']],
            ['name' => 'Tapanuli Selatan', 'kecamatan' => ['Sipirok', 'Batang Toru', 'Angkola Timur']],
            ['name' => 'Mandailing Natal', 'kecamatan' => ['Panyabungan', 'Kotanopan', 'Natal']],
            ['name' => 'Toba', 'kecamatan' => ['Balige', 'Laguboti', 'Porsea']],
            ['name' => 'Nias', 'kecamatan' => ['Gido', 'Idano Gawo', 'Hiliduho']],
            ['name' => 'Nias Selatan', 'kecamatan' => ['Teluk Dalam', 'Lahusa', 'Gomo']],
        ];

        $streets = ['Merdeka', 'Gatot Subroto', 'Ahmad Yani', 'Sisingamangaraja', 'Veteran', 'Sudirman', 'Diponegoro', 'Imam Bonjol', 'Kartini', 'Cendana'];
        $urgencyLevels = ['low', 'medium', 'high', 'critical'];
        $statuses = ['pending', 'verified', 'in_progress', 'resolved', 'rejected'];

        $descriptionByType = [
            'Banjir' => 'Banjir menggenangi pemukiman warga dan akses jalan utama terendam.',
            'Gempa Bumi' => 'Getaran gempa dirasakan warga, terjadi kerusakan ringan di beberapa rumah.',
            'Kebakaran' => 'Kebakaran terjadi di area pemukiman padat dan membutuhkan bantuan evakuasi.',
            'Tanah Longsor' => 'Material longsor menutup akses jalan dan mengancam rumah di lereng.',
            'Tsunami' => 'Gelombang tinggi menggenangi kawasan pesisir, warga perlu dievakuasi.',
            'Gunung Meletus' => 'Letusan mengeluarkan abu vulkanik, jarak pandang menurun drastis.',
            'Angin Puting Beliung' => 'Angin kencang merusak atap rumah dan menumbangkan pohon besar.',
            'Kekeringan' => 'Pasokan air menurun, warga kesulitan mendapatkan air bersih.',
            'Bencana Industri' => 'Terjadi kebocoran bahan berbahaya di kawasan industri.',
            'Wabah Penyakit' => 'Terjadi peningkatan kasus penyakit menular di masyarakat.',
        ];

        $commentPublic = [
            'Mohon segera ada bantuan di lokasi.',
            'Warga sudah berkumpul di titik aman, butuh logistik.',
            'Situasi memburuk dalam satu jam terakhir.',
            'Mohon perhatian, akses jalan utama terputus.',
        ];

        $commentInternal = [
            'Koordinasi dengan BPBD setempat untuk penanganan.',
            'Siapkan relawan logistik dan medis.',
            'Pantau perkembangan dan update status berkala.',
        ];

        $reportsPerYear = [
            2020 => 12,
            2021 => 14,
            2022 => 11,
            2023 => 13,
            2024 => 15,
            2025 => 16,
            2026 => 12,
        ];

        $reportIndex = 0;

        foreach ($reportsPerYear as $year => $count) {
            for ($i = 0; $i < $count; $i++) {
                $reportIndex++;

                $user = $users[$reportIndex % $users->count()];
                $disasterType = $disasterTypes[$reportIndex % $disasterTypes->count()];
                $region = $regions[$reportIndex % count($regions)];
                $kecamatan = $region['kecamatan'][$reportIndex % count($region['kecamatan'])];
                $street = $streets[$reportIndex % count($streets)];

                $incidentDate = Carbon::create($year, ($i % 12) + 1, (($i * 3) % 27) + 1, 8 + ($i % 10), 15);
                if ($year === (int) now()->year && $incidentDate->greaterThan(now())) {
                    $incidentDate = now()->subDays($i + 1);
                }

                $urgency = $urgencyLevels[$reportIndex % count($urgencyLevels)];
                $status = $statuses[$reportIndex % count($statuses)];

                $descriptionBase = $descriptionByType[$disasterType->name] ?? 'Terjadi kejadian bencana yang membutuhkan penanganan segera.';
                $description = $descriptionBase . ' Lokasi kejadian di Kecamatan ' . $kecamatan . ', ' . $region['name'] . '.';

                $victimCount = $urgency === 'low' ? null : 1 + ($reportIndex % 40);
                $damageDescription = $urgency === 'low'
                    ? null
                    : 'Terdapat kerusakan pada fasilitas warga dan gangguan akses di sekitar lokasi.';

                $reportData = [
                    'user_id' => $user->id,
                    'disaster_type_id' => $disasterType->id,
                    'description' => $description,
                    'location_address' => 'Jl. ' . $street . ' No. ' . (10 + ($reportIndex % 90)) . ', Kecamatan ' . $kecamatan . ', ' . $region['name'] . ', Sumatera Utara',
                    'incident_date' => $incidentDate,
                    'urgency_level' => $urgency,
                    'status' => $status,
                    'victim_count' => $victimCount,
                    'damage_description' => $damageDescription,
                    'contact_phone' => '08' . str_pad((string) (1300000000 + $reportIndex), 10, '0', STR_PAD_LEFT),
                ];

                if ($status !== 'pending') {
                    $reportData['verified_at'] = $incidentDate->copy()->addHours(6);
                    $reportData['verified_by'] = $admin->id;
                    $reportData['admin_notes'] = 'Laporan telah diverifikasi dan ditindaklanjuti.';
                }

                if ($status === 'in_progress') {
                    $reportData['admin_notes'] = 'Tim sedang melakukan penanganan di lapangan.';
                }

                if ($status === 'resolved') {
                    $reportData['resolved_at'] = $incidentDate->copy()->addDays(2);
                    $reportData['admin_notes'] = 'Penanganan selesai dan situasi terkendali.';
                }

                if ($status === 'rejected') {
                    $reportData['rejection_reason'] = 'Laporan tidak memenuhi kriteria prioritas penanganan.';
                }

                $report = Report::create($reportData);

                if ($status === 'verified') {
                    $this->createHistory($report->id, $admin->id, 'pending', 'verified', 'Laporan diverifikasi oleh admin.');
                }

                if ($status === 'in_progress') {
                    $this->createHistory($report->id, $admin->id, 'pending', 'verified', 'Laporan diverifikasi.');
                    $this->createHistory($report->id, $admin->id, 'verified', 'in_progress', 'Tim ditugaskan ke lokasi.');
                }

                if ($status === 'resolved') {
                    $this->createHistory($report->id, $admin->id, 'pending', 'verified', 'Laporan diverifikasi.');
                    $this->createHistory($report->id, $admin->id, 'verified', 'in_progress', 'Tim berada di lokasi.');
                    $this->createHistory($report->id, $admin->id, 'in_progress', 'resolved', 'Penanganan selesai.');
                }

                if ($status === 'rejected') {
                    $this->createHistory($report->id, $admin->id, 'pending', 'rejected', 'Laporan ditolak setelah verifikasi.');
                }

                ReportComment::create([
                    'report_id' => $report->id,
                    'user_id' => $user->id,
                    'comment' => $commentPublic[$reportIndex % count($commentPublic)],
                    'is_internal' => false,
                ]);

                if ($status !== 'pending') {
                    ReportComment::create([
                        'report_id' => $report->id,
                        'user_id' => $admin->id,
                        'comment' => $commentInternal[$reportIndex % count($commentInternal)],
                        'is_internal' => true,
                    ]);
                }
            }
        }
    }

    private function createHistory(int $reportId, int $adminId, string $oldValue, string $newValue, string $notes): void
    {
        ReportHistory::create([
            'report_id' => $reportId,
            'changed_by' => $adminId,
            'field_name' => 'status',
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'notes' => $notes,
        ]);
    }
}
