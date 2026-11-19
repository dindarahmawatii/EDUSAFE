<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Pembatas percobaan untuk endpoint API (login, register, dan API umum).
     */
    protected function configureRateLimiting(): void
    {
        // Login API: maks 5x/menit per kombinasi email+IP, dan maks 20x/menit per IP
        // (menahan tebakan password ke satu akun maupun banyak akun dari satu IP).
        RateLimiter::for('api-login', function (Request $request) {
            $email = Str::lower((string) $request->input('email'));

            return [
                Limit::perMinute(5)->by('api-login|'.$email.'|'.$request->ip()),
                Limit::perMinute(20)->by('api-login-ip|'.$request->ip()),
            ];
        });

        // Register API: maks 5 akun per jam per IP, dan 3x/menit untuk mencegah lonjakan.
        RateLimiter::for('api-register', function (Request $request) {
            return [
                Limit::perMinute(3)->by('api-register-min|'.$request->ip()),
                Limit::perHour(5)->by('api-register-hour|'.$request->ip()),
            ];
        });

        // Endpoint API yang sudah terautentikasi: 60x/menit per user (atau per IP jika tidak ada user).
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
