<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Kategori Produk Katalog
            ['name' => 'Perawatan', 'slug' => 'perawatan', 'type' => 'katalog', 'description' => 'Produk perawatan serbaguna alami ramah lingkungan'],
            ['name' => 'Kerajinan', 'slug' => 'kerajinan', 'type' => 'katalog', 'description' => 'Produk kerajinan tangan dari daur ulang limbah anorganik'],
            ['name' => 'Organik', 'slug' => 'organik', 'type' => 'katalog', 'description' => 'Pupuk dan cairan organik fermentasi limbah dapur'],
            ['name' => 'Daur Ulang', 'slug' => 'daur-ulang', 'type' => 'katalog', 'description' => 'Pot dan wadah serbaguna hasil kreasi bahan bekas'],

            // Kategori Galeri Kegiatan
            ['name' => 'Program', 'slug' => 'program', 'type' => 'galeri', 'description' => 'Program kerja rutin sedekah sampah dan edukasi warga'],
            ['name' => 'Produk', 'slug' => 'produk-galeri', 'type' => 'galeri', 'description' => 'Dokumentasi proses pembuatan produk olahan sirkular'],
            ['name' => 'Kolaborasi', 'slug' => 'kolaborasi', 'type' => 'galeri', 'description' => 'Kegiatan bersama pemerintah desa, sekolah, dan KKN'],
            ['name' => 'Edukasi', 'slug' => 'edukasi', 'type' => 'galeri', 'description' => 'Sosialisasi pemilahan sampah organik dan anorganik'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
