# Design System — Halaman Login Bumi Indramayu Lestari

Dokumen ini mendokumentasikan desain UI halaman login (`http://localhost:8000/login`), yang mengadopsi tema dari landing page "Bumi Indramayu Lestari". Tema bernuansa **eco / natural / earthy** dengan aksen hijau moss dan krem.

---

## 1. Konsep Layout — Split Screen (2 Kolom)

Halaman login terbagi menjadi 2 kolom pada layar besar (`lg`, ≥ 1024px):

| Kolom | Isi |
|-------|-----|
| **Kolom Kiri (image + text)** | Brand, ilustrasi/gambar daun, teks moto, teks tagline komunitas — berlatar gradasi hijau |
| **Kolom Kanan (form)** | Judul, deskripsi, dan form login — berlatar warna krem |

Pada layar kecil / mobile, kolom kiri disembunyikan (`hidden lg:flex`) dan hanya form yang tampil.

---

## 2. Warna (Color Palette)

### 2.1 Warna Tema Landing (warna dasar desain)

| Token | Hex | Penggunaan |
|-------|-----|-----------|
| `--cream` | `#f6f1e2` | Background utama halaman |
| `--paper` | `#fbf8ef` | Card / panel / latar lembut |
| `--ink` | `#2b2417` | Warna teks utama (cokelat gelap) |
| `--moss-dark` | `#2c3821` | Gradasi hijau gelap, aksen, heading |
| `--moss` | `#4c5c31` | Hijau utama / logo |
| `--moss-light` | `#93a869` | Aksen hijau terang (teks kecil) |
| `--ochre` | `#c1852c` | Aksen oker / tombol CTA |
| `--ochre-light` | `#e9c688` | Sorotan (highlight) oker muda |
| `--line` | `rgba(43,36,23,0.16)` | Garis border tipis |

### 2.2 Warna pada Halaman Login

| Elemen | Hex / Value | Keterangan |
|--------|-------------|-----------|
| Background kolom kanan (form) | `#f6f1e2` (cream) | `background-color` dari kolom form |
| Background kolom kiri | `linear-gradient(160deg, #4c5c31 0%, #2c3821 100%)` | Gradasi hijau moss → moss-dark |
| Warna teks putih (kolom kiri) | `#ffffff` | Brand, moto, tagline (dengan opacity 70% untuk teks sekunder) |
| Warna judul form (`h1`) | `#2c3821` (moss-dark) | Judul "Log in to your account" |
| Warna deskripsi form | `#5a5040` | Teks sekunder cokelat abu |
| Warna teks gambar daun (opacity) | `opacity: 10%` | Watermark ilustrasi daun pada kolom kiri |

---

## 3. Tipografi (Font)

| Peran | Font | Berat (weight) |
|-------|------|----------------|
| Judul / Heading / Brand | **Fraunces** (serif) | 400, 500, 600 |
| Body / Form / Teks umum | **Work Sans** (sans-serif) | 400, 500, 600, 700 |

- **Fraunces** dipakai untuk elemen display: brand, judul, dan blockquote moto — memberi kesan anggun / natural.
- **Work Sans** dipakai untuk teks form, label, tombol, dan konten umum — bersih dan mudah dibaca.
- Google Fonts diimport via `<link>`:
  `https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&family=Work+Sans:wght@400;500;600;700&display=swap`

### Ukuran (pada login)
- Brand: `text-lg`, medium
- Moto (kolom kiri): `text-2xl`, medium, `leading-relaxed`
- Tagline (kolom kiri): `text-sm`, opacity 70%
- Judul form: `text-xl`, medium
- Deskripsi form: `text-sm`

---

## 4. Kartu / Card & Komponen Form

### 4.1 Tombol (Button)
Komponen dari `@/components/ui/button` (Tailwind shadcn-style).

| Properti | Nilai |
|----------|-------|
| Tinggi | `h-9` |
| Radius | `rounded-md` |
| Lebar login | `w-full` (tombol "Log in" memenuhi lebar form) |
| Padding | `px-3 py-1` |
| Border | `border-input` |
| State fokus | `focus-visible:ring-3 ring-ring/50` |
| Saat loading | menampilkan `<Spinner />` dan `disabled` |

### 4.2 Input (Input)
Komponen dari `@/components/ui/input`.
- Tinggi `h-9`, radius `rounded-md`, border `border-input`
- `placeholder` warna `muted-foreground`
- Saat error (`aria-invalid`): border berubah `destructive`

### 4.3 Password
Menggunakan `PasswordInput` (komponen input password dengan tombol toggle tampilkan/sembunyikan).

### 4.4 Checkbox "Remember me"
Komponen dari `@/components/ui/checkbox` — kotak centang standar tema.

### 4.5 Label
Komponen `Label` dari `@/components/ui/label`.

### 4.6 Link (TextLink)
Komponen `TextLink` dipakai untuk:
- "Forgot your password?" (atas field password)
- "Sign up" (bawah form)

---

## 5. Struktur Form

Urutan elemen dalam form login:

1. **Judul** — "Log in to your account" (Fraunces, moss-dark)
2. **Deskripsi** — "Enter your email and password below to log in"
3. **Passkey** — tombol "Sign in with a passkey" (opsional, jika browser mendukung WebAuthn) + separator "Or continue with email"
4. **Field Email** — label "Email address", input email, placeholder `email@example.com`
5. **Field Password** — label "Password" + link "Forgot your password?", input password
6. **Remember me** — checkbox
7. **Tombol Log in** — full width, dengan spinner saat process
8. **Footer** — "Don't have an account? Sign up"

---

## 6. Layout & Spacing

- Grid: `grid-cols-2` pada layar `lg` (2 kolom equal)
- Kolom kiri: `p-10`, teks putih, `hidden lg:flex`
- Kolom kanan: `lg:p-8`, berisi kontainer `sm:w-[350px]`, `mx-auto`
- Spasi antar elemen form: `gap-6` (antara blok), `gap-2` (label-field)
- Halaman penuh: `h-dvh`

---

## 7. Elemen Khas Tema (Kolom Kiri)

- **Brand/Logo**: logo daun + nama aplikasi, bertekstur Fraunces, warna putih.
- **Ilustrasi Daun**: SVG daun (`M4 20c8-1 12-7 12-15...`) sebagai watermark besar di pojok, opacity 10%.
- **Moto**: blockquote *"Berkontribusi memberi solusi untuk bumi lestari."* (Fraunces).
- **Tagline**: "Komunitas peduli lingkungan · Kabupaten Indramayu" (putih 70%).

---

## 8. Komponen Landing Page (Rounded Corners)

Berikut komponen pada landing page (`http://localhost:8000/`) beserta nilai sudut membulatnya (`border-radius`):

| Komponen | Kelas CSS | Radius | Elemen |
|----------|-----------|--------|--------|
| Tombol "Hubungi Kami" (nav) | `.nav-cta` | `20px` | Tombol CTA pada navigasi atas |
| Card Struktur Kepengurusan | `.org-card` | `12px` | Kartu struktur (Konsultan, Ketua, Sekretaris, Bendahara, Divisi) |
| Card Katalog Produk | `.produk-card` | `12px` | Kartu produk (Sabun, Ecobrick, Bantal Jarum) |

> Catatan: Sebelumnya elemen-elemen ini memakai `border-radius: 2px` (nyaris persegi). Untuk memperhalus tampilan, nilai diubah menjadi membulat — tombol nav menjadi pil (`20px`), sedangkan card struktur & produk menjadi `12px`. Semua perubahan ada di `resources/views/landing.blade.php`.

Elemen lain dengan sudut membulat pada landing:
- Tombol `btn`/`btn-primary`/`btn-outline` → `var(--radius)` (`3px`)
- Kotak centang program (`.pill`) → `20px` (pil)
- Tombol tab (`.tab-btn`) → `20px` (pil)
- Tag produk (`.produk-tag`) → `12px` (pil kecil)
- Foto hero (`hero-photo`) → `clip-path` sudut miring + `radius 2px`
- Kotak tag hero (`hero-tag`) → `2px`

---

## 9. Catatan Implementasi (Referensi File)

- `resources/js/layouts/auth/AuthSplitLayout.vue` — layout 2 kolom login.
- `resources/js/layouts/AuthLayout.vue` — pembungkus auth yang memakai `AuthSplitLayout`.
- `resources/js/pages/auth/Login.vue` — konten form login.
- `resources/css/app.css` — CSS variable tema global (Tailwind).
- `resources/views/landing.blade.php` — halaman landing (Blade) yang terisi komponen rounded.
- `bumil-landing-contoh.html` — sumber tema warna, font, dan gaya landing.
