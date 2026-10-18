<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Show the registration page.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (Schema::hasTable('user')) {
            try {
                DB::table('user')->updateOrInsert(
                    ['email' => $user->email],
                    [
                        'username' => $user->name,
                        'password' => $user->password,
                        'role' => 'user',
                    ]
                );
            } catch (\Throwable $e) {
                // Ignore sync failures to prevent blocking registration
            }
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $throttleKey = $request->throttleKey();

        // Cek jika sudah melampaui batas percobaan (5 kali)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = max(1, (int) ceil($seconds / 60));

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => "Terlalu banyak percobaan login yang salah (5 kali).",
                    'retry_after' => $seconds
                ], 429);
            }

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login yang salah (5 kali). Anda tidak dapat memasukkan password selama {$minutes} menit.",
            ])->onlyInput('email');
        }

        $validated = $request->validated();
        $remember = $request->boolean('remember');

        // Proses Login Web (Session)
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $remember)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            // Jika dipanggil via AJAX/Fetch JavaScript
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil!',
                    'redirect' => route('home') // Otomatis mengarah ke route('home') /beranda
                ]);
            }

            return redirect()->route('home');
        }

        // Jika Login Gagal -> Tambahkan Hit Limiter
        RateLimiter::hit($throttleKey, 60);
        $attempts = RateLimiter::attempts($throttleKey);

        if ($attempts >= 5 || RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = max(1, (int) ceil($seconds / 60));

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan login yang salah (5 kali).',
                    'retry_after' => $seconds
                ], 429);
            }

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login yang salah (5 kali). Anda tidak dapat memasukkan password selama {$minutes} menit.",
            ])->onlyInput('email');
        }

        $remaining = max(0, 5 - $attempts);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Email atau password salah.',
                'remaining_attempts' => $remaining
            ], 401);
        }

        return back()->withErrors([
            'email' => "Email atau password salah. (Sisa: {$remaining}x percobaan)",
        ])->onlyInput('email');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}