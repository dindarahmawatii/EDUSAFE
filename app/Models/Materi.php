<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'modul',
        'judul',
        'kategori',
        'deskripsi',
        'file_pdf',
        'isi_teks',
    ];
}