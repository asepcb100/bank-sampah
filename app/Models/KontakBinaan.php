<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontakBinaan extends Model
{
    use HasFactory;

    protected $table = 'kontak_binaan';

    protected $fillable = [
        'binaan_id',
        'nama',
        'whatsapp',
    ];

    /**
     * Relasi ke binaan.
     */
    public function binaan(): BelongsTo
    {
        return $this->belongsTo(Binaan::class);
    }
}
