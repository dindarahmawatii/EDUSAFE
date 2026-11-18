<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluasiInstruktur extends Model
{
    protected $table = 'evaluasi_instruktur';

    protected $fillable = ['iduser', 'user_id', 'idadmin', 'catatan'];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idadmin');
    }

    /** Evaluasi terbaru untuk satu siswa (null jika belum ada). */
    public static function terbaruUntuk(int $userId): ?self
    {
        return static::where('iduser', $userId)->latest('created_at')->latest('id')->first();
    }
}
