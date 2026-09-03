<div align="center">

# 🌿 Bumi Indramayu Lestari

**Platform Profil Komunitas & Ekonomi Sirkular**
*Kabupaten Indramayu · Komunitas Peduli Lingkungan*

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white&style=for-the-badge)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3-4FC08D?logo=vue.js&logoColor=white&style=for-the-badge)](https://vuejs.org)
[![Inertia](https://img.shields.io/badge/Inertia.js-3-4F46E5?logo=inertia&style=for-the-badge)](https://inertiajs.com)
[![Tailwind](https://img.shields.io/badge/Tailwind-4-06B6D4?logo=tailwindcss&logoColor=white&style=for-the-badge)](https://tailwindcss.com)

> _"Berkontribusi memberi solusi untuk bumi lestari."_

</div>

---

## 📖 Tentang Proyek

**Bumi Indramayu Lestari** adalah aplikasi web profil komunitas peduli lingkungan yang beraktivitas di Kabupaten Indramayu. Melalui aplikasi ini, komunitas mempresentasikan visi, program kerja, struktur organisasi, galeri kegiatan, hingga produk ekonomi sirkular — dari minyak jelantah, sampah anorganik, sampai kain perca.

Dibangun di atas fondasi **Laravel + Inertia + Vue 3** dengan identitas visual **eco / natural / earthy** — hijau moss dan krem yang hangat.

---

## 🚀 Fitur Unggulan

### 🏠 Landing Page
| Fitur | Deskripsi |
|-------|-----------|
| Hero Pengantar | Branding & tagline komunitas |
| Latar Belakang | Alasan komunitas berdiri |
| Visi & Misi | Arah lingkungan & ekonomi |
| Struktur Organisasi | Card kepengurusan yang rapi |
| Program Kerja | Tabs interaktif (Pendidikan, Ekonomi, Humas) |
| **Galeri dengan Lightbox** | *Klik untuk zoom* — tutup via × / klik luar / `Esc` |
| Katalog Produk | Card produk ekonomi sirkular |
| Kontak | Info kantor & media sosial |

### 🔐 Autentikasi Modern
- Login, Register, dan Reset Password
- Verifikasi Email & Two-Factor Authentication (2FA)
- **Passkey / WebAuthn** untuk masuk tanpa password
- **Login Split-Screen** — kolom kiri (gambar + teks bertema) & kolom kanan (form)

---

## 🛠 Teknologi

| Lapisan | Teknologi |
|---------|-----------|
| **Backend** | PHP 8.3+, Laravel 13 |
| **Autentikasi** | Laravel Fortify + Passkeys |
| **Frontend** | Vue 3, Inertia.js |
| **Styling** | Tailwind CSS 4, reka-ui (shadcn-style) |
| **Database** | MySQL |
| **Build Tool** | Vite 8, vite-plus |

---

## 🗂 Arsitektur Data (Model)

Website ini dirancang sebagai **CMS portal komunitas** — konten produk, galeri, kontak, dan pesan dikelola dari database. Berikut pemetaan modelnya:

```
┌──────────────────────────────────────────────────────────────────┐
│                         Category (Kategori)                        │
│  name · slug · type (pembeda Produk vs Galeri) · description       │
└───────┬──────────────────────────────┬────────────────────────────┘
        │                              │
   ┌────▼─────┐                  ┌─────▼─────┐      ┌───────────────┐
   │ Product  │ (belongsTo)      │  Gallery  │      │    User       │
   │ ──► Category               │ ──► Category│     │ (admin/auth)  │
   └────┬──────┘                  └─────┬─────┘      └───────────────┘
        │                               │
   ┌────▼──────┐                  ┌─────▼────────┐
   │ProductImage│ 1—*            │GalleryImage   │ 1—*
   │(foto produk)│             │(foto kegiatan) │
   └───────────┘                  └──────────────┘
        │ (belongsTo)
   ┌────▼─────┐
   │ Contact  │  PIC / kontak pemesanan (WA)
   └──────────┘

   ┌──────────┐
   │ Message  │  Pesan dari form kontak pengunjung (db)
   └──────────┘
```

| Model | Kriteria Penting | Relasi |
|-------|------------------|--------|
| **Category** | `type` membedakan kategori Produk vs Galeri | → products, galleries |
| **Product** | `price` (decimal), `price_text`, `benefits[]`, `stock`, `is_available` | → category, contact, images |
| **ProductImage** | `is_primary`, `sort_order` (multi foto) | belongsTo Product |
| **Gallery** | `location`, `event_date`, `is_published` | → category, images |
| **GalleryImage** | `caption`, `sort_order` | belongsTo Gallery |
| **Contact** | `is_primary`, `is_active` (PIC pemesanan) | → products |
| **Message** | `name`, `email`, `phone`, `subject`, `message`, `status` | — |
| **User** | 2FA + passkey (WebAuthn) | — |

> 📝 *Saat ini landing page (`landing.blade.php`) masih statis. Model-model di atas adalah fondasi untuk mengubahnya menjadi versi dinamis berbasis database dan halaman admin/kelola konten.*

---

## 🧰 Persyaratan Sistem

- ✅ **PHP** ≥ 8.3
- ✅ **Composer**
- ✅ **Node.js** & **npm** (LTS)
- ✅ **MySQL** (atau SQLite)

---

## ⚙️ Instalasi

### 1. Clone & Install Dependensi

```bash
# Install dependensi PHP
composer install

# Siapkan environment
cp .env.example .env
php artisan key:generate
```

### 2. Konfigurasi Database

Edit `.env` lalu jalankan migrasi:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bumil
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate
```

### 3. Install Dependensi Frontend

```bash
npm install
```

---

## ▶️ Menjalankan

Buka **dua terminal** secara paralel:

**Terminal 1 — Server Backend**
```bash
php artisan serve --port=8000
```

**Terminal 2 — Vite Dev Server**
```bash
npm run dev
```

🌐 Akses aplikasi: **http://localhost:8000**

### Build Produksi

```bash
npm run build
```

---

## 📂 Struktur Proyek

```
resources/
├── views/
│   └── landing.blade.php          # Halaman landing (UI lengkap)
├── js/
│   ├── pages/auth/Login.vue       # Halaman login
│   ├── layouts/
│   │   ├── AuthLayout.vue         # Pembungkus auth
│   │   └── auth/AuthSplitLayout.vue # Layout login 2 kolom (tema landing)
│   └── components/                # Komponen UI (button, input, dll.)
├── css/
│   └── app.css                    # CSS variable tema global

routes/
└── web.php                        # Route utama (landing + dashboard)

design.md                          # Dokumentasi desain sistem
bumil-landing-contoh.html          # Referensi desain awal
```

---

## 🎨 Identitas Desain

| Aspek | Nilai |
|-------|-------|
| **Font Judul / Brand** | `Fraunces` (serif) |
| **Font Body / Form** | `Work Sans` (sans-serif) |
| **Warna Utama** | Cream `#f6f1e2` · Moss `#4c5c31` · Moss-Dark `#2c3821` · Ochre `#c1852c` |
| **Tombol Nav** | Rounded `20px` |
| **Card Struktur & Produk** | Rounded `12px` |
| **Card Galeri** | Rounded `12px` + Lightbox |

📐 Konsep desain lengkap tersedia di **`design.md`**.

---

## ✅ Kualitas & Testing

| Perintah | Fungsi |
|----------|--------|
| `composer lint` | Lint gaya kode (Laravel Pint) |
| `composer types:check` | Analisis tipe (PHPStan) |
| `npm run types:check` | Cek tipe (vue-tsc) |
| `composer test` | Jalankan test (Pest) |
| `php artisan app:generate-icons` | Generate ulang PWA icons & favicons dari `logo.png` |

### 🖼️ Update Logo & PWA Icons

Saat logo utama (`public/img/logo.png`) berubah, jalankan:

```bash
php artisan app:generate-icons
```

Command ini akan generate **7 file** secara otomatis:

| File | Kegunaan |
|------|----------|
| `icon-192x192.png` | PWA icon (home screen) |
| `icon-512x512.png` | PWA icon (splash screen) |
| `apple-touch-icon.png` | Apple touch icon |
| `favicon-180x180.png` | Apple touch icon (fallback) |
| `favicon-32x32.png` | Favicon browser |
| `favicon-16x16.png` | Favicon browser |
| `favicon.ico` | Multi-size ICO (16, 32, 48) |

Custom source: `php artisan app:generate-icons --source=path/to/custom-logo.png`

---

## 🤝 Kontribusi

Kami sangat menghargai kontribusi Anda! Silakan buat *fork*, ajukan *issue*, atau kirim *pull request* untuk membantu pengembangan proyek ini menjadi lebih baik.

---

## 📧 Hubungi Developer

Dikembangkan dengan ❤️ oleh

<table>
  <tr>
    <td align="center">
      <strong>Baraka IT Digital</strong><br/>
      <a href="mailto:asepcb100@gmail.com">asepcb100@gmail.com</a>
    </td>
  </tr>
</table>

Jangan ragu untuk menghubungi kami terkait pertanyaan, kolaborasi, atau penawaran pengembangan aplikasi web.

---

## 📄 Lisensi

Proyek ini berbasis **Laravel Vue Starter Kit** dan dirilis di bawah lisensi **MIT**. Lihat `composer.json` untuk detail.

<br/>

<div align="center">

**© 2026 Bumi Indramayu Lestari** · *Berkontribusi memberi solusi untuk bumi lestari*

</div>
