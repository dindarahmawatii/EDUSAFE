<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar materi modul pembelajaran.
     */
    public function materi(): View
    {
        $materiList = Materi::all();

        return view('siswa.materi', compact('materiList'));
    }

    /**
     * Menampilkan detail modul materi dan pembaca PDF.
     */
    public function bacaMateri(int|string $id = 1): View
    {
        $materi = Materi::find($id) ?? (object) [
            'id' => (int) $id,
            'modul' => 'Modul ' . str_pad((string) $id, 2, '0', STR_PAD_LEFT),
            'judul' => 'Pengenalan Malware & Ancaman Siber',
            'kategori' => 'Cybersecurity Fundamentals',
            'deskripsi' => 'Konsep dasar perangkat lunak berbahaya, evolusi ancaman siber, dan analisis mitigasi keamanan.',
            'file_pdf' => 'sample-materi.pdf',
            'isi_teks' => 'Malware (Malicious Software) merupakan program berbahaya yang dirancang untuk merusak atau mengeksploitasi sistem.',
        ];

        return view('siswa.baca-materi', compact('materi'));
    }

    /**
     * Halaman pengerjaan kuis siswa.
     */
    public function kuis(int|string|null $id = 1): View
    {
        $materiId = $id ?? 1;

        return view('siswa.kuis', compact('materiId'));
    }

    /**
     * Proses pengiriman jawaban kuis.
     */
    public function submitKuis(Request $request): RedirectResponse
    {
        return redirect()->route('siswa.nilai')->with('success', 'Kuis berhasil diselesaikan!');
    }

    /**
     * Halaman ringkasan nilai siswa.
     */
    public function nilai(): View
    {
        return view('siswa.nilai');
    }

    /**
     * Halaman evaluasi siswa.
     */
    public function evaluasiSiswa(): View
    {
        return view('siswa.evaluasi');
    }

    /**
     * Halaman rekap hasil belajar.
     */
    public function rekap(): View
    {
        return view('siswa.rekap');
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
