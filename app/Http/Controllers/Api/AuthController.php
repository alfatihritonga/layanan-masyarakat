<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Login dengan email & password (opsional, bisa dihapus jika hanya OAuth)
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Cek jika user login via Google
        if ($user->isGoogleUser()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini terdaftar menggunakan Google. Silakan login dengan Google.',
            ], 422);
        }

        $token = $this->authService->createToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar' => $user->avatar,
                ],
                'token' => $token,
            ]
        ]);
    }

    /**
     * Redirect ke Google OAuth
     */
    public function redirectToGoogle(): JsonResponse
    {
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }

    /**
     * Callback dari Google OAuth
     */
    public function handleGoogleCallback(Request $request): JsonResponse
    {
        try {
            // Jika ada error dari Google
            if ($request->has('error')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login dengan Google dibatalkan',
                ], 400);
            }

            // Dapatkan user dari Google
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            // Cari atau buat user
            $user = $this->authService->findOrCreateGoogleUser($googleUser);

            // Buat token
            $token = $this->authService->createToken($user);

            return response()->json([
                'success' => true,
                'message' => 'Login dengan Google berhasil',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'avatar' => $user->avatar,
                        'auth_provider' => $user->auth_provider,
                    ],
                    'token' => $token,
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat login dengan Google',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get current user
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role,
                'avatar' => $request->user()->avatar,
                'auth_provider' => $request->user()->auth_provider,
            ]
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}