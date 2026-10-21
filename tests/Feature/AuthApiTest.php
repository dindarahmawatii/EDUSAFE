<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_successfully(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email'],
                    'access_token',
                    'token_type',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
        ]);
    }

    public function test_user_cannot_register_with_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'budi@example.com',
        ]);

        $payload = [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_register_with_mismatched_password(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'budi@example.com',
            'password' => 'secret123',
        ]);

        $payload = [
            'email' => 'budi@example.com',
            'password' => 'secret123',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email'],
                    'access_token',
                    'token_type',
                ],
            ]);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'budi@example.com',
            'password' => 'secret123',
        ]);

        $payload = [
            'email' => 'budi@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Email atau password salah.',
            ]);
    }

    public function test_user_cannot_login_with_unregistered_email(): void
    {
        $payload = [
            'email' => 'nonexistent@example.com',
            'password' => 'secret123',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Email atau password salah.',
            ]);
    }

    public function test_authenticated_user_can_access_profile(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJsonPath('data.email', $user->email);
    }

    public function test_unauthenticated_user_cannot_access_profile(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_user_can_logout_and_revoke_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logout berhasil',
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_user_is_locked_out_for_15_minutes_after_5_failed_attempts(): void
    {
        User::factory()->create([
            'email' => 'lockout@example.com',
            'password' => 'secret123',
        ]);

        $wrongPayload = [
            'email' => 'lockout@example.com',
            'password' => 'wrongpassword',
        ];

        // 4 failed attempts should return 401 with remaining attempts decreasing
        for ($i = 1; $i <= 4; $i++) {
            $response = $this->postJson('/api/login', $wrongPayload);
            $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Email atau password salah.',
                    'remaining_attempts' => 5 - $i,
                ]);
        }

        // 5th failed attempt should immediately lock out with 429
        $response5 = $this->postJson('/api/login', $wrongPayload);
        $response5->assertStatus(429)
            ->assertJsonStructure(['message', 'retry_after'])
            ->assertJsonPath('message', 'Terlalu banyak percobaan login yang salah (5 kali). Anda tidak dapat memasukkan password selama 15 menit.');

        $this->assertGreaterThanOrEqual(890, $response5->json('retry_after'));
        $this->assertLessThanOrEqual(900, $response5->json('retry_after'));

        // 6th attempt (even with the correct password) must still be blocked with 429
        $correctPayload = [
            'email' => 'lockout@example.com',
            'password' => 'secret123',
        ];

        $response6 = $this->postJson('/api/login', $correctPayload);
        $response6->assertStatus(429)
            ->assertJsonStructure(['message', 'retry_after'])
            ->assertJsonPath('message', 'Terlalu banyak percobaan login yang salah. Anda tidak dapat memasukkan password selama 15 menit.');
    }

    public function test_successful_login_clears_failed_attempt_counter(): void
    {
        User::factory()->create([
            'email' => 'resetcounter@example.com',
            'password' => 'secret123',
        ]);

        $wrongPayload = [
            'email' => 'resetcounter@example.com',
            'password' => 'wrongpassword',
        ];

        // Fail 2 times
        $this->postJson('/api/login', $wrongPayload)->assertStatus(401);
        $this->postJson('/api/login', $wrongPayload)->assertStatus(401);

        // Login successfully with correct password
        $correctPayload = [
            'email' => 'resetcounter@example.com',
            'password' => 'secret123',
        ];
        $this->postJson('/api/login', $correctPayload)->assertStatus(200);

        // Counter is reset; next failed attempt should have remaining_attempts = 4
        $response = $this->postJson('/api/login', $wrongPayload);
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Email atau password salah.',
                'remaining_attempts' => 4,
            ]);
    }
}
