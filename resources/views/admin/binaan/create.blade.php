@extends('layouts.admin')

@section('title', 'Tambah Kelompok Binaan — Admin')

@section('page-heading', 'Tambah Kelompok Binaan')

@section('content')
    <div class="max-w-full mx-auto space-y-6">

        <!-- Top Action Bar -->
        <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-4">
            <p class="text-xs text-[#6b6150]">Isi rincian nama kelompok binaan, alamat, tanggal berdiri, pengurus, dan kontak
                WhatsApp.</p>
            <a href="{{ route('admin.binaan') }}"
                class="px-4 py-2 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors shrink-0">
                ← Kembali ke Binaan
            </a>
        </div>

        @if ($errors->any())
            <div
                class="px-4 py-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-800 flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.binaan.store') }}">
            @csrf

            <!-- 2-COLUMN LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN: Main Form Sections (lg:col-span-8) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- CARD 1: Data Dasar Binaan -->
                    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-5">
                        <h3
                            class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3 flex items-center gap-2">
                            <span>🏛️</span>
                            <span>Data Dasar Kelompok Binaan</span>
                        </h3>

                        <!-- Nama Binaan -->
                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Nama Kelompok Binaan <span
                                    class="text-rose-600">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                placeholder="misal: Bank Sampah Resik Sejahtera Desa Sindang"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                        </div>

                        <!-- Alamat -->
                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Alamat Lengkap / Lokasi</label>
                            <textarea name="alamat" rows="2" placeholder="misal: RT 04 / RW 02, Desa Sindang, Kec. Sindang – Indramayu"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs">{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Tanggal Berdiri -->
                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Berdiri Sejak</label>
                            <input type="date" name="berdiri_sejak" value="{{ old('berdiri_sejak') }}"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                        </div>
                    </div>

                    <!-- CARD 2: Pengurusan Binaan -->
                    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-5">
                        <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3">
                            <div>
                                <h3 class="font-fraunces font-bold text-lg text-[#2c3821] flex items-center gap-2">
                                    <span>👥</span>
                                    <span>Pengurusan Binaan</span>
                                </h3>
                                <p class="text-[11px] text-[#6b6150]">Pengurus / pengelola struktur binaan</p>
                            </div>
                            <button type="button" onclick="addPengurusanRow()"
                                class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#2c3821] text-[#fbf8ef] hover:bg-[#4c5c31] transition-colors cursor-pointer flex items-center gap-1">
                                <span>+</span>
                                <span>Tambah Pengurus</span>
                            </button>
                        </div>

                        <div id="pengurusan-rows" class="space-y-3">
                            <div
                                class="flex flex-col sm:flex-row gap-3 items-start pengurusan-row bg-white p-3.5 rounded-2xl border border-[#2b2417]/14 shadow-2xs">
                                <div class="flex-1 w-full grid gap-1">
                                    <label class="text-[10px] font-bold text-[#6b6150]">Nama Pengurus</label>
                                    <input type="text" name="pengurusan[0][nama]" placeholder="Nama pengurus"
                                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
                                </div>
                                <div class="flex-1 w-full grid gap-1">
                                    <label class="text-[10px] font-bold text-[#6b6150]">Jabatan / Peran</label>
                                    <input type="text" name="pengurusan[0][jabatan]"
                                        placeholder="Ketua / Sekretaris / Bendahara"
                                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
                                </div>
                                <button type="button" onclick="removeRow(this)"
                                    class="sm:mt-5 px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-700 hover:bg-rose-100 transition-colors shrink-0">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3: Kontak Binaan -->
                    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-5">
                        <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3">
                            <div>
                                <h3 class="font-fraunces font-bold text-lg text-[#2c3821] flex items-center gap-2">
                                    <span>📞</span>
                                    <span>Kontak WhatsApp Binaan</span>
                                </h3>
                                <p class="text-[11px] text-[#6b6150]">Kontak telepon / WhatsApp untuk koordinasi</p>
                            </div>
                            <button type="button" onclick="addKontakRow()"
                                class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#2c3821] text-[#fbf8ef] hover:bg-[#4c5c31] transition-colors cursor-pointer flex items-center gap-1">
                                <span>+</span>
                                <span>Tambah Kontak</span>
                            </button>
                        </div>

                        <div id="kontak-rows" class="space-y-3">
                            <div
                                class="flex flex-col sm:flex-row gap-3 items-start kontak-row bg-white p-3.5 rounded-2xl border border-[#2b2417]/14 shadow-2xs">
                                <div class="flex-1 w-full grid gap-1">
                                    <label class="text-[10px] font-bold text-[#6b6150]">Nama Kontak PIC</label>
                                    <input type="text" name="kontak[0][nama]" placeholder="Nama kontak"
                                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
                                </div>
                                <div class="flex-1 w-full grid gap-1">
                                    <label class="text-[10px] font-bold text-[#6b6150]">Nomor WhatsApp</label>
                                    <input type="text" name="kontak[0][whatsapp]" placeholder="08123456789"
                                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold font-mono text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
                                </div>
                                <button type="button" onclick="removeRow(this)"
                                    class="sm:mt-5 px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-700 hover:bg-rose-100 transition-colors shrink-0">Hapus</button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Actions (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-6">

                    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 shadow-sm space-y-5">
                        <h3 class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3">Aksi
                            Simpan</h3>
                        <p class="text-xs text-[#6b6150]">Pastikan nama binaan dan data pengurus/kontak sudah terisi dengan
                            benar sebelum menyimpan.</p>

                        <!-- Action Buttons -->
                        <div class="pt-4 border-t border-[#2b2417]/10 space-y-2.5">
                            <button type="submit"
                                class="w-full py-3.5 px-5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-md cursor-pointer flex items-center justify-center gap-2">
                                <span>💾</span>
                                <span>Simpan Data Binaan</span>
                            </button>
                            <a href="{{ route('admin.binaan') }}"
                                class="w-full py-3 px-5 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors text-center block">
                                Batal
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function addPengurusanRow() {
            const rows = document.querySelectorAll('#pengurusan-rows .pengurusan-row');
            const idx = rows.length;
            const html = `
        <div class="flex flex-col sm:flex-row gap-3 items-start pengurusan-row bg-white p-3.5 rounded-2xl border border-[#2b2417]/14 shadow-2xs">
            <div class="flex-1 w-full grid gap-1">
                <label class="text-[10px] font-bold text-[#6b6150]">Nama Pengurus</label>
                <input type="text" name="pengurusan[${idx}][nama]" placeholder="Nama pengurus" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
            </div>
            <div class="flex-1 w-full grid gap-1">
                <label class="text-[10px] font-bold text-[#6b6150]">Jabatan / Peran</label>
                <input type="text" name="pengurusan[${idx}][jabatan]" placeholder="Ketua / Sekretaris / Bendahara" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
            </div>
            <button type="button" onclick="removeRow(this)" class="sm:mt-5 px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-700 hover:bg-rose-100 transition-colors shrink-0">Hapus</button>
        </div>`;
            document.getElementById('pengurusan-rows').insertAdjacentHTML('beforeend', html);
        }

        function addKontakRow() {
            const rows = document.querySelectorAll('#kontak-rows .kontak-row');
            const idx = rows.length;
            const html = `
        <div class="flex flex-col sm:flex-row gap-3 items-start kontak-row bg-white p-3.5 rounded-2xl border border-[#2b2417]/14 shadow-2xs">
            <div class="flex-1 w-full grid gap-1">
                <label class="text-[10px] font-bold text-[#6b6150]">Nama Kontak PIC</label>
                <input type="text" name="kontak[${idx}][nama]" placeholder="Nama kontak" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
            </div>
            <div class="flex-1 w-full grid gap-1">
                <label class="text-[10px] font-bold text-[#6b6150]">Nomor WhatsApp</label>
                <input type="text" name="kontak[${idx}][whatsapp]" placeholder="08123456789" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold font-mono text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
            </div>
            <button type="button" onclick="removeRow(this)" class="sm:mt-5 px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-700 hover:bg-rose-100 transition-colors shrink-0">Hapus</button>
        </div>`;
            document.getElementById('kontak-rows').insertAdjacentHTML('beforeend', html);
        }

        function removeRow(btn) {
            const container = btn.closest('.pengurusan-row, .kontak-row');
            if (container) container.remove();
        }
    </script>
@endpush
