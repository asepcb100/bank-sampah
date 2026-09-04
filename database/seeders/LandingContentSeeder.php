<?php

namespace Database\Seeders;

use App\Models\ProgramKerja;
use App\Models\StrukturOrganisasi;
use App\Models\VisiMisi;
use Illuminate\Database\Seeder;

class LandingContentSeeder extends Seeder
{
    /**
     * Seed the landing page content (visi & misi, struktur, program kerja).
     */
    public function run(): void
    {
        // ---------------- VISI & MISI ----------------
        VisiMisi::query()->delete();

        foreach ([
            ['tipe' => 'visi', 'label' => 'Visi Lingkungan', 'judul' => 'Bumi Bersih & Lestari', 'deskripsi' => 'Mewujudkan komunitas yang berkontribusi bagi terciptanya lingkungan hidup yang bersih, sehat, dan lestari.', 'sort_order' => 1],
            ['tipe' => 'visi', 'label' => 'Visi Ekonomi', 'judul' => 'Ekonomi Berdaya', 'deskripsi' => 'Mengembangkan peran komunitas dalam pemberdayaan ekonomi masyarakat berbasis sampah.', 'sort_order' => 2],
            ['tipe' => 'misi', 'label' => 'Misi Edukasi', 'judul' => 'Sustainable Living', 'deskripsi' => 'Memberikan edukasi praktis kepada masyarakat tentang pemilahan dan pengolahan sampah dari rumah.', 'sort_order' => 3],
            ['tipe' => 'misi', 'label' => 'Misi Ekonomi', 'judul' => 'Sampah Jadi Berkah', 'deskripsi' => 'Pemberdayaan ekonomi lewat Bank Sampah, sedekah jelantah, dan kerajinan kreatif produk olahan.', 'sort_order' => 4],
        ] as $item) {
            VisiMisi::create($item);
        }

        // ---------------- STRUKTUR ORGANISASI ----------------
        StrukturOrganisasi::query()->delete();

        foreach ([
            ['tipe' => 'inti', 'nama' => 'Titan Listiani, S.Si., MMG., MT., Ph.D', 'jabatan' => 'Pembina / Konsultan', 'deskripsi' => 'Konsultan Visi Strategis & Dosen Pendamping Komunitas.', 'badge' => 'moss', 'sort_order' => 1],
            ['tipe' => 'inti', 'nama' => 'Atin Indriawati, S.Pi', 'jabatan' => 'Ketua Komunitas', 'deskripsi' => 'Koordinator Utama Pelaksanaan Program & Bank Sampah.', 'badge' => 'ochre', 'sort_order' => 2],
            ['tipe' => 'inti', 'nama' => 'Ine Nuraini, S.T', 'jabatan' => 'Sekretaris', 'deskripsi' => 'Pengelola Administrasi, Kemitraan & Informasi Komunitas.', 'badge' => 'moss', 'sort_order' => 3],
            ['tipe' => 'inti', 'nama' => 'Ayu Amanah, S.Pd', 'jabatan' => 'Bendahara', 'deskripsi' => 'Manajemen Kas Komunitas & Operasional Bank Sampah.', 'badge' => 'moss', 'sort_order' => 4],
            ['tipe' => 'divisi', 'nama' => 'Divisi Pendidikan & Pelatihan', 'deskripsi' => 'Menyusun kurikulum sosialisasi 3R, edukasi pemilahan sampah di RT/RW dan sekolah, serta workshop daur ulang.', 'anggota' => 'Atin Indriawati, S.Pi & Ine Nuraini, S.T', 'badge' => 'moss', 'sort_order' => 1],
            ['tipe' => 'divisi', 'nama' => 'Divisi Pemberdayaan Ekonomi', 'deskripsi' => 'Mengelola sedekah sampah anorganik, penimbangan bulanan, pengolahan minyak jelantah, dan produk kreasi.', 'anggota' => 'Diannopi & Ayu Amanah, S.Pd', 'badge' => 'moss', 'sort_order' => 2],
            ['tipe' => 'divisi', 'nama' => 'Divisi Humas & Media', 'deskripsi' => 'Membangun kolaborasi bersama instansi, desa, perguruan tinggi/KKN, serta publikasi media sosial.', 'anggota' => 'Rina Safitri, S.Pd', 'badge' => 'moss', 'sort_order' => 3],
        ] as $item) {
            StrukturOrganisasi::create($item);
        }

        // ---------------- PROGRAM KERJA ----------------
        ProgramKerja::query()->delete();

        foreach ([
            'pendidikan' => ['Zero Waste', 'Komposting', 'EcoEnzym', 'Sedekah Sampah', 'Bank Sampah', 'Ecobrick', 'Sabun Minyak Jelantah', 'Berkebun Organik', 'Menanam Pohon'],
            'ekonomi' => ['Produk Kreatif Plastik Kemasan', 'Bank Sampah & Sedekah Sampah', 'Sabun & Sedekah Minyak Jelantah', 'Ecobrick & Eco-Enzyme', 'Kompos Organik', 'Kertas Daur Ulang', 'Kreasi Limbah Kain Perca'],
            'humas' => ['Komunikasi & Kemitraan Strategis', 'Pengelolaan Akun Media Sosial', 'Sebar Program via Flyer & Pamflet', 'Dokumentasi Kegiatan Warga', 'Fasilitasi Kegiatan Online & KKN'],
        ] as $kategori => $programs) {
            foreach ($programs as $i => $nama) {
                ProgramKerja::create([
                    'nama' => $nama,
                    'kategori' => $kategori,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
