<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class MengerjakanKuis extends Model
{
    use HasFactory;

    protected $table = 'mengerjakan_kuis';

    public $timestamps = false;

    protected $fillable = [
        'idmengerjakan',
        'iduser',
        'idkuis',
        'jawabanKuis',
        'nilai_akhir',
        'status_kelulusan',
        'tanggal_pengerjaan',
    ];

    public function getKeyName(): string
    {
        try {
            if (Schema::hasColumn($this->getTable(), 'idmengerjakan')) {
                return 'idmengerjakan';
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return 'id';
    }

    public function kuis(): BelongsTo
    {
        return $this->belongsTo(Kuis::class, 'idkuis', 'idkuis');
    }
}
