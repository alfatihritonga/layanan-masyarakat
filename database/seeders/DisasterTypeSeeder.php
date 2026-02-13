<?php

namespace Database\Seeders;

use App\Models\DisasterType;
use Illuminate\Database\Seeder;

class DisasterTypeSeeder extends Seeder
{
    public function run(): void
    {
        $disasterTypes = [
            [
                'name' => 'Banjir',
                'description' => 'Bencana akibat luapan air yang menutupi daratan',
                'icon_svg' => null,
                'color' => '#3B82F6', // blue
            ],
            [
                'name' => 'Gempa Bumi',
                'description' => 'Getaran atau guncangan yang terjadi di permukaan bumi',
                'icon_svg' => null,
                'color' => '#EF4444', // red
            ],
            [
                'name' => 'Kebakaran',
                'description' => 'Bencana yang disebabkan oleh api yang tidak terkendali',
                'icon_svg' => null,
                'color' => '#F59E0B', // orange
            ],
            [
                'name' => 'Tanah Longsor',
                'description' => 'Perpindahan material pembentuk lereng berupa batuan, tanah, atau material campuran',
                'icon_svg' => null,
                'color' => '#92400E', // brown
            ],
            [
                'name' => 'Tsunami',
                'description' => 'Gelombang laut yang sangat besar akibat gempa atau letusan gunung berapi',
                'icon_svg' => null,
                'color' => '#06B6D4', // cyan
            ],
            [
                'name' => 'Gunung Meletus',
                'description' => 'Letusan gunung berapi yang mengeluarkan material vulkanik',
                'icon_svg' => null,
                'color' => '#DC2626', // dark red
            ],
            [
                'name' => 'Angin Puting Beliung',
                'description' => 'Angin kencang yang berputar dengan kecepatan tinggi',
                'icon_svg' => null,
                'color' => '#6B7280', // gray
            ],
            [
                'name' => 'Kekeringan',
                'description' => 'Kekurangan pasokan air dalam waktu yang cukup lama',
                'icon_svg' => null,
                'color' => '#D97706', // amber
            ],
            [
                'name' => 'Bencana Industri',
                'description' => 'Kecelakaan atau kebocoran bahan berbahaya di area industri',
                'icon_svg' => null,
                'color' => '#7C3AED', // purple
            ],
            [
                'name' => 'Wabah Penyakit',
                'description' => 'Penyebaran penyakit menular dalam skala luas',
                'icon_svg' => null,
                'color' => '#10B981', // green
            ],
        ];

        foreach ($disasterTypes as $type) {
            DisasterType::create($type);
        }
    }
}