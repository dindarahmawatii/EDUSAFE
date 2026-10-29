<?php

namespace Tests\Feature;

use App\Models\Materi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_can_be_accessed(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Dashboard Admin');
        $response->assertSee('Tambah Modul Materi Baru');
    }

    public function test_admin_can_store_new_materi_successfully(): void
    {
        $payload = [
            'judul' => 'Keamanan Jaringan & Firewall',
            'kategori' => 'Network Security',
            'deskripsi' => 'Pengenalan konsep dasar firewall dan filtering paket data.',
            'konten' => 'Firewall bertindak sebagai penghalang antara jaringan internal tepercaya dan jaringan luar.',
        ];

        $response = $this->post(route('admin.materi.store'), $payload);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success', 'Materi berhasil ditambahkan!');

        $materi = Materi::first();
        $this->assertNotNull($materi);
        $this->assertEquals('Keamanan Jaringan & Firewall', $materi->judul);
    }
}

