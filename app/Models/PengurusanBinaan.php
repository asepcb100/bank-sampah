<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengurusanBinaan extends Model
{
    use HasFactory;

    protected $table = 'pengurusan_binaan';

    protected $fillable = [
        'binaan_id',
        'nama',
        'jabatan',
    ];

    /**
     * Relasi ke binaan.
     */
    public function binaan(): BelongsTo
    {
        return $this->belongsTo(Binaan::class);
    }
}
