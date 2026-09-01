<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Layanan Utama BIL',
                'phone' => '628112442322',
                'role' => 'Customer Service & Admin Utama',
                'email' => 'admin@bumi-indramayu.id',
                'address' => 'Jl. Raya Indramayu No. 45, Indramayu',
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Ibu Siti Khadijah',
                'phone' => '6281234567890',
                'role' => 'PIC Produk Sabun & Olahan Jelantah',
                'email' => 'siti@bumi-indramayu.id',
                'address' => 'Kelompok Perempuan Karangampel',
                'is_primary' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Pak Budi Santoso',
                'phone' => '6281987654321',
                'role' => 'PIC Pupuk Kompos & Eco-Enzyme Organik',
                'email' => 'budi@bumi-indramayu.id',
                'address' => 'Unit Pengolahan Organik Desa',
                'is_primary' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Mbak Rina Wati',
                'phone' => '6285712345678',
                'role' => 'PIC Kerajinan Ecobrick & Perca',
                'email' => 'rina@bumi-indramayu.id',
                'address' => 'Sanggar Daur Ulang Pemuda',
                'is_primary' => false,
                'is_active' => true,
            ]
        ];

        foreach ($contacts as $c) {
            Contact::updateOrCreate(['phone' => $c['phone']], $c);
        }
    }
}
