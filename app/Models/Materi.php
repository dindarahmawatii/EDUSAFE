<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    public $timestamps = false;

    protected $fillable = [
        'idmateri',
        'namamateri',
        'konten',
        'kategori',
        'modul',
        'judul',
        'deskripsi',
        'file_pdf',
        'isi_teks',
    ];

    /**
     * Mendeteksi nama kolom primary key secara dinamis
     * agar kompatibel baik di MySQL (idmateri) maupun di SQLite testing (id).
     */
    public function getKeyName(): string
    {
        try {
            if (Schema::hasColumn($this->getTable(), 'idmateri')) {
                return 'idmateri';
            }
        } catch (\Throwable $e) {
            // Abaikan dan gunakan default
        }

        return 'id';
    }

    /**
     * Accessor ID untuk fleksibilitas kode pemanggil.
     */
    public function getIdAttribute(): mixed
    {
        return $this->attributes['idmateri'] ?? $this->attributes['id'] ?? null;
    }

    /**
     * Accessor judul untuk fleksibilitas kode pemanggil.
     */
    public function getJudulAttribute(): mixed
    {
        return $this->attributes['namamateri'] ?? $this->attributes['judul'] ?? null;
    }

    /**
     * Accessor deskripsi / konten.
     */
    public function getDeskripsiAttribute(): mixed
    {
        return $this->attributes['deskripsi'] ?? $this->attributes['konten'] ?? null;
    }
}
