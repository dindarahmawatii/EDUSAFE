<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materi;
use Illuminate\Support\Str;

class admincontroller extends Controller
{
    public function storeMateri(Request $request)
    {
        // 1. Validasi Input & File PDF
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_pdf'  => 'required|mimes:pdf|max:10240', // Maksimal 10MB
        ]);

        // 2. Proses Upload File PDF ke Public Folder
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke direktori: public/uploads/pdf/
            $file->move(public_path('uploads/pdf'), $filename);
        }

        // 3. Simpan Record ke Database
        Materi::create([
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'file_pdf'  => $filename,
        ]);

        return redirect()->back()->with('success', 'Materi PDF berhasil diunggah!');
    }
}