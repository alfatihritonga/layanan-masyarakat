<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function showLoginForm()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email tidak terdaftar dalam sistem'])
                ->withInput($request->only('email'));
        }

        // Cek apakah akun menggunakan Google
        if ($user->auth_provider === 'google') {
            return back()
                ->withErrors(['email' => 'Akun ini terdaftar menggunakan Google. Silakan login dengan Google'])
                ->withInput($request->only('email'));
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Password salah'])
                ->withInput($request->only('email'));
        }

        // Login
        $remember = $request->boolean('remember');
        Auth::loginUsingId($user->id, $remember);
        return $this->redirectByRole();
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            // Jika ada error dari Google
            if ($request->has('error')) {
                return redirect()->route('login')
                    ->with('error', 'Login dengan Google dibatalkan');
            }

            // Dapatkan user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cari atau buat user
            $user = $this->authService->findOrCreateGoogleUser($googleUser);

            // Login user
            Auth::loginUsingId($user->id, true);
        
            return $this->redirectByRole();
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
        }
    }

    protected function redirectByRole()
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->intended(route('dashboard', absolute: false))->with('success', 'Welcome Back, ' . $user->name . '!'),
            'user'  => redirect()->intended(route('user.dashboard', absolute: false))->with('success', 'Welcome Back, ' . $user->name . '!'),
            default => abort(403),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}