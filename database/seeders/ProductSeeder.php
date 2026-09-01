<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catPerawatan = Category::where('slug', 'perawatan')->first();
        $catKerajinan = Category::where('slug', 'kerajinan')->first();
        $catOrganik = Category::where('slug', 'organik')->first();
        $catDaurUlang = Category::where('slug', 'daur-ulang')->first();

        $picSiti = Contact::where('name', 'Ibu Siti Khadijah')->first();
        $picBudi = Contact::where('name', 'Pak Budi Santoso')->first();
        $picRina = Contact::where('name', 'Mbak Rina Wati')->first();
        $picAdmin = Contact::where('is_primary', true)->first();

        $productsData = [
            [
                'title' => 'Sabun Minyak Jelantah Alami',
                'slug' => 'sabun-minyak-jelantah-alami',
                'category_id' => $catPerawatan?->id,
                'contact_id' => $picSiti?->id ?? $picAdmin?->id,
                'price' => 10000,
                'price_text' => 'Rp 10.000 / pcs',
                'description' => 'Sabun pembersih serbaguna ramah lingkungan buatan tangan warga dari olahan minyak goreng bekas yang telah dimurnikan dengan bahan alami.',
                'benefits' => ['Busa berlimpah & ampuh hilangkan noda minyak', '100% biodegradable & ramah lingkungan', 'Bahan baku dari sedekah jelantah warga'],
                'stock' => 50,
                'is_available' => true,
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop', 'is_primary' => true, 'sort_order' => 1],
                    ['url' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?q=80&w=800&auto=format&fit=crop', 'is_primary' => false, 'sort_order' => 2],
                ]
            ],
            [
                'title' => 'Ecobrick Modular Furnitur',
                'slug' => 'ecobrick-modular-furnitur',
                'category_id' => $catKerajinan?->id,
                'contact_id' => $picRina?->id ?? $picAdmin?->id,
                'price' => 0,
                'price_text' => 'Hubungi Kami',
                'description' => 'Botol PET padat terisi 250gram plastik anorganik kering yang siap dirangkai menjadi meja, kursi, dan elemen dekorasi interior.',
                'benefits' => ['Mengunci sampah plastik hingga puluhan tahun', 'Kuat, kokoh & tidak gampang pecah', 'Dapat dikreasikan menjadi beragam furnitur'],
                'stock' => 100,
                'is_available' => true,
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1530587191325-3db32d826c18?q=80&w=800&auto=format&fit=crop', 'is_primary' => true, 'sort_order' => 1],
                    ['url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=800&auto=format&fit=crop', 'is_primary' => false, 'sort_order' => 2],
                ]
            ],
            [
                'title' => 'Bantal Jarum Kain Perca',
                'slug' => 'bantal-jarum-kain-perca',
                'category_id' => $catKerajinan?->id,
                'contact_id' => $picRina?->id ?? $picAdmin?->id,
                'price' => 15000,
                'price_text' => 'Rp 15.000',
                'description' => 'Kerajinan bantal sematan jarum jahit lucu buatan kelompok perempuan dari limbah potong kain perca konveksi.',
                'benefits' => ['Motif unik & jahitan rapi buatan tangan', 'Mengurangi limbah tekstil konveksi lokal', 'Cocok untuk peralatan jahit rumahan'],
                'stock' => 25,
                'is_available' => true,
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=800&auto=format&fit=crop', 'is_primary' => true, 'sort_order' => 1]
                ]
            ],
            [
                'title' => 'Cairan Fermentasi Eco-Enzyme (500ml)',
                'slug' => 'cairan-fermentasi-eco-enzyme-500ml',
                'category_id' => $catOrganik?->id,
                'contact_id' => $picBudi?->id ?? $picAdmin?->id,
                'price' => 20000,
                'price_text' => 'Rp 20.000',
                'description' => 'Cairan pembersih serbaguna hasil fermentasi sampah buah dan sayuran segar selama 3 bulan. Bebas bahan kimia sintetis.',
                'benefits' => ['Pembersih lantai & disinfektan alami', 'Menghilangkan bau tak sedap', 'Mengamankan mikroorganisme tanah'],
                'stock' => 40,
                'is_available' => true,
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=800&auto=format&fit=crop', 'is_primary' => true, 'sort_order' => 1],
                    ['url' => 'https://images.unsplash.com/photo-1585314062340-f1a5a7c9328d?q=80&w=800&auto=format&fit=crop', 'is_primary' => false, 'sort_order' => 2]
                ]
            ],
            [
                'title' => 'Kompos Organik Kasgot (5kg)',
                'slug' => 'kompos-organik-kasgot-5kg',
                'category_id' => $catOrganik?->id,
                'contact_id' => $picBudi?->id ?? $picAdmin?->id,
                'price' => 25000,
                'price_text' => 'Rp 25.000',
                'description' => 'Pupuk kompos padat nutrisi tinggi hasil pengomposan biologis sisa sayuran dapur rumah tangga.',
                'benefits' => ['Kaya unsur hara makro & mikro', 'Menyuburkan struktur tanah berkebun', 'Aman untuk tanaman sayur & buah'],
                'stock' => 60,
                'is_available' => true,
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1585314062340-f1a5a7c9328d?q=80&w=800&auto=format&fit=crop', 'is_primary' => true, 'sort_order' => 1]
                ]
            ],
            [
                'title' => 'Pot Tanaman Daur Ulang Galon Plastik',
                'slug' => 'pot-tanaman-daur-ulang-galon-plastik',
                'category_id' => $catDaurUlang?->id,
                'contact_id' => $picRina?->id ?? $picAdmin?->id,
                'price' => 12000,
                'price_text' => 'Rp 12.000',
                'description' => 'Pot tanaman hias cantik berbahan galon sekali pakai yang dilukis motif estetis oleh remaja pecinta lingkungan.',
                'benefits' => ['Tahan cuaca panas & hujan', 'Dilengkapi lubang drainase air yang pas', 'Tersedia berbagai pilihan lukisan warna'],
                'stock' => 30,
                'is_available' => true,
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?q=80&w=800&auto=format&fit=crop', 'is_primary' => true, 'sort_order' => 1]
                ]
            ]
        ];

        foreach ($productsData as $pData) {
            $images = $pData['images'];
            unset($pData['images']);

            $product = Product::updateOrCreate(['slug' => $pData['slug']], $pData);

            // Re-sync product images
            $product->images()->delete();
            foreach ($images as $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $img['url'],
                    'is_primary' => $img['is_primary'],
                    'sort_order' => $img['sort_order'],
                ]);
            }
        }
    }
}
