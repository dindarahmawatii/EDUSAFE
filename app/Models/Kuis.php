<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Kuis extends Model
{
    use HasFactory;

    protected $table = 'kuis';

    public $timestamps = false;

    protected $fillable = [
        'idkuis',
        'namakuis',
        'deskripsi',
        'waktuPengerjaan',
        'created_at',
    ];

    public function getKeyName(): string
    {
        try {
            if (Schema::hasColumn($this->getTable(), 'idkuis')) {
                return 'idkuis';
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return 'id';
    }

    public function getIdAttribute(): mixed
    {
        return $this->attributes['idkuis'] ?? $this->attributes['id'] ?? null;
    }

    public function getJudulAttribute(): mixed
    {
        return $this->attributes['namakuis'] ?? $this->attributes['judul'] ?? null;
    }

    public function soals(): HasMany
    {
        return $this->hasMany(Soal::class, 'idkuis', 'idkuis');
    }
}
