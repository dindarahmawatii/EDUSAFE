<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 201);
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $throttleKey = $request->throttleKey();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = max(1, (int) ceil($seconds / 60));

            return response()->json([
                'message' => "Terlalu banyak percobaan login yang salah. Anda tidak dapat memasukkan password selama {$minutes} menit.",
                'retry_after' => $seconds,
            ], 429);
        }

        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            RateLimiter::hit($throttleKey, 15 * 60);

            $attempts = RateLimiter::attempts($throttleKey);

            if ($attempts >= 5) {
                $cleanKey = RateLimiter::cleanRateLimiterKey($throttleKey);
                Cache::put($cleanKey.':timer', now()->addMinutes(15)->getTimestamp(), 15 * 60);

                $seconds = RateLimiter::availableIn($throttleKey);
                $minutes = max(1, (int) ceil($seconds / 60));

                return response()->json([
                    'message' => "Terlalu banyak percobaan login yang salah (5 kali). Anda tidak dapat memasukkan password selama {$minutes} menit.",
                    'retry_after' => $seconds,
                ], 429);
            }

            $remaining = 5 - $attempts;

            return response()->json([
                'message' => 'Email atau password salah.',
                'remaining_attempts' => $remaining,
            ], 401);
        }

        RateLimiter::clear($throttleKey);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }

    /**
     * Handle user logout and revoke active token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ], 200);
    }

    /**
     * Get authenticated user profile.
     */
    public function profile(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->user(),
        ], 200);
    }
}
