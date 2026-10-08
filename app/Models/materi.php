<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    // Sesuaikan nama tabel jika di database kamu bernama 'materi' atau 'materis'
    protected $table = 'materis'; 

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'file_pdf',
    ];
}