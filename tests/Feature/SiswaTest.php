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

        $this->actingAs($user)->get(route('siswa.materi'))->assertOk();
        $this->actingAs($user)->get(route('siswa.baca-materi', 1))->assertOk();
        $this->actingAs($user)->get(route('siswa.kuis'))->assertOk();
        $this->actingAs($user)->get(route('siswa.nilai'))->assertOk();
        $this->actingAs($user)->get(route('siswa.evaluasi-siswa'))->assertOk();
        $this->actingAs($user)->get(route('siswa.rekap'))->assertOk();
    }

    public function test_submit_kuis_redirects_to_nilai(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('siswa.kuis.submit'));

        $response->assertRedirect(route('siswa.nilai'));
        $response->assertSessionHas('success');
    }
}
