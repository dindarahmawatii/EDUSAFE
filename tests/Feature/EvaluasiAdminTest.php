<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluasiAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_evaluasi_page_shows_selected_student_name(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'user', 'name' => 'Budi Santoso']);

        $this->actingAs($admin)
            ->get(route('admin.evaluasi', $siswa->id))
            ->assertOk()
            ->assertSee('Budi Santoso');
    }

    public function test_evaluasi_page_without_student_shows_empty_state(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.evaluasi'))
            ->assertOk()
            ->assertSee('Belum ada pelajar yang dipilih');
    }

    public function test_regular_user_cannot_store_evaluasi(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->post(route('admin.evaluasi.store', $user->id), ['catatan' => 'x'])
            ->assertForbidden();
    }

    public function test_admin_evaluasi_is_shown_only_to_the_evaluated_student(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $a = User::factory()->create(['role' => 'user']);
        $b = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->post(route('admin.evaluasi.store', $a->id), ['catatan' => 'Catatan khusus untuk A'])
            ->assertRedirect(route('admin.evaluasi', $a->id));

        $this->actingAs($a)->get(route('siswa.evaluasi-siswa'))->assertSee('Catatan khusus untuk A');
        $this->actingAs($b)->get(route('siswa.evaluasi-siswa'))
            ->assertDontSee('Catatan khusus untuk A')
            ->assertSee('Belum ada catatan dari instruktur.');
    }

    public function test_latest_evaluasi_is_shown_and_history_is_kept(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)->post(route('admin.evaluasi.store', $siswa->id), ['catatan' => 'Evaluasi lama']);
        $this->travel(1)->minutes();
        $this->actingAs($admin)->post(route('admin.evaluasi.store', $siswa->id), ['catatan' => 'Evaluasi baru']);

        $this->actingAs($siswa)->get(route('siswa.evaluasi-siswa'))
            ->assertSee('Evaluasi baru')
            ->assertDontSee('Evaluasi lama');

        $this->actingAs($admin)->get(route('admin.evaluasi', $siswa->id))
            ->assertSee('Evaluasi lama')
            ->assertSee('Evaluasi baru');
    }

    public function test_catatan_is_required(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->post(route('admin.evaluasi.store', $siswa->id), ['catatan' => ''])
            ->assertSessionHasErrors('catatan');
    }
}
