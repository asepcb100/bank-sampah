@extends('layouts.admin')

@section('title', 'Kelola Galeri — Admin')

@section('page-heading', 'Kelola Galeri')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2b2417]/10 pb-4">
        <div>
            <h1 class="font-fraunces font-bold text-2xl text-[#2c3821]">Dokumentasi Kegiatan Warga</h1>
            <p class="text-xs text-[#6b6150] mt-0.5">Kelola galeri dokumentasi kegiatan & aksi pelestarian lingkungan.</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center justify-center bg-[#2c3821] text-[#fbf8ef] px-5 py-2.5 rounded-full text-xs font-bold hover:bg-[#4c5c31] transition-all shadow-xs shrink-0 cursor-pointer">
            + Tambah Galeri Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.galeri') }}" class="bg-[#fbf8ef] border border-[#2b2417]/16 rounded-2xl p-4 flex flex-col sm:flex-row items-center gap-3 shadow-xs">
        <div class="relative flex-1 w-full">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#6b6150]">
                🔍
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul kegiatan, lokasi..." class="w-full pl-9 pr-4 py-2 bg-white border border-[#2b2417]/14 rounded-xl text-xs text-[#2c3821] focus:outline-none focus:border-[#2c3821] focus:ring-1 focus:ring-[#2c3821]">
        </div>
        
        <div class="w-full sm:w-48 shrink-0">
            <select name="category_id" class="w-full px-3 py-2 bg-white border border-[#2b2417]/14 rounded-xl text-xs text-[#2c3821] focus:outline-none focus:border-[#2c3821] focus:ring-1 focus:ring-[#2c3821]">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <button type="submit" class="px-4 py-2 bg-[#2c3821] text-[#fbf8ef] rounded-xl text-xs font-bold hover:bg-[#4c5c31] transition-colors cursor-pointer shrink-0">
                Filter
            </button>
            @if(request('search') || request('category_id'))
                <a href="{{ route('admin.galeri') }}" class="px-4 py-2 bg-[#f6f1e2] border border-[#2b2417]/14 text-[#2c3821] rounded-xl text-xs font-bold hover:bg-[#e9c688]/40 transition-colors shrink-0">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Table Section -->
    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 overflow-hidden shadow-sm">
        @if ($galleries->isEmpty())
            <div class="p-12 text-center text-xs text-[#6b6150]">
                @if(request('search') || request('category_id'))
                    Data galeri kegiatan tidak ditemukan untuk pencarian ini.
                @else
                    Belum ada data galeri kegiatan.
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-[#2c3821] text-[#fbf8ef] uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Gambar</th>
                            <th class="px-5 py-3.5">Judul Kegiatan</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2b2417]/10 font-semibold">
                        @foreach ($galleries as $gallery)
                        <tr class="odd:bg-white even:bg-[#f6f1e2]/40 hover:bg-[#e9c688]/20 transition-colors">
                            <td class="px-5 py-3.5">
                                <img src="{{ $gallery->primary_image_url }}" alt="{{ $gallery->title }}" class="w-14 h-11 rounded-xl object-cover border border-[#2b2417]/14 shadow-2xs" />
                            </td>
                            <td class="px-5 py-3.5 font-bold text-[#2c3821] text-sm">
                                <div>{{ $gallery->title }}</div>
                                @if($gallery->location)
                                    <div class="text-[11px] text-[#6b6150] font-normal">📍 {{ $gallery->location }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-[#c1852c]">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100/70 text-emerald-900 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $gallery->category?->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-[#5a5040]">{{ \Carbon\Carbon::parse($gallery->event_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $gallery->is_published ? 'bg-emerald-100 text-emerald-800 border border-emerald-300/60' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $gallery->is_published ? 'Terbit' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.galeri.show', $gallery->id) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#f6f1e2] text-[#2c3821] hover:bg-[#e9c688]/40 transition-colors">Lihat</a>
                                    <a href="{{ route('admin.galeri.edit', $gallery->id) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#e9c688]/40 text-[#2c3821] hover:bg-[#e9c688] transition-colors">Edit</a>
                                    <button type="button" 
                                            onclick="openDeleteGalleryModal({{ $gallery->id }}, '{{ addslashes($gallery->title) }}')" 
                                            class="px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors cursor-pointer">
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
            {{ $galleries->links() }}
        @endif
    </div>
</div>

<!-- DELETE GALLERY MODAL (THEME STYLED) -->
<div id="deleteGalleryModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-[#141008]/75 backdrop-blur-xs transition-all">
    <div class="relative bg-[#fbf8ef] border border-[#2b2417]/16 rounded-3xl p-6 sm:p-8 max-w-sm w-full shadow-2xl space-y-5 text-center">
        <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-xs border border-rose-200">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18"/>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </svg>
        </div>

        <div class="space-y-1.5">
            <h3 class="font-fraunces font-bold text-xl text-[#2c3821]">Konfirmasi Hapus Galeri</h3>
            <p class="text-xs text-[#6b6150] leading-relaxed font-medium">
                Apakah Anda yakin ingin menghapus kegiatan <span id="delete_gal_title_display" class="font-bold text-[#2c3821]"></span>?
            </p>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="button" onclick="closeDeleteGalleryModal()" class="flex-1 py-2.5 px-4 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] cursor-pointer">
                Batal
            </button>

            <form id="deleteGalleryForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 px-4 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs cursor-pointer">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteGalleryModal(id, title) {
    const modal = document.getElementById('deleteGalleryModal');
    const form = document.getElementById('deleteGalleryForm');
    
    if (form) form.action = `/admin/galeri/${id}`;
    document.getElementById('delete_gal_title_display').textContent = title;

    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeDeleteGalleryModal() {
    const modal = document.getElementById('deleteGalleryModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}
</script>
@endsection
