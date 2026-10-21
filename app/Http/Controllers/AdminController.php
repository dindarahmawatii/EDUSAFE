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

        return view('admin.dashboard', compact('materiList', 'totalMateri'));
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
}
