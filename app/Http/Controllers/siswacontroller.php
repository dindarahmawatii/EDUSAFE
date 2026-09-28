<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class siswacontroller extends Controller
{
    // 1. Halaman Utama Daftar Semua Materi
    public function materi()
    {
        $materiList = [
            [
                'id' => 1,
                'modul' => 'Modul 01',
                'judul' => 'Pengenalan Malware',
                'deskripsi' => 'Memahami dasar-dasar perangkat lunak berbahaya, sejarah perkembangannya, dan ancaman digital.',
                'durasi' => '15 Menit',
            ],
            [
                'id' => 2,
                'modul' => 'Modul 02',
                'judul' => 'Jenis-jenis Malware',
                'deskripsi' => 'Identifikasi perbedaan antara Virus, Worm, Trojan, Ransomware, dan Spyware.',
                'durasi' => '25 Menit',
            ],
            [
                'id' => 3,
                'modul' => 'Modul 03',
                'judul' => 'Mekanisme Infeksi',
                'deskripsi' => 'Mempelajari jalur distribusi malware melalui email phishing dan kerentanan operasi.',
                'durasi' => '20 Menit',
            ],
        ];

        return view('siswa.materi', compact('materiList'));
    }

    // 2. Halaman Baca Detail Materi Berdasarkan ID
    public function bacaMateri($id = 1)
    {
        $dataMateri = [
            1 => [
                'id' => 1,
                'modul' => 'Modul 01',
                'judul' => 'Pengenalan Malware Analysis',
                'estimasi' => '15 Menit',
                'kategori' => 'Cybersecurity',
                'isi' => [
                    [
                        'subjudul' => 'Apa itu Malware?',
                        'konten' => 'Malware (Malicious Software) adalah suatu perangkat lunak yang dirancang khusus dengan tujuan untuk merusak, menyusup, atau meretas sistem komputer, server, atau jaringan tanpa persetujuan dari pemiliknya.'
                    ],
                    [
                        'subjudul' => 'Mengapa Malware Berbahaya?',
                        'konten' => 'Malware dapat mencuri data sensitif pengguna (seperti kata sandi dan informasi perbankan), mengenkripsi file penting untuk meminta tebusan finansial (seperti Ransomware), atau secara diam-diam menyerang jaringan lain.'
                    ]
                ]
            ],
            2 => [
                'id' => 2,
                'modul' => 'Modul 02',
                'judul' => 'Jenis-jenis Malware',
                'estimasi' => '25 Menit',
                'kategori' => 'Malware Taxonomy',
                'isi' => [
                    [
                        'subjudul' => '1. Virus & Worm',
                        'konten' => 'Virus menggandakan diri dengan menempel pada program lain, sedangkan Worm menyebar mandiri melalui jaringan tanpa bantuan file induk.'
                    ],
                    [
                        'subjudul' => '2. Trojan & Ransomware',
                        'konten' => 'Trojan menyamar sebagai aplikasi biasa, sementara Ransomware mengenkripsi file penting untuk meminta tebusan finansial.'
                    ]
                ]
            ],
            3 => [
                'id' => 3,
                'modul' => 'Modul 03',
                'judul' => 'Mekanisme Infeksi Malware',
                'estimasi' => '20 Menit',
                'kategori' => 'Cyber Attack Vectors',
                'isi' => [
                    [
                        'subjudul' => 'Email Phishing',
                        'konten' => 'Metode paling umum dengan mengirimkan lampiran atau link berbahaya melalui email yang menyamar sebagai pihak terpercaya.'
                    ],
                    [
                        'subjudul' => 'Drive-by Download',
                        'konten' => 'Malware terunduh secara otomatis ke sistem pengguna hanya dengan mengklik atau mengunjungi situs web yang terinfeksi.'
                    ]
                ]
            ],
        ];

        $materi = $dataMateri[$id] ?? $dataMateri[1];

        return view('siswa.baca-materi', compact('materi'));
    }

    // 3. Halaman Kuis Siswa
    public function kuis($id = null)
    {
        return view('siswa.kuis', compact('id'));
    }

    // 4. Proses Submit Kuis
    public function submitKuis(Request $request)
    {
        return redirect()->route('siswa.nilai')->with('success', 'Kuis berhasil diselesaikan!');
    }

    // 5. Halaman Ringkasan Nilai & Pencapaian
    public function nilai()
    {
        // Menggunakan Auth::id() agar aman dari warning linter Intelephense
        $siswaId = Auth::id() ?? 1; 

        $kuisTerakhir = class_exists('\App\Models\HasilKuis') 
            ? \App\Models\HasilKuis::where('user_id', $siswaId)->latest()->first() 
            : null;

        $rataRataNilai = class_exists('\App\Models\HasilKuis') 
            ? \App\Models\HasilKuis::where('user_id', $siswaId)->avg('skor') 
            : 88.5;

        $materiSelesai = class_exists('\App\Models\ProgressMateri') 
            ? \App\Models\ProgressMateri::where('user_id', $siswaId)->where('is_selesai', true)->count() 
            : 12;

        return view('siswa.nilai', compact('kuisTerakhir', 'rataRataNilai', 'materiSelesai'));
    }

    // 6. Halaman Evaluasi Performa Siswa
    public function evaluasiSiswa()
    {
        return view('siswa.evaluasi-siswa');
    }

    // 7. Halaman Rekap/Review Jawaban Kuis
    public function rekap()
    {
        return view('siswa.rekap');
    }

    // 8. Fungsi Logout Siswa
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('success', 'Berhasil keluar dari sistem.');
    }
}