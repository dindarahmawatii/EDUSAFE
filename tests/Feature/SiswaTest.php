<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_siswa_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('home'))->assertOk();
        $this->actingAs($user)->get(route('siswa.materi'))->assertOk();
        $this->actingAs($user)->get(route('siswa.baca-materi', 1))->assertOk();
        $this->actingAs($user)->get(route('siswa.kuis'))
            ->assertOk()
            ->assertSee('EDUSAFE - Pengerjaan Kuis')
            ->assertSee('PERTANYAAN 1')
            ->assertSee('Progress Belajar');
        $this->actingAs($user)->get(route('siswa.nilai'))->assertOk();
        $this->actingAs($user)->get(route('siswa.evaluasi-siswa'))->assertOk();
        $this->actingAs($user)->get(route('siswa.rekap'))->assertOk();
    }

    public function test_submit_kuis_redirects_to_nilai(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('siswa.kuis.submit'), [
            'materi_id' => 1,
            'jawaban_1' => 'A',
            'jawaban_2' => 'A',
            'jawaban_3' => 'A',
            'jawaban_4' => 'A',
        ]);

        $response->assertRedirect(route('siswa.nilai'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('kuisTerakhir');

        // Memastikan ringkasan nilai menampilkan hasil pengerjaan kuis
        $this->actingAs($user)->get(route('siswa.nilai'))
            ->assertOk()
            ->assertSee('Skor Akhir');
    }
}
