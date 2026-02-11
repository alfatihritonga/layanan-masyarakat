<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Report;
use App\Models\Relawan;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        // Report yang in_progress
        $report = Report::where('status', 'in_progress')->first();
        
        if ($report) {
            // Assign 2 relawan ke report in_progress
            $relawan1 = Relawan::where('status_ketersediaan', 'on_duty')->first();
            $relawan2 = Relawan::where('status_ketersediaan', 'available')->first();

            if ($relawan1) {
                Assignment::create([
                    'report_id' => $report->id,
                    'relawan_id' => $relawan1->id,
                    'assigned_by' => $admin->id,
                    'status' => 'on_site',
                    'notes' => 'Tolong bawa peralatan evakuasi dan komunikasi dengan warga setempat',
                    'assigned_at' => now()->subHours(18),
                    'started_at' => now()->subHours(16),
                ]);
            }

            if ($relawan2) {
                Assignment::create([
                    'report_id' => $report->id,
                    'relawan_id' => $relawan2->id,
                    'assigned_by' => $admin->id,
                    'status' => 'on_the_way',
                    'notes' => 'Bantu evakuasi warga yang terancam longsor susulan',
                    'assigned_at' => now()->subHours(10),
                    'started_at' => now()->subHours(9),
                ]);

                // Update status relawan
                $relawan2->update(['status_ketersediaan' => 'on_duty']);
            }
        }

        // Report yang resolved
        $resolvedReport = Report::where('status', 'resolved')->first();
        
        if ($resolvedReport) {
            $relawan3 = Relawan::where('nama', 'Dewi Lestari')->first();
            
            if ($relawan3) {
                Assignment::create([
                    'report_id' => $resolvedReport->id,
                    'relawan_id' => $relawan3->id,
                    'assigned_by' => $admin->id,
                    'status' => 'completed',
                    'notes' => 'Distribusi pompa air dan bantuan logistik',
                    'assigned_at' => now()->subDays(2),
                    'started_at' => now()->subDays(2)->addHours(1),
                    'completed_at' => now()->subHours(3),
                    'completion_notes' => 'Pompa air sudah didistribusikan, genangan sudah berkurang. Logistik untuk 25 KK sudah diserahkan.',
                ]);
            }
        }
    }
}