<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi';

    protected $fillable = [
        'tipe',
        'nama',
        'jabatan',
        'deskripsi',
        'anggota',
        'badge',
        'sort_order',
    ];

    /**
     * Scope pengurus inti.
     */
    public function scopeInti(Builder $query): Builder
    {
        return $query->where('tipe', 'inti');
    }

    /**
     * Scope divisi.
     */
    public function scopeDivisi(Builder $query): Builder
    {
        return $query->where('tipe', 'divisi');
    }
}
