<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class siswacontroller extends Controller
{
    // 1. Daftar 9 Modul Utama
    // PESAN BACKEND: Nanti tinggal tarik dari DB: $materiList = \App\Models\Materi::all();
    public function materi()
    {
        $materiList = [
            [
                'id' => 1,
                'modul' => 'Modul 01',
                'judul' => 'Pengenalan Malware & Ancaman Siber',
                'deskripsi' => 'Memahami konsep dasar perangkat lunak berbahaya, evolusi ancaman siber dari masa ke masa, serta dampak fatal infeksi malware pada infrastruktur organisasi.',
                'durasi' => '15 Menit',
                'file_pdf' => 'modul-01-pengenalan-malware.pdf', // Placeholder PDF untuk Admin
            ],
            [
                'id' => 2,
                'modul' => 'Modul 02',
                'judul' => 'Klasifikasi & Taksonomi Jenis Malware',
                'deskripsi' => 'Menganalisis secara mendalam karakteristik unik dari Virus, Worm, Trojan, Ransomware, Spyware, Rootkit, hingga fileless malware modern.',
                'durasi' => '25 Menit',
                'file_pdf' => 'modul-02-jenis-malware.pdf',
            ],
            [
                'id' => 3,
                'modul' => 'Modul 03',
                'judul' => 'Vektor Serangan & Mekanisme Infeksi',
                'deskripsi' => 'Mempelajari bagaimana malware masuk ke dalam sistem melalui Social Engineering, Phishing, Drive-by Downloads, serta eksploitasi kerentanan zero-day.',
                'durasi' => '20 Menit',
                'file_pdf' => 'modul-03-mekanisme-infeksi.pdf',
            ],
            [
                'id' => 4,
                'modul' => 'Modul 04',
                'judul' => 'Landasan Analisis Statis Malware',
                'deskripsi' => 'Teknik membedah sampel malware tanpa menjalankannya. Meliputi verifikasi file hash (MD5/SHA256), ekstraksi printable strings, dan analisis PE Header.',
                'durasi' => '30 Menit',
                'file_pdf' => 'modul-04-analisis-statis.pdf',
            ],
            [
                'id' => 5,
                'modul' => 'Modul 05',
                'judul' => 'Analisis Dinamis & Perilaku Sandbox',
                'deskripsi' => 'Mengamati perilaku langsung malware saat dieksekusi di lingkungan terisolasi (Sandbox). Meliputi monitoring registry, sistem file, dan traffic jaringan.',
                'durasi' => '35 Menit',
                'file_pdf' => 'modul-05-analisis-dinamis.pdf',
            ],
            [
                'id' => 6,
                'modul' => 'Modul 06',
                'judul' => 'Teknologi Deteksi & Sistem Antivirus',
                'deskripsi' => 'Memahami cara kerja mesin pemindai antivirus, perbedaan teknik Signature-Based Matching dengan Heuristic Analysis, serta pencegahan EDR.',
                'durasi' => '25 Menit',
                'file_pdf' => 'modul-06-deteksi-antivirus.pdf',
            ],
            [
                'id' => 7,
                'modul' => 'Modul 07',
                'judul' => 'Penanganan & Response Serangan Ransomware',
                'deskripsi' => 'SOP penanganan insiden darurat saat terinfeksi ransomware: isolasi jaringan cepat, ekstraksi kunci enkripsi (jika memungkinkan), dan pemulihan backup.',
                'durasi' => '40 Menit',
                'file_pdf' => 'modul-07-penanganan-ransomware.pdf',
            ],
            [
                'id' => 8,
                'modul' => 'Modul 08',
                'judul' => 'Konsep Dasar Reverse Engineering',
                'deskripsi' => 'Pengenalan alat decompiler dan disassembler (Ghidra & IDA Pro) untuk menguraikan kode biner executable menjadi instruksi Assembly yang dapat dibaca.',
                'durasi' => '45 Menit',
                'file_pdf' => 'modul-08-reverse-engineering.pdf',
            ],
            [
                'id' => 9,
                'modul' => 'Modul 09',
                'judul' => 'Best Practices & Defense in Depth',
                'deskripsi' => 'Strategi keamanan siber komprehensif: penerapan arsitektur Defense in Depth, manajemen patch teratur, hardening OS, dan edukasi pengguna.',
                'durasi' => '20 Menit',
                'file_pdf' => 'modul-09-best-practices.pdf',
            ],
        ];

        return view('siswa.materi', compact('materiList'));
    }

    // 2. Detail Baca Materi + Fitur PDF Reader
    public function bacaMateri($id = 1)
    {
        // PESAN BACKEND: $materi = \App\Models\Materi::findOrFail($id);
        $dataMateri = [
            1 => [
                'id' => 1,
                'modul' => 'Modul 01',
                'judul' => 'Pengenalan Malware & Ancaman Siber',
                'estimasi' => '15 Menit',
                'kategori' => 'Cybersecurity Fundamentals',
                'file_pdf' => 'sample-materi.pdf', // Nama file PDF yang di-upload admin
                'isi_teks' => 'Malware (Malicious Software) merupakan istilah umum untuk program komputer jahat yang dibuat dengan niat merusak...',
            ],
            // ... Modul 2 - 9 menyesuaikan
        ];

        $materi = $dataMateri[$id] ?? $dataMateri[1];

        return view('siswa.baca-materi', compact('materi'));
    }

    public function kuis($id = null)
    {
        $materiId = $id ?? 1;
        return view('siswa.kuis', compact('materiId'));
    }

    public function submitKuis(Request $request)
    {
        return redirect()->route('siswa.nilai')->with('success', 'Kuis berhasil diselesaikan!');
    }

    public function nilai()
    {
        return view('siswa.nilai');
    }
    public function evaluasiSiswa()
    {
        return view('siswa.evaluasi-siswa');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Arahkan kembali ke halaman login
    }
}