<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class AuthService
{
    public function findOrCreateGoogleUser(SocialiteUser $googleUser): User
    {
        // Cek apakah user sudah ada berdasarkan google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Update avatar jika berubah
            $user->update([
                'avatar' => $googleUser->getAvatar(),
            ]);
            return $user;
        }

        // Cek apakah email sudah terdaftar
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Link akun yang sudah ada dengan Google
            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'auth_provider' => 'google',
                'email_verified_at' => now(),
            ]);
            return $existingUser;
        }

        // Buat user baru
        return User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'auth_provider' => 'google',
            'email_verified_at' => now(),
            'role' => 'user', // default role
        ]);
    }

    public function createToken(User $user, string $tokenName = 'api-token'): string
    {
        // Hapus token lama
        $user->tokens()->delete();
        
        // Buat token baru
        return $user->createToken($tokenName)->plainTextToken;
    }
}