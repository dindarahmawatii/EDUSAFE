<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard admin: daftar materi dari database serta statistik user.
     */
    public function dashboard(): View
    {
        try {
            $materiList = Materi::orderByDesc((new Materi)->getKeyName())->get();
        } catch (\Throwable $e) {
            $materiList = collect();
        }

        $totalMateri = $materiList->count();

        try {
            $totalUser = User::count();
            $userBaruBulanIni = User::where('created_at', '>=', now()->startOfMonth())->count();
            $recentUsers = User::orderByDesc((new User)->getKeyName())->take(5)->get();
        } catch (\Throwable $e) {
            $totalUser = 0;
            $userBaruBulanIni = 0;
            $recentUsers = collect();
        }

        $soalKuis = collect();
        try {
            $materiById = $materiList->keyBy(fn ($materi) => $materi->getKey());
            $soalKuis = DB::table('soal')->orderBy('idsoal')->get()->map(function ($soal) use ($materiById) {
                $materiId = $soal->idmateri ?? null;
                $materi = $materiId !== null ? $materiById->get($materiId) : null;
                return [
                    'id' => $soal->idsoal ?? $soal->id ?? null,
                    'materi_id' => $materiId,
                    'materi' => $materi->judul ?? $materi->namamateri ?? 'Materi belum dipilih',
                    'pertanyaan' => $soal->pertanyaan ?? '',
                    'opsi_a' => $soal->pilihan_a ?? '',
                    'opsi_b' => $soal->pilihan_b ?? '',
                    'opsi_c' => $soal->pilihan_c ?? '',
                    'opsi_d' => $soal->pilihan_d ?? '',
                    'kunci' => $soal->jawaban_benar ?? '',
                    'pembahasan' => $soal->pembahasan ?? '',
                ];
            });
        } catch (\Throwable $e) {
            $soalKuis = collect();
        }

        return view('admin.dashboard', compact(
            'materiList',
            'totalMateri',
            'soalKuis',
            'totalUser',
            'userBaruBulanIni',
            'recentUsers'
        ));
    }

    /**
     * Halaman data pelajar: daftar siswa tersinkron dari database.
     */
    public function dataPelajar(): View
    {
        try {
            $totalModul = Materi::count() ?: 6;
        } catch (\Throwable $e) {
            $totalModul = 6;
        }

        try {
            $pelajarList = User::orderByDesc((new User)->getKeyName())->get()->map(function ($user) {
                $modulSelesai = 0;
                $rerataNilai = 0;
                try {
                    $modulSelesai = DB::table('progres_membaca')
                        ->where('iduser', $user->id)
                        ->where('status_selesai', 1)
                        ->count();
                    $avg = DB::table('mengerjakan_kuis')
                        ->where('iduser', $user->id)
                        ->avg('nilai_akhir');
                    if ($avg !== null) {
                        $rerataNilai = (int) round($avg);
                    }
                } catch (\Throwable $e) {
                    // Abaikan jika tabel belum siap
                }

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'initials' => $user->initials,
                    'modul_selesai' => $modulSelesai,
                    'rerata_nilai' => $rerataNilai,
                    'status' => 'Aktif',
                    'created_at' => $user->created_at,
                ];
            });
        } catch (\Throwable $e) {
            $pelajarList = collect();
        }

        return view('admin.data-pelajar', compact('pelajarList', 'totalModul'));
    }

    /**
     * Menyimpan materi baru (teks) dari dashboard admin ke tabel `materi`.
     */
    public function storeMateri(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'konten'    => 'required|string',
        ]);

        $data = [];

        if (Schema::hasColumn('materi', 'namamateri')) {
            $data['namamateri'] = $validated['judul'];
        }

        if (Schema::hasColumn('materi', 'judul')) {
            $data['judul'] = $validated['judul'];
        }

        if (Schema::hasColumn('materi', 'kategori')) {
            $data['kategori'] = $validated['kategori'];
        }

        if (Schema::hasColumn('materi', 'konten')) {
            $data['konten'] = $validated['konten'];
        }

        if (Schema::hasColumn('materi', 'deskripsi')) {
            $data['deskripsi'] = $validated['deskripsi'];
        }

        if (Schema::hasColumn('materi', 'created_at')) {
            $data['created_at'] = now();
        }

        if (Schema::hasColumn('materi', 'updated_at')) {
            $data['updated_at'] = now();
        }

        if (empty($data)) {
            $data = [
                'namamateri' => $validated['judul'],
                'kategori'   => $validated['kategori'],
                'deskripsi'  => $validated['deskripsi'],
                'konten'     => $validated['konten'],
                'created_at' => now(),
            ];
        }

        DB::table('materi')->insert($data);

        return redirect()->route('admin.dashboard')->with('success', 'Materi berhasil ditambahkan!');
    }


    /** Menyimpan satu soal dan mengaitkannya langsung ke materi terpilih. */
    public function storeSoalKuis(Request $request)
    {
        $validated = $request->validate([
            'materi_id' => ['required', 'integer', 'exists:materi,idmateri'],
            'pertanyaan' => ['required', 'string'],
            'opsi_a' => ['required', 'string', 'max:1000'],
            'opsi_b' => ['required', 'string', 'max:1000'],
            'opsi_c' => ['required', 'string', 'max:1000'],
            'opsi_d' => ['required', 'string', 'max:1000'],
            'kunci_jawaban' => ['required', 'in:A,B,C,D'],
            'pembahasan' => ['required', 'string'],
        ]);

        if (!Schema::hasTable('soal') || !Schema::hasColumn('soal', 'idmateri')) {
            return response()->json(['message' => 'Kolom soal.idmateri belum tersedia. Jalankan migration terlebih dahulu.'], 422);
        }

        $idKuis = DB::table('kuis')->value('idkuis');
        if (!$idKuis) {
            $kuisData = [];
            if (Schema::hasColumn('kuis', 'namakuis')) $kuisData['namakuis'] = 'Kuis Materi EDUSAFE';
            if (Schema::hasColumn('kuis', 'deskripsi')) $kuisData['deskripsi'] = 'Kumpulan soal yang dikelola berdasarkan materi.';
            if (Schema::hasColumn('kuis', 'waktuPengerjaan')) $kuisData['waktuPengerjaan'] = 15;
            if (Schema::hasColumn('kuis', 'created_at')) $kuisData['created_at'] = now();
            $idKuis = DB::table('kuis')->insertGetId($kuisData, 'idkuis');
        }

        $data = [
            'idmateri' => (int) $validated['materi_id'],
            'pertanyaan' => $validated['pertanyaan'],
            'pilihan_a' => $validated['opsi_a'],
            'pilihan_b' => $validated['opsi_b'],
            'pilihan_c' => $validated['opsi_c'],
            'pilihan_d' => $validated['opsi_d'],
            'jawaban_benar' => $validated['kunci_jawaban'],
        ];
        if (Schema::hasColumn('soal', 'idkuis')) $data['idkuis'] = $idKuis;
        if (Schema::hasColumn('soal', 'pembahasan')) $data['pembahasan'] = $validated['pembahasan'];
        if (Schema::hasColumn('soal', 'created_at')) $data['created_at'] = now();

        $id = DB::table('soal')->insertGetId($data, 'idsoal');
        return response()->json(['success' => true, 'message' => 'Soal berhasil disimpan.', 'id' => $id]);
    }

    /** Memperbarui soal yang sudah tersimpan. */
    public function updateSoalKuis(Request $request, int $id)
    {
        $validated = $request->validate([
            'materi_id' => ['required', 'integer', 'exists:materi,idmateri'],
            'pertanyaan' => ['required', 'string'],
            'opsi_a' => ['required', 'string', 'max:1000'],
            'opsi_b' => ['required', 'string', 'max:1000'],
            'opsi_c' => ['required', 'string', 'max:1000'],
            'opsi_d' => ['required', 'string', 'max:1000'],
            'kunci_jawaban' => ['required', 'in:A,B,C,D'],
            'pembahasan' => ['required', 'string'],
        ]);

        $data = [
            'idmateri' => (int) $validated['materi_id'],
            'pertanyaan' => $validated['pertanyaan'],
            'pilihan_a' => $validated['opsi_a'],
            'pilihan_b' => $validated['opsi_b'],
            'pilihan_c' => $validated['opsi_c'],
            'pilihan_d' => $validated['opsi_d'],
            'jawaban_benar' => $validated['kunci_jawaban'],
        ];
        if (Schema::hasColumn('soal', 'pembahasan')) $data['pembahasan'] = $validated['pembahasan'];
        if (Schema::hasColumn('soal', 'updated_at')) $data['updated_at'] = now();

        $updated = DB::table('soal')->where('idsoal', $id)->update($data);
        if (!$updated && !DB::table('soal')->where('idsoal', $id)->exists()) {
            return response()->json(['message' => 'Soal tidak ditemukan.'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Soal berhasil diperbarui.']);
    }

    /** Menghapus soal dari database. */
    public function destroySoalKuis(int $id)
    {
        $deleted = DB::table('soal')->where('idsoal', $id)->delete();
        if (!$deleted) return response()->json(['message' => 'Soal tidak ditemukan.'], 404);
        return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus.']);
    }

    /**
     * Halaman rekapitulasi pembelajaran admin: ringkasan progres modul, durasi belajar, target mingguan, dan riwayat penyelesaian.
     */
    public function rekap(): View
    {
        $totalModul = 0;
        $totalModulSelesai = 0;
        $totalSiswa = 0;

        try {
            $totalModul = Materi::count();
            $totalSiswa = User::where('role', '!=', 'admin')->count() ?: 1;

            if (Schema::hasTable('progres_membaca')) {
                $totalModulSelesai = DB::table('progres_membaca')
                    ->where('status_selesai', 1)
                    ->count();
            }
        } catch (\Throwable $e) {
            $totalModul = 0;
            $totalModulSelesai = 0;
            $totalSiswa = 1;
        }

        // 2. Waktu Belajar Kumulatif
        // Dihitung aktual dari modul selesai (estimasi 45 menit/modul) + pengerjaan kuis (15 menit/kuis)
        $waktuBelajarFormatted = '0j 0m';
        try {
            $kuisCount = 0;
            if (Schema::hasTable('mengerjakan_kuis')) {
                $kuisCount = DB::table('mengerjakan_kuis')->count();
            }
            $totalMenit = ($totalModulSelesai * 45) + ($kuisCount * 15);
            $jam = floor($totalMenit / 60);
            $menit = $totalMenit % 60;
            $waktuBelajarFormatted = "{$jam}j {$menit}m";
        } catch (\Throwable $e) {
            $waktuBelajarFormatted = '0j 0m';
        }

        // 3. Target Mingguan (8 Modul)
        $targetMingguan = 8;
        $capaianMingguan = 0;
        try {
            if (Schema::hasTable('progres_membaca')) {
                $capaianMingguan = DB::table('progres_membaca')
                    ->where('status_selesai', 1)
                    ->where('updated_at', '>=', now()->startOfWeek())
                    ->count();

                // Jika minggu ini belum ada penyelesaian baru, ambil dari 7 hari terakhir
                if ($capaianMingguan === 0) {
                    $capaianMingguan = DB::table('progres_membaca')
                        ->where('status_selesai', 1)
                        ->where('updated_at', '>=', now()->subDays(7))
                        ->count();
                }
            }
        } catch (\Throwable $e) {
            $capaianMingguan = 0;
        }

        $persenTarget = $targetMingguan > 0 ? min(100, (int) round(($capaianMingguan / $targetMingguan) * 100)) : 0;
        $statusTarget = 'Baru Dimulai';
        if ($persenTarget >= 100) {
            $statusTarget = 'Target Tercapai';
        } elseif ($persenTarget >= 75) {
            $statusTarget = 'Hampir Selesai';
        } elseif ($persenTarget >= 40) {
            $statusTarget = 'Sedang Berjalan';
        }

        // 4. Data Rekap per Modul (Tingkat Penyelesaian & Status)
        $rekapModul = collect();
        try {
            $materiList = Materi::orderBy((new Materi)->getKeyName())->get();
            $materiPk = (new Materi)->getKeyName();

            $rekapModul = $materiList->map(function ($m) use ($totalSiswa, $materiPk) {
                $mId = $m->{$materiPk} ?? $m->idmateri ?? $m->id;
                $selesai = 0;

                if (Schema::hasTable('progres_membaca')) {
                    $selesai = DB::table('progres_membaca')
                        ->where('idmateri', $mId)
                        ->where('status_selesai', 1)
                        ->count();
                }

                $persen = $totalSiswa > 0 ? min(100, (int) round(($selesai / $totalSiswa) * 100)) : 0;

                if ($selesai >= $totalSiswa && $totalSiswa > 0) {
                    $status = 'Selesai';
                    $statusClass = 'badge-status-green';
                } elseif ($selesai > 0) {
                    $status = 'Berjalan';
                    $statusClass = 'badge-status-blue';
                } else {
                    $status = 'Belum Dimulai';
                    $statusClass = 'badge-status-yellow';
                }

                $durasi = (!empty($m->durasi)) ? $m->durasi : '45 Menit';

                return (object) [
                    'id' => $mId,
                    'judul' => $m->namamateri ?? $m->judul ?? 'Modul Pembelajaran',
                    'kategori' => $m->kategori ?? 'Cybersecurity Dasar',
                    'durasi' => $durasi,
                    'selesai_count' => $selesai,
                    'total_siswa' => $totalSiswa,
                    'persen' => $persen,
                    'status' => $status,
                    'status_class' => $statusClass,
                ];
            });
        } catch (\Throwable $e) {
            $rekapModul = collect();
        }

        // 5. Riwayat Penyelesaian Modul Siswa (Log Detail Semua Siswa)
        $riwayatSiswa = collect();
        try {
            if (Schema::hasTable('progres_membaca') && Schema::hasTable('materi')) {
                $materiPk = (new Materi)->getKeyName();

                $query = DB::table('progres_membaca')
                    ->join('users', 'progres_membaca.iduser', '=', 'users.id')
                    ->join('materi', 'progres_membaca.idmateri', '=', 'materi.' . $materiPk)
                    ->where('progres_membaca.status_selesai', 1)
                    ->select(
                        'users.id as user_id',
                        'users.name as user_name',
                        'users.email as user_email',
                        'materi.' . $materiPk . ' as materi_id',
                        'materi.namamateri',
                        'materi.kategori',
                        'progres_membaca.updated_at as tanggal_selesai'
                    );

                if (Schema::hasColumn('progres_membaca', 'updated_at')) {
                    $query->orderByDesc('progres_membaca.updated_at');
                }

                $riwayatSiswa = $query->get()->map(function ($item) {
                    $nilai = null;
                    $statusKuis = 'Belum Kuis';

                    if (Schema::hasTable('mengerjakan_kuis')) {
                        $kuisQuery = DB::table('mengerjakan_kuis')
                            ->where('iduser', $item->user_id);

                        if (Schema::hasColumn('mengerjakan_kuis', 'idmateri')) {
                            $kuisQuery->where('idmateri', $item->materi_id);
                        }

                        $kuis = $kuisQuery->orderByDesc('idmengerjakan')->first();

                        if ($kuis) {
                            $nilai = $kuis->nilai_akhir ?? null;
                            $statusKuis = $kuis->status_kelulusan ?? ($nilai >= 70 ? 'LULUS' : 'TIDAK LULUS');
                        }
                    }

                    return (object) [
                        'user_name' => $item->user_name,
                        'user_email' => $item->user_email,
                        'modul' => $item->namamateri ?? 'Modul Pembelajaran',
                        'kategori' => $item->kategori ?? 'Cybersecurity',
                        'tanggal_selesai' => !empty($item->tanggal_selesai) ? date('d M Y, H:i', strtotime($item->tanggal_selesai)) : '-',
                        'nilai' => $nilai,
                        'status_kuis' => $statusKuis,
                    ];
                });
            }
        } catch (\Throwable $e) {
            $riwayatSiswa = collect();
        }

        return view('admin.rekap', compact(
            'totalModul',
            'totalModulSelesai',
            'totalSiswa',
            'waktuBelajarFormatted',
            'targetMingguan',
            'capaianMingguan',
            'persenTarget',
            'statusTarget',
            'rekapModul',
            'riwayatSiswa'
        ));
    }
}
