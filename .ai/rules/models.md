---
paths:
  - 'app/Models/**'
---

# Models

## Indonesian table names need explicit $table
Indonesian table names do NOT follow Laravel's automatic pluralization (e.g. model `Binaan` would infer table `binaans`). Whenever a model maps to an Indonesian-named table (`binaan`, `pengurusan_binaan`, `kontak_binaan`, `kategori`, etc.), set `protected $table = '...'` explicitly. The `binaan` schema: table `binaan` (nama, alamat, berdiri_sejak) hasMany `pengurusan_binaan` (binaan_id, nama, jabatan) and `kontak_binaan` (binaan_id, nama, whatsapp), both FK cascadeOnDelete. Managed by App\Http\Controllers\Admin\BinaanController (syncs nested arrays by delete+recreate).
