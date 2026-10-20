<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Menyimpan data materi PDF baru dari Admin.
     */
    public function storeMateri(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_pdf'  => 'required|mimes:pdf|max:10240',
        ]);

        $file = $request->file('file_pdf');
        $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/pdf'), $filename);

        Materi::create([
            'judul'     => $validated['judul'],
            'kategori'  => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'file_pdf'  => $filename,
        ]);

        return back()->with('success', 'Materi PDF berhasil diunggah!');
    }
}