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
}
