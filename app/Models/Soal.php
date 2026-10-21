<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    public $timestamps = false;

    protected $fillable = [
        'idsoal',
        'idkuis',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban_benar',
    ];

    public function getKeyName(): string
    {
        try {
            if (Schema::hasColumn($this->getTable(), 'idsoal')) {
                return 'idsoal';
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return 'id';
    }

    public function getIdAttribute(): mixed
    {
        return $this->attributes['idsoal'] ?? $this->attributes['id'] ?? null;
    }

    public function kuis(): BelongsTo
    {
        return $this->belongsTo(Kuis::class, 'idkuis', 'idkuis');
    }
}
