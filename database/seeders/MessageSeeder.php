<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@gmail.com',
                'phone' => '081234567891',
                'subject' => 'Pertanyaan Pemesanan Sabun Jelantah Skala Grosir',
                'message' => 'Halo Admin BIL, kami dari warung makan lokal tertarik memesan sabun jelantah jumlah 50 pcs untuk pembersih noda dapur. Mohon informasi harga grosirnya.',
                'status' => 'unread',
            ],
            [
                'name' => 'Dewi Anggraini',
                'email' => 'dewi.anggraini@yahoo.com',
                'phone' => '085712348899',
                'subject' => 'Permohonan Edukasi Pemilahan Sampah Sekolah',
                'message' => 'Selamat siang, kami ingin mengundang tim Bank Sampah BIL untuk menjadi narasumber edukasi lingkungan di sekolah kami pada bulan depan.',
                'status' => 'read',
            ]
        ];

        foreach ($messages as $m) {
            Message::create($m);
        }
    }
}
