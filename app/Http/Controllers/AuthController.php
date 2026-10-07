<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
    public function login(LoginRequest $request): RedirectResponse
    {
        $throttleKey = $request->throttleKey();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = max(1, (int) ceil($seconds / 60));

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login yang salah (5 kali). Anda tidak dapat memasukkan password selama {$minutes} menit.",
            ])->onlyInput('email');
        }

        $validated = $request->validated();
        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $remember)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended('/materi');
        }

        RateLimiter::hit($throttleKey, 60);
        $attempts = RateLimiter::attempts($throttleKey);

        if ($attempts >= 5) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = max(1, (int) ceil($seconds / 60));

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login yang salah (5 kali). Anda tidak dapat memasukkan password selama {$minutes} menit.",
            ])->onlyInput('email');
        }

        $remaining = 5 - $attempts;

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
