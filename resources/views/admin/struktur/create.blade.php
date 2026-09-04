@extends('layouts.admin')

@section('title', 'Tambah Struktur — Admin')

@section('page-heading', 'Tambah Struktur Organisasi')

@section('content')
    <div class="max-w-full mx-auto space-y-6">

        <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-4">
            <p class="text-xs text-[#6b6150]">Isi rincian pengurus inti atau divisi untuk halaman beranda.</p>
            <a href="{{ route('admin.struktur') }}" class="px-4 py-2 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors shrink-0">
                ← Kembali ke Struktur
            </a>
        </div>

        @if ($errors->any())
            <div class="px-4 py-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-800 flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.struktur.store') }}">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-5">
                        <h3 class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3 flex items-center gap-2">
                            <span>👥</span>
                            <span>Detail Struktur</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div class="grid gap-1.5">
                                <label class="text-xs font-bold text-[#2c3821]">Tipe <span class="text-rose-600">*</span></label>
                                <select name="tipe" required class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs">
                                    <option value="inti" @selected(old('tipe') === 'inti')>Pengurus Inti</option>
                                    <option value="divisi" @selected(old('tipe') === 'divisi')>Divisi</option>
                                </select>
                            </div>

                            <div class="grid gap-1.5">
                                <label class="text-xs font-bold text-[#2c3821]">Badge Warna</label>
                                <select name="badge" class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs">
                                    <option value="moss" @selected(old('badge', 'moss') === 'moss')>Moss (hijau)</option>
                                    <option value="ochre" @selected(old('badge') === 'ochre')>Ochre (oranye)</option>
                                </select>
                            </div>

                            <div class="grid gap-1.5">
                                <label class="text-xs font-bold text-[#2c3821]">Urutan (sort order)</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                    class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                            </div>
                        </div>

                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Nama <span class="text-rose-600">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Untuk divisi, isi nama divisinya"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                        </div>

                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Jabatan <span class="text-[#6b6150] font-medium">(hanya pengurus inti)</span></label>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="misal: Ketua Komunitas"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                        </div>

                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat peran/divisi"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Anggota <span class="text-[#6b6150] font-medium">(hanya divisi)</span></label>
                            <input type="text" name="anggota" value="{{ old('anggota') }}" placeholder="misal: Atin Indriawati & Ine Nuraini"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 shadow-sm space-y-5">
                        <h3 class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3">Aksi Simpan</h3>
                        <p class="text-xs text-[#6b6150]">Pastikan tipe dan nama sudah benar sebelum menyimpan.</p>
                        <div class="pt-4 border-t border-[#2b2417]/10 space-y-2.5">
                            <button type="submit" class="w-full py-3.5 px-5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-md cursor-pointer flex items-center justify-center gap-2">
                                <span>💾</span>
                                <span>Simpan Struktur</span>
                            </button>
                            <a href="{{ route('admin.struktur') }}" class="w-full py-3 px-5 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors text-center block">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
