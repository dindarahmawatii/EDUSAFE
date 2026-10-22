<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard admin: daftar materi dari database.
     */
    public function dashboard(): View
    {
        try {
            $materiList = Materi::orderByDesc((new Materi)->getKeyName())->get();
        } catch (\Throwable $e) {
            $materiList = collect();
        }

        $totalMateri = $materiList->count();
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

        return view('admin.dashboard', compact('materiList', 'totalMateri', 'soalKuis'));
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

        // Tabel MySQL memakai kolom namamateri/konten; kolom lain ditambahkan hanya jika ada.
        $data = [
            'namamateri' => $validated['judul'],
            'kategori'   => $validated['kategori'],
            'konten'     => $validated['konten'],
        ];

        if (Schema::hasColumn('materi', 'deskripsi')) {
            $data['deskripsi'] = $validated['deskripsi'];
        }

        if (Schema::hasColumn('materi', 'created_at')) {
            $data['created_at'] = now();
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
}
