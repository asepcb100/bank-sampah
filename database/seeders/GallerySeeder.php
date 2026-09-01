<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catProgram = Category::where('slug', 'program')->first();
        $catProduk = Category::where('slug', 'produk-galeri')->first();
        $catKolaborasi = Category::where('slug', 'kolaborasi')->first();
        $catEdukasi = Category::where('slug', 'edukasi')->first();

        $galleriesData = [
            [
                'title' => 'Program Penimbangan & Sedekah Sampah Rutin Pekan Pertama',
                'slug' => 'program-penimbangan-sedekah-sampah-rutin-pekan-pertama',
                'category_id' => $catProgram?->id,
                'description' => 'Kegiatan rutin bulanan penimbangan dan penyetoran sedekah sampah anorganik serta minyak jelantah oleh puluhan warga Desa.',
                'image_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop',
                'location' => 'Balai Desa Karangampel',
                'event_date' => '2026-08-15',
                'is_published' => true,
                'additional_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop', 'caption' => 'Suasana Penimbangan Warga', 'sort_order' => 1],
                    ['url' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop', 'caption' => 'Pencatatan Buku Tabungan Sampah', 'sort_order' => 2],
                ]
            ],
            [
                'title' => 'Pelatihan Pembuatan Sabun Alami Minyak Jelantah Bersama Kelompok Perempuan',
                'slug' => 'pelatihan-pembuatan-sabun-alami-minyak-jelantah-bersama-kelompok-perempuan',
                'category_id' => $catProduk?->id,
                'description' => 'Pelatihan praktek olahan limbah minyak goreng bekas menjadi sabun padat pembersih noda serbaguna kelas rumah tangga.',
                'image_url' => 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
                'location' => 'Sanggar Daur Ulang BIL',
                'event_date' => '2026-08-10',
                'is_published' => true,
                'additional_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop', 'caption' => 'Proses Pembuatan Sabun Padat', 'sort_order' => 1],
                    ['url' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?q=80&w=800&auto=format&fit=crop', 'caption' => 'Pengemasan Sabun Ramah Lingkungan', 'sort_order' => 2],
                ]
            ],
            [
                'title' => 'Aksi Bersih Pantai & Kolaborasi Lingkungan Bersama Mahasiswa KKN',
                'slug' => 'aksi-bersih-pantai-kolaborasi-lingkungan-bersama-mahasiswa-kkn',
                'category_id' => $catKolaborasi?->id,
                'description' => 'Aksi gotong royong pembersihan sampah plastik pesisir pantai Indramayu dan pembuatan instalasi ecobrick bersama mahasiswa.',
                'image_url' => 'https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?q=80&w=800&auto=format&fit=crop',
                'location' => 'Pesisir Pantai Indramayu',
                'event_date' => '2026-08-01',
                'is_published' => true,
                'additional_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?q=80&w=800&auto=format&fit=crop', 'caption' => 'Aksi Pungut Sampah Pesisir', 'sort_order' => 1],
                ]
            ],
            [
                'title' => 'Edukasi Pemilahan Sampah Dapur & Pembuatan Kompos Organik',
                'slug' => 'edukasi-pemilahan-sampah-dapur-pembuatan-kompos-organik',
                'category_id' => $catEdukasi?->id,
                'description' => 'Sosialisasi pembuatan komposter aerobik skala rumah tangga untuk mengolah sisa makanan menjadi pupuk organik bermanfaat.',
                'image_url' => 'https://images.unsplash.com/photo-1585314062340-f1a5a7c9328d?q=80&w=800&auto=format&fit=crop',
                'location' => 'Posyandu Melati',
                'event_date' => '2026-07-25',
                'is_published' => true,
                'additional_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1585314062340-f1a5a7c9328d?q=80&w=800&auto=format&fit=crop', 'caption' => 'Demo Pencampuran Sisa Organik', 'sort_order' => 1]
                ]
            ],
            [
                'title' => 'Workshop Kreasi Kerajinan Ecobrick & Limbah Perca Tekstil',
                'slug' => 'workshop-kreasi-kerajinan-ecobrick-limbah-perca-tekstil',
                'category_id' => $catProduk?->id,
                'description' => 'Pembuatan bangku modular berbahan botol ecobrick dan bantal sematan jarum dari kain perca konveksi.',
                'image_url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=800&auto=format&fit=crop',
                'location' => 'Sanggar Daur Ulang BIL',
                'event_date' => '2026-07-18',
                'is_published' => true,
                'additional_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=800&auto=format&fit=crop', 'caption' => 'Hasil Karya Bantal Perca Warga', 'sort_order' => 1]
                ]
            ],
            [
                'title' => 'Panen Perdana Fermentasi Eco-Enzyme Pembersih Alami',
                'slug' => 'panen-perdana-fermentasi-eco-enzyme-pembersih-alami',
                'category_id' => $catProgram?->id,
                'description' => 'Penyaringan cairan fermentasi eco-enzyme 3 bulan dari sisa kulit buah manis dan pembagian gratis kepada warga.',
                'image_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=800&auto=format&fit=crop',
                'location' => 'Rumah Organik BIL',
                'event_date' => '2026-07-05',
                'is_published' => true,
                'additional_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=800&auto=format&fit=crop', 'caption' => 'Penyaringan Cairan Eco-Enzyme', 'sort_order' => 1]
                ]
            ]
        ];

        foreach ($galleriesData as $gData) {
            $addImages = $gData['additional_images'];
            unset($gData['additional_images']);

            $gallery = Gallery::updateOrCreate(['slug' => $gData['slug']], $gData);

            $gallery->images()->delete();
            foreach ($addImages as $aImg) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_url' => $aImg['url'],
                    'caption' => $aImg['caption'],
                    'sort_order' => $aImg['sort_order'],
                ]);
            }
        }
    }
}
