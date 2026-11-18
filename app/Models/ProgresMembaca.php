<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class ProgresMembaca extends Model
{
    use HasFactory;

    protected $table = 'progres_membaca';

    public $timestamps = false;

    protected $fillable = [
        'idprogres',
        'iduser',
        'idmateri',
        'status_selesai',
        'updated_at',
    ];

    public function getKeyName(): string
    {
        try {
            if (Schema::hasColumn($this->getTable(), 'idprogres')) {
                return 'idprogres';
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return 'id';
    }

    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class, 'idmateri', 'idmateri');
    }

    /**
     * Judul materi terakhir yang dibaca siswa (progres_membaca.updated_at terbaru).
     * Mengembalikan null jika belum ada progres atau tabel belum siap.
     */
    public static function namaMateriTerakhir(int $userId): ?string
    {
        try {
            $progres = \Illuminate\Support\Facades\DB::table('progres_membaca')
                ->where('iduser', $userId)
                ->orderByDesc('updated_at')
                ->first();

            if (! $progres || ! isset($progres->idmateri)) {
                return null;
            }

            $materi = \Illuminate\Support\Facades\DB::table('materi')
                ->where('idmateri', $progres->idmateri)
                ->first();

            return $materi->judul ?? $materi->namamateri ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
