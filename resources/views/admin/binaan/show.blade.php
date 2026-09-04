@extends('layouts.admin')

@section('title', $binaan->nama . ' — Admin')

@section('page-heading', 'Detail Kelompok Binaan')

@section('content')
    <div class="max-w-full mx-auto space-y-6">

        <!-- Top Action Bar -->
        <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-4">
            <a href="{{ route('admin.binaan') }}"
                class="px-4 py-2 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors shrink-0">
                ← Kembali ke Binaan
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.binaan.edit', $binaan->id) }}"
                    class="px-4 py-2 rounded-full border border-[#c1852c]/30 bg-[#c1852c]/10 text-[#2c3821] hover:bg-[#c1852c]/20 text-xs font-bold transition-all">
                    ✏️ Edit Binaan
                </a>
                <button type="button" onclick="confirmDeleteBinaan({{ $binaan->id }}, '{{ addslashes($binaan->nama) }}')"
                    class="px-4 py-2 rounded-full border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition-all cursor-pointer">
                    🗑️ Hapus
                </button>
            </div>
        </div>

        <!-- Main Banner Card -->
        <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 overflow-hidden shadow-sm">
            <div class="p-6 sm:p-8 bg-[#2c3821] text-[#fbf8ef] space-y-2">
                <span
                    class="px-3 py-1 rounded-full bg-[#c1852c] text-white text-[10px] font-bold uppercase tracking-wider">Kelompok
                    Binaan</span>
                <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white">{{ $binaan->nama }}</h1>

                <div class="flex flex-wrap items-center gap-4 text-xs text-[#dce6c8] pt-1">
                    @if ($binaan->alamat)
                        <span class="flex items-center gap-1.5">
                            <span>📍</span>
                            <span>{{ $binaan->alamat }}</span>
                        </span>
                    @endif
                    @if ($binaan->berdiri_sejak)
                        <span class="flex items-center gap-1.5">
                            <span>📅</span>
                            <span>Berdiri sejak
                                {{ \Carbon\Carbon::parse($binaan->berdiri_sejak)->translatedFormat('d F Y') }}</span>
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Pengurusan Card -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3">
                        <h2 class="font-fraunces font-bold text-lg text-[#2c3821] flex items-center gap-2">
                            <span>👥</span>
                            <span>Struktur Pengurus ({{ $binaan->pengurusan->count() }})</span>
                        </h2>
                    </div>

                    @if ($binaan->pengurusan->isEmpty())
                        <p class="text-xs text-[#6b6150] italic py-2">Belum ada data struktur pengurus yang ditambahkan.</p>
                    @else
                        <div class="space-y-2.5">
                            @foreach ($binaan->pengurusan as $pengurus)
                                <div
                                    class="flex items-center gap-3 bg-white border border-[#2b2417]/14 rounded-2xl p-3.5 shadow-2xs">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#2c3821] text-[#fbf8ef] flex items-center justify-center font-bold text-xs shrink-0 font-fraunces">
                                        {{ strtoupper(substr($pengurus->nama, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-[#2c3821] truncate">{{ $pengurus->nama }}</p>
                                        <p class="text-[11px] text-[#c1852c] font-bold truncate">
                                            {{ $pengurus->jabatan ?? 'Pengurus' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Kontak Card -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3">
                        <h2 class="font-fraunces font-bold text-lg text-[#2c3821] flex items-center gap-2">
                            <span>📞</span>
                            <span>Kontak WA PIC ({{ $binaan->kontak->count() }})</span>
                        </h2>
                    </div>

                    @if ($binaan->kontak->isEmpty())
                        <p class="text-xs text-[#6b6150] italic py-2">Belum ada data kontak WhatsApp yang ditambahkan.</p>
                    @else
                        <div class="space-y-2.5">
                            @foreach ($binaan->kontak as $kontak)
                                <div
                                    class="bg-white border border-[#2b2417]/14 rounded-2xl p-3.5 shadow-2xs flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-[#2c3821] truncate">{{ $kontak->nama }}</p>
                                        <p class="text-[11px] text-[#6b6150] font-mono truncate">
                                            {{ $kontak->whatsapp ?? '-' }}</p>
                                    </div>
                                    @if ($kontak->whatsapp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kontak->whatsapp) }}"
                                            target="_blank"
                                            class="px-3 py-1.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold transition-all shrink-0 inline-flex items-center gap-1.5">
                                            <span>💬</span>
                                            <span>Hubungi WA</span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div id="deleteBinaanModal"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-[#141008]/75 backdrop-blur-xs transition-all">
        <div
            class="relative bg-[#fbf8ef] border border-[#2b2417]/16 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 text-center transform transition-all">

            <div
                class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-xs border border-rose-200 text-2xl">
                🗑️
            </div>

            <div class="space-y-1.5">
                <h3 class="font-fraunces font-bold text-xl text-[#2c3821]">Konfirmasi Hapus Binaan</h3>
                <p class="text-xs text-[#6b6150] leading-relaxed font-medium">
                    Apakah Anda yakin ingin menghapus kelompok binaan <strong id="deleteBinaanName"
                        class="text-rose-700"></strong> beserta data pengurus & kontaknya? Tindakan ini tidak dapat
                    dibatalkan.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button" onclick="closeDeleteBinaanModal()"
                    class="flex-1 py-2.5 px-4 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors cursor-pointer">
                    Batal
                </button>

                <form id="deleteBinaanForm" method="POST" action="" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-2.5 px-4 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                        Ya, Hapus Data
                    </button>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDeleteBinaan(id, name) {
                const modal = document.getElementById('deleteBinaanModal');
                const form = document.getElementById('deleteBinaanForm');
                const nameEl = document.getElementById('deleteBinaanName');

                if (modal && form && nameEl) {
                    nameEl.textContent = name;
                    form.action = `/admin/binaan/${id}`;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeDeleteBinaanModal() {
                const modal = document.getElementById('deleteBinaanModal');
                if (modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = '';
                }
            }
        </script>
    @endpush
@endsection
