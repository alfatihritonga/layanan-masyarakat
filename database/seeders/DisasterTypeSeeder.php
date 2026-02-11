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
                'icon' => 'flood',
                'color' => '#3B82F6', // blue
            ],
            [
                'name' => 'Gempa Bumi',
                'description' => 'Getaran atau guncangan yang terjadi di permukaan bumi',
                'icon' => 'earthquake',
                'color' => '#EF4444', // red
            ],
            [
                'name' => 'Kebakaran',
                'description' => 'Bencana yang disebabkan oleh api yang tidak terkendali',
                'icon' => 'fire',
                'color' => '#F59E0B', // orange
            ],
            [
                'name' => 'Tanah Longsor',
                'description' => 'Perpindahan material pembentuk lereng berupa batuan, tanah, atau material campuran',
                'icon' => 'landslide',
                'color' => '#92400E', // brown
            ],
            [
                'name' => 'Tsunami',
                'description' => 'Gelombang laut yang sangat besar akibat gempa atau letusan gunung berapi',
                'icon' => 'tsunami',
                'color' => '#06B6D4', // cyan
            ],
            [
                'name' => 'Gunung Meletus',
                'description' => 'Letusan gunung berapi yang mengeluarkan material vulkanik',
                'icon' => 'volcano',
                'color' => '#DC2626', // dark red
            ],
            [
                'name' => 'Angin Puting Beliung',
                'description' => 'Angin kencang yang berputar dengan kecepatan tinggi',
                'icon' => 'tornado',
                'color' => '#6B7280', // gray
            ],
            [
                'name' => 'Kekeringan',
                'description' => 'Kekurangan pasokan air dalam waktu yang cukup lama',
                'icon' => 'drought',
                'color' => '#D97706', // amber
            ],
            [
                'name' => 'Bencana Industri',
                'description' => 'Kecelakaan atau kebocoran bahan berbahaya di area industri',
                'icon' => 'industry',
                'color' => '#7C3AED', // purple
            ],
            [
                'name' => 'Wabah Penyakit',
                'description' => 'Penyebaran penyakit menular dalam skala luas',
                'icon' => 'epidemic',
                'color' => '#10B981', // green
            ],
        ];

        foreach ($disasterTypes as $type) {
            DisasterType::create($type);
        }
    }
}