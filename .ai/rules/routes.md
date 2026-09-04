---
paths:
  - 'routes/**'
  - routes/web.php
---

# Routes

## Blade directly, no Inertia anywhere
All routes render server-side Blade via `view('pages.*')`, `view('admin.*')`, `view('settings.*')`, `view('auth.*')`, or `view('landing')`. Never use `Inertia::render`/`Route::inertia` — this app is fully server-rendered (see vite.config.ts rule for why). Public pages extend `layouts.public`; admin/settings extend `layouts.admin`; auth extends `layouts.auth`. Fortify provides auth logic; custom views live in resources/views/auth.

## Landing content is from DB (not hardcoded)
Landing page content (visi & misi, struktur organisasi, program kerja) is DB-driven, NOT hardcoded. Tables: `visi_misi` (tipe: visi|misi, label, judul, deskripsi, sort_order), `struktur_organisasi` (tipe: inti|divisi, nama, jabatan, deskripsi, anggota, badge, sort_order), `program_kerja` (nama, kategori: pendidikan|ekonomi|humas, sort_order). The `/` route passes `visi`, `misi`, `pengurusInti`, `pengurusDivisi`, `programPendidikan/Ekonomi/Humas` collections to `landing.blade.php`. Seed via `LandingContentSeeder` (delete+recreate). Models: VisiMisi/StrukturOrganisasi/ProgramKerja with explicit $table and scopes (visi/misi, inti/divisi, kategori).
