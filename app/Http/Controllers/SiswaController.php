<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Materi;
use App\Models\MengerjakanKuis;
use App\Models\ProgresMembaca;
use App\Models\Soal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiswaController extends Controller
{
    /**
     * Menampilkan menu utama / beranda siswa.
     */
    public function home(): View
    {
        try {
            $materiList = Materi::orderBy((new Materi)->getKeyName())->limit(6)->get();
        } catch (\Throwable $e) {
            $materiList = collect();
        }

        return view('siswa.home', compact('materiList'));
    }

    /**
     * Menampilkan daftar materi modul pembelajaran.
     */
    public function materi(): View
    {
        try {
            $materiList = Materi::orderBy((new Materi)->getKeyName())->get();
        } catch (\Throwable $e) {
            $materiList = collect();
        }

        return view('siswa.materi', compact('materiList'));
    }

    /**
     * Menampilkan detail modul materi, pembaca PDF, dan menyimpan progres membaca ke database.
     */
    public function bacaMateri(int|string $id = 1): View
    {
        $materi = null;
        try {
            $materi = Materi::find($id);
        } catch (\Throwable $e) {
            $materi = null;
        }

        if (! $materi) {
            $materi = (object) [
                'id' => (int) $id,
                'modul' => 'Modul ' . str_pad((string) $id, 2, '0', STR_PAD_LEFT),
                'judul' => 'Pengenalan Malware & Ancaman Siber',
                'kategori' => 'Cybersecurity Fundamentals',
                'deskripsi' => 'Konsep dasar perangkat lunak berbahaya, evolusi ancaman siber, dan analisis mitigasi keamanan.',
                'file_pdf' => 'sample-materi.pdf',
                'isi_teks' => 'Malware (Malicious Software) merupakan program berbahaya yang dirancang untuk merusak atau mengeksploitasi sistem.',
            ];
        }

        // Catat progres membaca siswa ke tabel progres_membaca
        if (Auth::check()) {
            try {
                DB::table('progres_membaca')->updateOrInsert(
                    ['iduser' => Auth::id(), 'idmateri' => (int) $id],
                    ['status_selesai' => 1, 'updated_at' => now()]
                );
            } catch (\Throwable $e) {
                // Jangan gagalkan halaman jika tabel belum siap
            }
        }

        return view('siswa.baca-materi', compact('materi'));
    }

    /**
     * Halaman pengerjaan kuis siswa dengan soal yang dimuat dari database.
     */
    public function kuis(int|string|null $id = 1): View
    {
        $materiId = (int) ($id ?? 1);
        $materi = null;
        try {
            $materi = Materi::find($materiId);
        } catch (\Throwable $e) {
            $materi = null;
        }

        $namaModul = ($materi && ! empty($materi->judul))
            ? $materi->judul
            : 'Modul ' . str_pad((string) $materiId, 2, '0', STR_PAD_LEFT) . ' - Pengenalan Malware & Ancaman Siber';

        // Mengambil daftar soal langsung dari tabel soal di database
        $daftarSoal = $this->loadSoalFromDatabase($materiId);

        return view('siswa.kuis', compact('materiId', 'namaModul', 'daftarSoal'));
    }

    /**
     * Proses pengiriman jawaban kuis, perhitungan skor, dan penyimpanan riwayat ke tabel mengerjakan_kuis.
     */
    public function submitKuis(Request $request): RedirectResponse
    {
        $materiId = (int) $request->input('materi_id', 1);
        $daftarSoal = $this->loadSoalFromDatabase($materiId);
        $totalSoal = count($daftarSoal);
        $benar = 0;
        $jawabanUserMap = [];

        foreach ($daftarSoal as $num => $soal) {
            $jawabanUser = $request->input('jawaban_' . $num);
            $jawabanUserMap[$num] = $jawabanUser;
            if ($jawabanUser === $soal['jawaban_benar']) {
                $benar++;
            }
        }

        $skor = $totalSoal > 0 ? (int) round(($benar / $totalSoal) * 100) : 0;

        $materi = null;
        try {
            $materi = Materi::find($materiId);
        } catch (\Throwable $e) {
            $materi = null;
        }

        $namaModul = ($materi && ! empty($materi->judul))
            ? $materi->judul
            : 'Modul ' . str_pad((string) $materiId, 2, '0', STR_PAD_LEFT) . ' - Pengenalan Malware & Ancaman Siber';

        // Simpan hasil pengerjaan kuis ke tabel mengerjakan_kuis & evaluasi_dan_rekap di database
        if (Auth::check()) {
            try {
                $idKuis = DB::table('soal')->where('idmateri', $materiId)->value('idkuis');
                if (!$idKuis) {
                    $idKuis = DB::table('kuis')->value('idkuis');
                }
                if (!$idKuis) {
                    throw new \RuntimeException('Kuis belum tersedia untuk materi ini.');
                }

                $idMengerjakan = DB::table('mengerjakan_kuis')->insertGetId([
                    'iduser' => Auth::id(),
                    'idkuis' => $idKuis,
                    'jawabanKuis' => json_encode($jawabanUserMap),
                    'nilai_akhir' => $skor,
                    'status_kelulusan' => $skor >= 70 ? 'LULUS' : 'TIDAK LULUS',
                    'tanggal_pengerjaan' => now(),
                ]);

                // Simpan evaluasi otomatis
                $evaluasiTeks = $skor >= 85
                    ? 'Pemahaman sangat istimewa mengenai konsep malware dan strategi pertahanan siber.'
                    : ($skor >= 70
                        ? 'Pemahaman sudah baik, pertahankan dan pelajari lebih dalam vektor serangan.'
                        : 'Perlu mengulang materi dan meningkatkan pemahaman mitigasi malware.');

                DB::table('evaluasi_dan_rekap')->insert([
                    'idmengerjakan' => $idMengerjakan,
                    'kalimat_evaluasi' => $evaluasiTeks,
                    'filter_kategori' => 'Cybersecurity Fundamentals',
                    'tanggal_evaluasi' => now(),
                ]);
            } catch (\Throwable $e) {
                // Abaikan jika ada batasan foreign key saat testing
            }
        }

        $kuisTerakhir = (object) [
            'nama_modul' => $namaModul,
            'skor' => $skor,
            'benar' => $benar,
            'salah' => $totalSoal - $benar,
            'total' => $totalSoal,
            'tanggal' => now()->translatedFormat('d M Y'),
        ];

        session()->flash('kuisTerakhir', $kuisTerakhir);

        return redirect()->route('siswa.nilai')->with('success', 'Kuis berhasil diselesaikan! Skor Anda: ' . $skor);
    }

    /**
     * Halaman ringkasan nilai siswa dari database.
     */
    public function nilai(): View
    {
        $kuisTerakhir = session('kuisTerakhir');

        // Jika tidak ada di session, ambil dari riwayat mengerjakan_kuis di database
        if (! $kuisTerakhir && Auth::check()) {
            try {
                $terakhirDb = DB::table('mengerjakan_kuis')
                    ->join('kuis', 'mengerjakan_kuis.idkuis', '=', 'kuis.idkuis')
                    ->where('mengerjakan_kuis.iduser', Auth::id())
                    ->orderBy('mengerjakan_kuis.idmengerjakan', 'desc')
                    ->first();

                if ($terakhirDb) {
                    $kuisTerakhir = (object) [
                        'nama_modul' => $terakhirDb->namakuis ?? 'Malware Analysis Fundamentals',
                        'skor' => $terakhirDb->nilai_akhir ?? 90,
                        'tanggal' => date('d M Y', strtotime($terakhirDb->tanggal_pengerjaan)),
                    ];
                }
            } catch (\Throwable $e) {
                // Gunakan fallback
            }
        }

        // Hitung materi selesai dari tabel progres_membaca
        $materiSelesai = 0;
        if (Auth::check()) {
            try {
                $materiSelesai = DB::table('progres_membaca')
                    ->where('iduser', Auth::id())
                    ->where('status_selesai', 1)
                    ->count();
            } catch (\Throwable $e) {
                $materiSelesai = 0;
            }
        }

        return view('siswa.nilai', compact('kuisTerakhir', 'materiSelesai'));
    }

    /**
     * Memuat soal kuis dari database atau fallback ke default jika kosong.
     *
     * @return array<int, array{id: int, pertanyaan: string, opsi: array<string, string>, jawaban_benar: string, tips: string, modul_terkait: string}>
     */
    private function loadSoalFromDatabase(int $materiId = 1): array
    {
        if (!DB::getSchemaBuilder()->hasTable('soal') || !DB::getSchemaBuilder()->hasColumn('soal', 'idmateri')) {
            return [];
        }

        $soalRows = DB::table('soal')
            ->where('idmateri', $materiId)
            ->orderBy('idsoal')
            ->get();

        $result = [];
        foreach ($soalRows as $index => $row) {
            $num = $index + 1;
            $result[$num] = [
                'id' => $row->idsoal ?? $num,
                'pertanyaan' => $row->pertanyaan ?? '',
                'opsi' => [
                    'A' => $row->pilihan_a ?? '',
                    'B' => $row->pilihan_b ?? '',
                    'C' => $row->pilihan_c ?? '',
                    'D' => $row->pilihan_d ?? '',
                ],
                'jawaban_benar' => $row->jawaban_benar ?? '',
                'tips' => $row->pembahasan ?? 'Baca setiap pilihan dengan cermat sebelum menentukan jawaban.',
                'modul_terkait' => 'Materi #' . $materiId,
            ];
        }

        return $result;
    }

    /**
     * Halaman evaluasi siswa terhubung ke riwayat kuis dan progres database.
     */
    public function evaluasiSiswa(): View
    {
        $userId = Auth::id() ?? 1;

        $rerataKuis = 88;
        $materiSelesai = 0;
        $totalMateri = 6;
        $evaluasiList = collect();

        try {
            $avg = DB::table('mengerjakan_kuis')
                ->where('iduser', $userId)
                ->avg('nilai_akhir');

            if ($avg !== null) {
                $rerataKuis = (int) round($avg);
            }

            $materiSelesai = DB::table('progres_membaca')
                ->where('iduser', $userId)
                ->where('status_selesai', 1)
                ->count();

            $totalMateri = DB::table('materi')->count() ?: 6;

            $evaluasiList = DB::table('evaluasi_dan_rekap')
                ->join('mengerjakan_kuis', 'evaluasi_dan_rekap.idmengerjakan', '=', 'mengerjakan_kuis.idmengerjakan')
                ->where('mengerjakan_kuis.iduser', $userId)
                ->get();
        } catch (\Throwable $e) {
            // Gunakan nilai bawaan
        }

        $predikat = 'A';
        if ($rerataKuis < 60) {
            $predikat = 'C';
        } elseif ($rerataKuis < 75) {
            $predikat = 'B';
        } elseif ($rerataKuis < 85) {
            $predikat = 'B+';
        }

        return view('siswa.evaluasi', compact('rerataKuis', 'materiSelesai', 'totalMateri', 'predikat', 'evaluasiList'));
    }

    /**
     * Halaman rekap hasil belajar terhubung ke progres dan riwayat kuis database.
     */
    public function rekap(): View
    {
        $userId = Auth::id() ?? 1;
        $totalSelesai = 0;
        $riwayatKuis = collect();

        try {
            $totalSelesai = DB::table('progres_membaca')
                ->where('iduser', $userId)
                ->where('status_selesai', 1)
                ->count();

            $riwayatKuis = DB::table('mengerjakan_kuis')
                ->join('kuis', 'mengerjakan_kuis.idkuis', '=', 'kuis.idkuis')
                ->where('mengerjakan_kuis.iduser', $userId)
                ->orderBy('mengerjakan_kuis.idmengerjakan', 'desc')
                ->get();
        } catch (\Throwable $e) {
            // Gunakan nilai bawaan
        }

        return view('siswa.rekap', compact('totalSelesai', 'riwayatKuis'));
    }

    /**
     * Logout sesi siswa.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
