<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\ReportComment;
use App\Models\ReportHistory;
use App\Models\User;
use App\Models\DisasterType;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $admin = User::where('role', 'admin')->first();
        $disasterTypes = DisasterType::all();

        // Report 1 - Pending
        $report1 = Report::create([
            'user_id' => $users[0]->id,
            'disaster_type_id' => $disasterTypes->where('name', 'Banjir')->first()->id,
            'description' => 'Banjir setinggi 1 meter merendam perumahan di Jl. Setia Budi. Air mulai naik sejak pagi hari karena hujan deras semalam. Banyak rumah warga yang terendam dan kendaraan tidak bisa melintas.',
            'location_address' => 'Jl. Setia Budi Raya No. 45, Kelurahan Tanjung Sari, Kecamatan Medan Selayang, Kota Medan, Sumatera Utara',
            'incident_date' => now()->subHours(3),
            'urgency_level' => 'high',
            'status' => 'pending',
            'victim_count' => 15,
            'damage_description' => 'Sekitar 20 rumah terendam, 5 motor mogok, akses jalan tertutup air',
            'contact_phone' => '081234567890',
        ]);

        // Report 2 - Verified
        $report2 = Report::create([
            'user_id' => $users[1]->id,
            'disaster_type_id' => $disasterTypes->where('name', 'Kebakaran')->first()->id,
            'description' => 'Kebakaran rumah di pemukiman padat penduduk. Api diduga berasal dari korsleting listrik. Sudah ada tim damkar yang datang tetapi memerlukan bantuan evakuasi warga.',
            'location_address' => 'Jl. Kapten Muslim Gang 5 No. 12, Kelurahan Sei Rengas, Kecamatan Medan Area, Kota Medan',
            'incident_date' => now()->subHours(5),
            'urgency_level' => 'critical',
            'status' => 'verified',
            'victim_count' => 8,
            'damage_description' => '2 rumah terbakar habis, 1 rumah rusak sebagian, 8 KK mengungsi',
            'contact_phone' => '082345678901',
            'verified_at' => now()->subHours(4),
            'verified_by' => $admin->id,
        ]);

        ReportHistory::create([
            'report_id' => $report2->id,
            'changed_by' => $admin->id,
            'field_name' => 'status',
            'old_value' => 'pending',
            'new_value' => 'verified',
            'notes' => 'Laporan telah diverifikasi dan akan segera ditindaklanjuti',
        ]);

        // Report 3 - In Progress
        $report3 = Report::create([
            'user_id' => $users[2]->id,
            'disaster_type_id' => $disasterTypes->where('name', 'Tanah Longsor')->first()->id,
            'description' => 'Tanah longsor menutupi akses jalan utama ke desa. Material longsor cukup besar dan mengancam rumah warga di bawahnya. Perlu penanganan segera.',
            'location_address' => 'Jalan Raya Pancur Batu KM 15, Desa Pancur Batu, Kecamatan Pancur Batu, Kabupaten Deli Serdang',
            'incident_date' => now()->subDays(1),
            'urgency_level' => 'high',
            'status' => 'in_progress',
            'victim_count' => 0,
            'damage_description' => 'Akses jalan terputus sepanjang 50 meter, 3 rumah terancam',
            'contact_phone' => '083456789012',
            'verified_at' => now()->subHours(20),
            'verified_by' => $admin->id,
            'admin_notes' => 'Tim sudah ditugaskan untuk evakuasi dan pembersihan material longsor',
        ]);

        ReportHistory::create([
            'report_id' => $report3->id,
            'changed_by' => $admin->id,
            'field_name' => 'status',
            'old_value' => 'pending',
            'new_value' => 'verified',
            'notes' => 'Laporan diverifikasi',
        ]);

        ReportHistory::create([
            'report_id' => $report3->id,
            'changed_by' => $admin->id,
            'field_name' => 'status',
            'old_value' => 'verified',
            'new_value' => 'in_progress',
            'notes' => 'Relawan telah ditugaskan ke lokasi',
        ]);

        // Report 4 - Resolved
        $report4 = Report::create([
            'user_id' => $users[0]->id,
            'disaster_type_id' => $disasterTypes->where('name', 'Banjir')->first()->id,
            'description' => 'Banjir di perumahan Griya Martubung sudah mulai surut tetapi masih ada genangan di beberapa titik. Bantuan pompa air sangat diperlukan.',
            'location_address' => 'Perumahan Griya Martubung Blok C, Kelurahan Martubung, Kecamatan Medan Labuhan',
            'incident_date' => now()->subDays(3),
            'urgency_level' => 'medium',
            'status' => 'resolved',
            'victim_count' => 25,
            'damage_description' => '15 rumah terendam, kerugian material sekitar 50 juta',
            'contact_phone' => '084567890123',
            'verified_at' => now()->subDays(2),
            'verified_by' => $admin->id,
            'resolved_at' => now()->subHours(2),
            'admin_notes' => 'Air sudah surut, warga sudah kembali ke rumah, bantuan logistik sudah disalurkan',
        ]);

        ReportComment::create([
            'report_id' => $report4->id,
            'user_id' => $users[0]->id,
            'comment' => 'Terima kasih atas bantuannya, air sudah surut dan kondisi sudah membaik',
            'is_internal' => false,
        ]);

        // Report 5 - Rejected
        $report5 = Report::create([
            'user_id' => $users[1]->id,
            'disaster_type_id' => $disasterTypes->where('name', 'Gempa Bumi')->first()->id,
            'description' => 'Gempa bumi kecil terasa di area Medan',
            'location_address' => 'Kota Medan',
            'incident_date' => now()->subDays(5),
            'urgency_level' => 'low',
            'status' => 'rejected',
            'contact_phone' => '085678901234',
            'verified_at' => now()->subDays(4),
            'verified_by' => $admin->id,
            'rejection_reason' => 'Gempa bumi skala rendah (< 3 SR) tidak memerlukan penanganan khusus. Tidak ada kerusakan atau korban yang dilaporkan.',
        ]);

        ReportHistory::create([
            'report_id' => $report5->id,
            'changed_by' => $admin->id,
            'field_name' => 'status',
            'old_value' => 'pending',
            'new_value' => 'rejected',
            'notes' => 'Laporan ditolak karena tidak memerlukan tindak lanjut',
        ]);

        // Report 6 - Pending (recent)
        $report6 = Report::create([
            'user_id' => $users[2]->id,
            'disaster_type_id' => $disasterTypes->where('name', 'Angin Puting Beliung')->first()->id,
            'description' => 'Angin puting beliung merusak puluhan rumah warga. Banyak atap rumah yang terbang dan pohon tumbang. Listrik padam di beberapa area.',
            'location_address' => 'Desa Bandar Khalifah, Kecamatan Percut Sei Tuan, Kabupaten Deli Serdang',
            'incident_date' => now()->subMinutes(30),
            'urgency_level' => 'critical',
            'status' => 'pending',
            'victim_count' => 10,
            'damage_description' => '30 rumah rusak berat, 15 rumah rusak ringan, 20 pohon tumbang, 2 orang luka-luka',
            'contact_phone' => '086789012345',
        ]);

        // Comments
        ReportComment::create([
            'report_id' => $report2->id,
            'user_id' => $admin->id,
            'comment' => 'Laporan sudah diverifikasi. Tim akan segera ditugaskan.',
            'is_internal' => false,
        ]);

        ReportComment::create([
            'report_id' => $report3->id,
            'user_id' => $admin->id,
            'comment' => 'Koordinasi dengan BPBD setempat untuk alat berat',
            'is_internal' => true,
        ]);
    }
}