<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    use HasFactory;

    protected $table = 'visi_misi';

    protected $fillable = [
        'tipe',
        'label',
        'judul',
        'deskripsi',
        'sort_order',
    ];

    /**
     * Scope visi.
     */
    public function scopeVisi(Builder $query): Builder
    {
        return $query->where('tipe', 'visi');
    }

    /**
     * Scope misi.
     */
    public function scopeMisi(Builder $query): Builder
    {
        return $query->where('tipe', 'misi');
    }
}
