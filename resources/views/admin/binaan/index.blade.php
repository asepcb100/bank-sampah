@extends('layouts.admin')

@section('title', 'Kelola Binaan — Admin')

@section('page-heading', 'Kelola Kelompok Binaan')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Info Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2b2417]/10 pb-4">
        <div>
            <p class="text-xs text-[#6b6150]">Kelola data kelompok binaan, struktur pengurus, dan kontak komunikasi WhatsApp secara terpadu.</p>
        </div>
        <a href="{{ route('admin.binaan.create') }}" class="px-5 py-2.5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-sm shrink-0 inline-flex items-center gap-2">
            <span>✨</span>
            <span>Tambah Binaan Baru</span>
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.binaan') }}" class="bg-[#fbf8ef] border border-[#2b2417]/16 rounded-2xl p-4 flex flex-col sm:flex-row items-center gap-3 shadow-xs">
        <div class="relative flex-1 w-full">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#6b6150]">
                🔍
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama binaan, alamat lokasi..." class="w-full pl-9 pr-4 py-2 bg-white border border-[#2b2417]/14 rounded-xl text-xs text-[#2c3821] focus:outline-none focus:border-[#2c3821] focus:ring-1 focus:ring-[#2c3821]">
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <button type="submit" class="px-4 py-2 bg-[#2c3821] text-[#fbf8ef] rounded-xl text-xs font-bold hover:bg-[#4c5c31] transition-colors cursor-pointer shrink-0">
                Filter
            </button>
            @if(request('search'))
                <a href="{{ route('admin.binaan') }}" class="px-4 py-2 bg-[#f6f1e2] border border-[#2b2417]/14 text-[#2c3821] rounded-xl text-xs font-bold hover:bg-[#e9c688]/40 transition-colors shrink-0">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Table Container -->
    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 overflow-hidden shadow-xs">
        @if ($binaan->isEmpty())
            <div class="p-12 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-[#f6f1e2] border border-[#2b2417]/12 flex items-center justify-center mx-auto text-2xl">
                    👥
                </div>
                <div class="max-w-md mx-auto space-y-1">
                    <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                        @if(request('search'))
                            Data Binaan Tidak Ditemukan
                        @else
                            Belum Ada Data Kelompok Binaan
                        @endif
                    </h3>
                    <p class="text-xs text-[#6b6150]">
                        @if(request('search'))
                            Tidak ada kelompok binaan yang cocok dengan hasil pencarian Anda.
                        @else
                            Tambahkan data kelompok masyarakat atau komunitas binaan Bank Sampah Bumi Indramayu Lestari.
                        @endif
                    </p>
                </div>
                @if(!request('search'))
                    <a href="{{ route('admin.binaan.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#2c3821] text-[#fbf8ef] text-xs font-bold hover:bg-[#4c5c31] transition-all">
                        <span>+</span>
                        <span>Tambah Binaan Pertama</span>
                    </a>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#2c3821] text-[#fbf8ef] text-xs font-fraunces uppercase tracking-wider">
                            <th class="py-3.5 px-4 sm:px-6">Nama Binaan</th>
                            <th class="py-3.5 px-4">Alamat / Lokasi</th>
                            <th class="py-3.5 px-4">Berdiri Sejak</th>
                            <th class="py-3.5 px-4 text-center">Pengurusan</th>
                            <th class="py-3.5 px-4 text-center">Kontak WA</th>
                            <th class="py-3.5 px-4 text-right sm:pr-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2b2417]/10 text-xs font-semibold">
                        @foreach ($binaan as $item)
                        <tr class="odd:bg-white even:bg-[#f6f1e2]/40 hover:bg-[#e9c688]/20 transition-colors">
                            <td class="py-4 px-4 sm:px-6">
                                <div class="font-bold text-[#2c3821] text-sm">{{ $item->nama }}</div>
                            </td>
                            <td class="py-4 px-4 text-[#6b6150]">
                                <div class="max-w-[220px] truncate" title="{{ $item->alamat ?? '-' }}">
                                    {{ $item->alamat ?? '-' }}
                                </div>
                            </td>
                            <td class="py-4 px-4 text-[#6b6150] font-medium">
                                {{ $item->berdiri_sejak ? \Carbon\Carbon::parse($item->berdiri_sejak)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#f6f1e2] border border-[#2b2417]/12 text-[#2c3821] font-bold text-[11px]">
                                    <span>👥</span>
                                    <span>{{ $item->pengurusan_count }} Pengurus</span>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-[11px]">
                                    <span>📞</span>
                                    <span>{{ $item->kontak_count }} Kontak</span>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right sm:pr-6">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.binaan.show', $item->id) }}" 
                                       title="Detail" 
                                       class="px-3 py-1.5 rounded-full border border-[#2b2417]/16 bg-white text-[#2c3821] hover:bg-[#f6f1e2] font-bold transition-all">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.binaan.edit', $item->id) }}" 
                                       title="Edit" 
                                       class="px-3 py-1.5 rounded-full border border-[#c1852c]/30 bg-[#c1852c]/10 text-[#2c3821] hover:bg-[#c1852c]/20 font-bold transition-all">
                                        Edit
                                    </a>
                                    <button type="button" 
                                            onclick="confirmDeleteBinaan({{ $item->id }}, '{{ addslashes($item->nama) }}')" 
                                            class="px-3 py-1.5 rounded-full border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold transition-all cursor-pointer">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Server-Side Pagination Footer -->
            {{ $binaan->links() }}
        @endif
    </div>

</div>

<!-- DELETE CONFIRMATION MODAL -->
<div id="deleteBinaanModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-[#141008]/75 backdrop-blur-xs transition-all">
    <div class="relative bg-[#fbf8ef] border border-[#2b2417]/16 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 text-center transform transition-all">
        
        <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-xs border border-rose-200 text-2xl">
            🗑️
        </div>

        <div class="space-y-1.5">
            <h3 class="font-fraunces font-bold text-xl text-[#2c3821]">Konfirmasi Hapus Binaan</h3>
            <p class="text-xs text-[#6b6150] leading-relaxed font-medium">
                Apakah Anda yakin ingin menghapus kelompok binaan <strong id="deleteBinaanName" class="text-rose-700"></strong> beserta data pengurus & kontaknya? Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="button" onclick="closeDeleteBinaanModal()" class="flex-1 py-2.5 px-4 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors cursor-pointer">
                Batal
            </button>

            <form id="deleteBinaanForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 px-4 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
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
