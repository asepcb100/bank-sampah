<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'contact_id',
        'title',
        'slug',
        'price',
        'price_text',
        'description',
        'benefits',
        'stock',
        'is_available',
    ];

    protected $appends = ['image_url'];

    protected $casts = [
        'price' => 'decimal:2',
        'benefits' => 'array',
        'is_available' => 'boolean',
        'stock' => 'integer',
    ];

    /**
     * Accessor untuk URL Gambar Utama Produk
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->relationLoaded('images') && $this->images->count() > 0) {
            $primary = $this->images->firstWhere('is_primary', true);
            if ($primary && $primary->image_url) {
                return $primary->image_url;
            }
            return $this->images->first()->image_url;
        }
        return 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop';
    }

    /**
     * Relasi ke Kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke Kontak Person (PIC Pemesanan WA)
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Relasi ke Banyak Foto Produk (Multiple Images)
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }
}
