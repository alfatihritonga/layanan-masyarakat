<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin utama
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        // Admin kedua
        User::create([
            'name' => 'Administrator 2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        // User biasa untuk testing (pelapor)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmad Hidayat',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Rina Sari',
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dimas Pratama',
            'email' => 'dimas@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Maya Putri',
            'email' => 'maya.putri@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Rizky Maulana',
            'email' => 'rizky@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'auth_provider' => 'email',
            'email_verified_at' => now(),
        ]);
    }
}
