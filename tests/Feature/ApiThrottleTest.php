<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiThrottleTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_login_is_blocked_after_five_failed_attempts(): void
    {
        User::factory()->create([
            'email' => 'budi@example.com',
            'password' => 'secret123',
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/login', [
                'email' => 'budi@example.com',
                'password' => 'salah-'.$i,
            ])->assertStatus(401);
        }

        // Percobaan ke-6 ditolak, bahkan dengan password yang benar.
        $this->postJson('/api/login', [
            'email' => 'budi@example.com',
            'password' => 'secret123',
        ])->assertStatus(429);
    }

    public function test_api_login_limit_is_per_email(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/login', [
                'email' => 'korban@example.com',
                'password' => 'salah',
            ])->assertStatus(401);
        }

        $this->postJson('/api/login', [
            'email' => 'korban@example.com',
            'password' => 'salah',
        ])->assertStatus(429);

        // Email lain dari IP yang sama belum kena batas per-email.
        $this->postJson('/api/login', [
            'email' => 'lain@example.com',
            'password' => 'salah',
        ])->assertStatus(401);
    }

    public function test_api_register_is_blocked_after_three_attempts_per_minute(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $this->postJson('/api/register', [
                'name' => 'User '.$i,
                'email' => "user{$i}@example.com",
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])->assertStatus(201);
        }

        $this->postJson('/api/register', [
            'name' => 'User 4',
            'email' => 'user4@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertStatus(429);
    }
}
