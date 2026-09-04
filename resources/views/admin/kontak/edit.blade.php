@extends('layouts.admin')

@section('title', 'Edit Kontak PIC — Admin')

@section('page-heading', 'Edit Kontak PIC')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-4">
        <p class="text-xs text-[#6b6150]">Perbarui informasi kontak PIC, nomor WhatsApp, peran/jabatan, dan status ketersediaan kontak.</p>
        <a href="{{ route('admin.kontak') }}" class="px-4 py-2 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors shrink-0">
            ← Kembali ke Kontak
        </a>
    </div>

    @if ($errors->any())
        <div class="px-4 py-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-800 flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.kontak.update', $contact->id) }}">
        @csrf
        @method('PUT')

        <!-- 2-COLUMN LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT COLUMN: Main Information (lg:col-span-8) -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-5">
                    <h3 class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3">Informasi Utama Kontak PIC</h3>

                    <!-- Nama Lengkap PIC -->
                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Nama Lengkap PIC <span class="text-rose-600">*</span></label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $contact->name) }}" 
                               required 
                               placeholder="misal: Atin Indriawati, S.Pi"
                               class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nomor HP / WA -->
                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Nomor HP / WhatsApp <span class="text-rose-600">*</span></label>
                            <div class="relative">
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone', $contact->phone) }}" 
                                       required 
                                       placeholder="08112442322"
                                       class="w-full pl-9 pr-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs font-mono" />
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs">📞</span>
                            </div>
                        </div>

                        <!-- Peran / Jabatan -->
                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Peran / Jabatan</label>
                            <input type="text" 
                                   name="role" 
                                   value="{{ old('role', $contact->role) }}" 
                                   placeholder="misal: Ketua Komunitas / Admin WA"
                                   class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Alamat Email (opsional)</label>
                        <div class="relative">
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $contact->email) }}" 
                                   placeholder="misal: admin@bumi-indramayu.org"
                                   class="w-full pl-9 pr-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs">✉️</span>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Alamat Kantor / Tempat Tugas</label>
                        <textarea name="address" 
                                  rows="3" 
                                  placeholder="misal: Ruko Komplek Masjid Abdurrahman Basuri, Jl. MT Haryono, Sindang – Indramayu"
                                  class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs">{{ old('address', $contact->address) }}</textarea>
                    </div>

                </div>

            </div>

            <!-- RIGHT COLUMN: Side Settings & Actions (lg:col-span-4) -->
            <div class="lg:col-span-4 space-y-6">

                <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 shadow-sm space-y-5">
                    <h3 class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3">Status & Tipe Kontak</h3>

                    <!-- Status Aktif (Toggle Switch) -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#2c3821] block">Status Aktif</label>
                        
                        <div class="flex items-center justify-between p-3.5 bg-white rounded-2xl border border-[#2b2417]/14 shadow-2xs">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-[#2c3821] block">Aktif Layanan</span>
                                <span class="text-[10px] text-[#6b6150] block">Tampilkan di pilihan pemesanan WA</span>
                            </div>

                            <!-- Modern Toggle Switch -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       id="is_active_toggle" 
                                       {{ old('is_active', $contact->is_active) ? 'checked' : '' }} 
                                       class="sr-only peer" />
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#059669]"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Status Utama (Toggle Switch) -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#2c3821] block">Prioritas Kontak</label>
                        
                        <div class="flex items-center justify-between p-3.5 bg-white rounded-2xl border border-[#2b2417]/14 shadow-2xs">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-[#2c3821] block">Kontak Utama</span>
                                <span class="text-[10px] text-[#6b6150] block">Dipilih pertama saat pemesanan</span>
                            </div>

                            <!-- Modern Toggle Switch -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_primary" 
                                       value="1" 
                                       id="is_primary_toggle" 
                                       {{ old('is_primary', $contact->is_primary) ? 'checked' : '' }} 
                                       class="sr-only peer" />
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#c1852c]"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 border-t border-[#2b2417]/10 space-y-2.5">
                        <button type="submit" class="w-full py-3.5 px-5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-md cursor-pointer flex items-center justify-center gap-2">
                            <span>💾</span>
                            <span>Simpan Perubahan</span>
                        </button>
                        <a href="{{ route('admin.kontak') }}" class="w-full py-3 px-5 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors text-center block">
                            Batal
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </form>
</div>
@endsection

