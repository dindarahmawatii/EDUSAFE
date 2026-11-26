<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'exception',
        'file',
        'line',
        'url',
        'method',
        'ip_address',
        'user_id',
        'trace',
    ];

    /**
     * User yang sedang login saat error terjadi (jika ada).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
