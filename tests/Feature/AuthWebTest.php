<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AuthWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Buat Akun Baru');
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang!');
    }

    public function test_user_can_register_via_web_form_and_data_is_saved_in_database(): void
    {
        $payload = [
            'name' => 'Ahmad Fajar',
            'email' => 'ahmad@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $payload);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');

        $this->assertDatabaseHas('users', [
            'name' => 'Ahmad Fajar',
            'email' => 'ahmad@example.com',
        ]);

        $user = User::where('email', 'ahmad@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password123', $user->password));

        if (Schema::hasTable('user')) {
            $this->assertDatabaseHas('user', [
                'email' => 'ahmad@example.com',
                'username' => 'Ahmad Fajar',
            ]);
        }
    }

    public function test_web_registration_fails_validation_for_invalid_data(): void
    {
        $payload = [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ];

        $response = $this->post('/register', $payload);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertDatabaseMissing('users', [
            'email' => 'not-an-email',
        ]);
    }

    public function test_registered_user_can_login_via_web_form(): void
    {
        $user = User::factory()->create([
            'email' => 'siswa@edusafe.test',
            'password' => 'password123',
        ]);

        $payload = [
            'email' => 'siswa@edusafe.test',
            'password' => 'password123',
        ];

        $response = $this->post('/login', $payload);

        $response->assertRedirect('/materi');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password_via_web(): void
    {
        User::factory()->create([
            'email' => 'siswa@edusafe.test',
            'password' => 'password123',
        ]);

        $payload = [
            'email' => 'siswa@edusafe.test',
            'password' => 'wrongpassword',
        ];

        $response = $this->post('/login', $payload);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout_via_web(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
