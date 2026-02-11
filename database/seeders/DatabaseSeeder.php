<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RelawanSeeder::class,
            DisasterTypeSeeder::class,
            ReportSeeder::class,
            AssignmentSeeder::class,
        ]);
    }
}