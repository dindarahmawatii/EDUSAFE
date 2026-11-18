<?php

namespace Tests\Feature;

use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_guest_is_redirected_to_login_when_accessing_admin_routes(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.data-pelajar'))->assertRedirect(route('login'));
        $this->get(route('admin.rekap'))->assertRedirect(route('login'));
        $this->get(route('admin.evaluasi'))->assertRedirect(route('login'));
        $this->get(route('admin.laporan'))->assertRedirect(route('login'));

        $this->post(route('admin.materi.store'), [
            'judul' => 'Materi Ilegal',
        ])->assertRedirect(route('login'));

        $this->post(route('admin.kuis.store'), [
            'pertanyaan' => 'Soal Ilegal',
        ])->assertRedirect(route('login'));
    }

    public function test_regular_user_gets_403_forbidden_when_accessing_admin_routes(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.data-pelajar'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.rekap'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.evaluasi'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.laporan'))->assertForbidden();

        $this->actingAs($user)->post(route('admin.materi.store'), [
            'judul' => 'Materi Hacker',
        ])->assertForbidden();

        $this->actingAs($user)->post(route('admin.kuis.store'), [
            'pertanyaan' => 'Soal Hacker',
        ])->assertForbidden();
    }

    public function test_admin_dashboard_can_be_accessed(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Dashboard Admin');
        $response->assertSee('Tambah Modul Materi Baru');
    }

    public function test_admin_can_store_new_materi_successfully(): void
    {
        $admin = $this->createAdmin();

        $payload = [
            'judul' => 'Keamanan Jaringan & Firewall',
            'kategori' => 'Network Security',
            'deskripsi' => 'Pengenalan konsep dasar firewall dan filtering paket data.',
            'konten' => 'Firewall bertindak sebagai penghalang antara jaringan internal tepercaya dan jaringan luar.',
        ];

        $response = $this->actingAs($admin)->post(route('admin.materi.store'), $payload);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success', 'Materi berhasil ditambahkan!');

        $materi = Materi::first();
        $this->assertNotNull($materi);
        $this->assertEquals('Keamanan Jaringan & Firewall', $materi->judul);
    }

    public function test_admin_dashboard_displays_synchronized_user_count_and_recent_users(): void
    {
        $admin = $this->createAdmin();

        User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
        ]);
        User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Total User');
        $response->assertSee('3'); // admin + 2 user
        $response->assertSee('Budi Santoso');
        $response->assertSee('budi@example.com');
        $response->assertSee('Siti Aminah');
        $response->assertSee('siti@example.com');
    }

    public function test_admin_data_pelajar_page_displays_users_from_database(): void
    {
        $admin = $this->createAdmin();

        User::factory()->create([
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.data-pelajar'));

        $response->assertOk();
        $response->assertSee('Ahmad Dahlan');
        $response->assertSee('ahmad@example.com');
    }

    public function test_admin_user_login_redirects_directly_to_admin_panel(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->isAdmin());

        // Test normal web form login
        $response = $this->post(route('login.post'), [
            'email' => 'admin@test.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        // Logout before testing AJAX call
        $this->post(route('logout'));

        // Test AJAX login response
        $ajaxResponse = $this->postJson(route('login.post'), [
            'email' => 'admin@test.com',
            'password' => 'admin123',
        ]);

        $ajaxResponse->assertOk();
        $ajaxResponse->assertJson([
            'status' => 'success',
            'redirect' => route('admin.dashboard'),
        ]);
    }

    public function test_regular_user_login_redirects_to_home_not_admin(): void
    {
        $user = User::factory()->create([
            'name' => 'Siswa Test',
            'email' => 'siswa@test.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $this->assertFalse($user->isAdmin());

        $response = $this->post(route('login.post'), [
            'email' => 'siswa@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
    }

    public function test_admin_rekap_page_displays_actual_data_from_database(): void
    {
        $admin = $this->createAdmin();

        // Buat materi modul
        Materi::create([
            'namamateri' => 'Analisis Forensic Digital',
            'kategori' => 'Digital Forensics',
            'deskripsi' => 'Pengantar investigasi bukti digital.',
            'konten' => 'Metodologi dan chain of custody forensik digital.',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.rekap'));

        $response->assertOk();
        $response->assertSee('Rekap Pembelajaran Sistem');
        $response->assertSee('Total Modul Selesai');
        $response->assertSee('Waktu Belajar Kumulatif');
        $response->assertSee('Target Mingguan');
        $response->assertSee('8 Modul Selesai');
        $response->assertSee('Tingkat Penyelesaian per Modul');
        $response->assertSee('Riwayat Penyelesaian Modul Semua Siswa');
        $response->assertSee('Analisis Forensic Digital');
    }
}
