<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Binaan extends Model
{
    use HasFactory;

    protected $table = 'binaan';

    protected $fillable = [
        'nama',
        'alamat',
        'berdiri_sejak',
    ];

    protected $casts = [
        'berdiri_sejak' => 'date',
    ];

    /**
     * Relasi ke pengurusan binaan.
     */
    public function pengurusan(): HasMany
    {
        return $this->hasMany(PengurusanBinaan::class);
    }

    /**
     * Relasi ke kontak binaan.
     */
    public function kontak(): HasMany
    {
        return $this->hasMany(KontakBinaan::class);
    }
}
