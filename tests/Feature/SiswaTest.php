<?php

namespace Tests\Feature;

use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SiswaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (! Schema::hasTable('mengerjakan_kuis')) {
            Schema::create('mengerjakan_kuis', function ($table) {
                $table->id('idmengerjakan');
                $table->unsignedBigInteger('iduser')->nullable();
                $table->unsignedBigInteger('idkuis')->nullable();
                $table->unsignedBigInteger('idmateri')->nullable();
                $table->text('jawabanKuis')->nullable();
                $table->integer('nilai_akhir')->nullable();
                $table->string('status_kelulusan')->nullable();
                $table->timestamp('tanggal_pengerjaan')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('soal')) {
            Schema::create('soal', function ($table) {
                $table->id('idsoal');
                $table->unsignedBigInteger('idkuis')->nullable();
                $table->unsignedBigInteger('idmateri')->nullable();
                $table->text('pertanyaan')->nullable();
                $table->text('pilihan_a')->nullable();
                $table->text('pilihan_b')->nullable();
                $table->text('pilihan_c')->nullable();
                $table->text('pilihan_d')->nullable();
                $table->string('jawaban_benar')->nullable();
                $table->text('pembahasan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function test_authenticated_user_can_access_siswa_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('home'))->assertOk();
        $this->actingAs($user)->get(route('siswa.materi'))->assertOk();
        $this->actingAs($user)->get(route('siswa.baca-materi', 1))->assertOk();
        $this->actingAs($user)->get(route('siswa.kuis'))
            ->assertOk()
            ->assertSee('EDUSAFE - Pengerjaan Kuis')
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

    public function test_user_rekap_page_displays_actual_data_from_database(): void
    {
        $user = User::factory()->create();

        Materi::create([
            'namamateri' => 'Analisis Vektor Serangan Malware',
            'kategori' => 'Threat Intelligence',
            'deskripsi' => 'Pengenalan analisis vektor infeksi siber.',
            'konten' => 'Penjelasan lengkap vektor serangan.',
        ]);

        $response = $this->actingAs($user)->get(route('siswa.rekap'));

        $response->assertOk();
        $response->assertSee('Rekap Pembelajaran');
        $response->assertSee('TOTAL MODUL SELESAI');
        $response->assertSee('WAKTU BELAJAR');
        $response->assertSee('Target Mingguan');
        $response->assertSee('MATERI PEMBELAJARAN');
        $response->assertSee('Analisis Vektor Serangan Malware');
        $response->assertSee('Threat Intelligence');
    }

    public function test_user_sees_empty_state_when_no_modules_completed(): void
    {
        $user = User::factory()->create();

        // Modul ada, tapi user belum mengerjakan kuis sama sekali
        Materi::create([
            'namamateri' => 'Network Traffic & Packet Analysis',
            'kategori' => 'Network Security',
            'deskripsi' => 'Analisis paket jaringan menggunakan Wireshark.',
            'konten' => 'Penjelasan protokol TCP/IP dan filter Wireshark.',
        ]);

        $response = $this->actingAs($user)->get(route('siswa.review'));

        $response->assertOk();
        $response->assertSee('Review Pembahasan Kuis');
        $response->assertSee('Belum Ada Kuis yang Selesai Dikerjakan');
        $response->assertSee('Modul akan otomatis muncul di halaman review jawaban setelah Anda menyelesaikan kuisnya.');
        $response->assertDontSee('Network Traffic & Packet Analysis');
    }

    public function test_user_can_view_review_list_with_only_completed_modules_hidden_uncompleted(): void
    {
        $user = User::factory()->create();

        // Modul 1: sudah dikerjakan
        $materi1 = Materi::create([
            'namamateri' => 'Network Traffic & Packet Analysis',
            'kategori' => 'Network Security',
            'deskripsi' => 'Analisis paket jaringan menggunakan Wireshark.',
            'konten' => 'Penjelasan protokol TCP/IP dan filter Wireshark.',
        ]);

        // Modul 2: belum dikerjakan
        $materi2 = Materi::create([
            'namamateri' => 'Web Exploitation & Mitigation',
            'kategori' => 'Web Security',
            'deskripsi' => 'Pengenalan OWASP Top 10.',
            'konten' => 'Metode identifikasi celah SQL Injection dan XSS.',
        ]);

        // User hanya menyelesaikan kuis untuk Modul 1
        DB::table('mengerjakan_kuis')->insert([
            'iduser' => $user->id,
            'idkuis' => 1,
            'idmateri' => $materi1->getKey(),
            'jawabanKuis' => json_encode(['1' => 'A']),
            'nilai_akhir' => 90,
            'status_kelulusan' => 'LULUS',
            'tanggal_pengerjaan' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('siswa.review'));

        $response->assertOk();
        $response->assertSee('Review Pembahasan Kuis');
        $response->assertSee('Modul 01');
        $response->assertSee('Network Traffic & Packet Analysis');
        $response->assertSee('90 / 100');
        $response->assertSee('Lihat Pembahasan');

        // Modul 2 yang belum dikerjakan harus di-hide
        $response->assertDontSee('Web Exploitation & Mitigation');
    }

    public function test_uncompleted_module_review_detail_redirects_with_warning(): void
    {
        $user = User::factory()->create();

        $materi = Materi::create([
            'namamateri' => 'Cryptography & Data Protection',
            'kategori' => 'Cryptography',
            'deskripsi' => 'Dasar enkripsi simetris dan asimetris.',
            'konten' => 'Algoritma AES, RSA, dan implementasinya.',
        ]);

        // User mencoba mengakses detail review modul yang belum pernah dikerjakan
        $response = $this->actingAs($user)->get(route('siswa.review.detail', $materi->getKey()));

        $response->assertRedirect(route('siswa.review'));
        $response->assertSessionHas('warning', 'Modul ini belum dikerjakan. Silakan selesaikan kuis terlebih dahulu untuk melihat pembahasan.');
    }

    public function test_user_can_view_review_detail_page_with_actual_question_and_answers(): void
    {
        $user = User::factory()->create();

        $materi = Materi::create([
            'namamateri' => 'Web Exploitation & Mitigation',
            'kategori' => 'Web Security',
            'deskripsi' => 'Pengenalan OWASP Top 10.',
            'konten' => 'Metode identifikasi celah SQL Injection dan XSS.',
        ]);

        $materiId = $materi->getKey();

        // Seed soal untuk materi ini
        DB::table('soal')->insert([
            'idkuis' => 1,
            'idmateri' => $materiId,
            'pertanyaan' => 'Apa itu SQL Injection?',
            'pilihan_a' => 'Penyisipan perintah SQL jahat ke input data',
            'pilihan_b' => 'Pembersihan database otomatis',
            'pilihan_c' => 'Enkripsi data pengguna',
            'pilihan_d' => 'Pengujian performa server',
            'jawaban_benar' => 'A',
            'pembahasan' => 'SQLi terjadi ketika aplikasi mengeksekusi input pengguna tanpa sanitasi sebagai query SQL.',
        ]);

        // Simpan pengerjaan kuis siswa (jawaban benar)
        DB::table('mengerjakan_kuis')->insert([
            'iduser' => $user->id,
            'idkuis' => 1,
            'idmateri' => $materiId,
            'jawabanKuis' => json_encode(['1' => 'A']),
            'nilai_akhir' => 100,
            'status_kelulusan' => 'LULUS',
            'tanggal_pengerjaan' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('siswa.review.detail', $materiId));

        $response->assertOk();
        $response->assertSee('Modul 01');
        $response->assertSee('Web Exploitation & Mitigation');
        $response->assertSee('100 / 100');
        $response->assertSee('SOAL NO. 1');
        $response->assertSee('Apa itu SQL Injection?');
        $response->assertSee('Jawaban Benar');
        $response->assertSee('(Jawaban Anda Benar)');
        $response->assertSee('SQLi terjadi ketika aplikasi mengeksekusi input pengguna tanpa sanitasi');
    }
}
