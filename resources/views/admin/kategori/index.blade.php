@extends('layouts.admin')

@section('title', 'Kelola Kategori — Admin')

@section('page-heading', 'Kelola Kategori')

@section('content')
<div class="space-y-6">

    <!-- Header & Filter Pills -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2b2417]/10 pb-4">
        <div>
            <h1 class="font-fraunces font-bold text-2xl text-[#2c3821]">Daftar Kategori</h1>
            <p class="text-xs text-[#6b6150] mt-0.5">Kelola kategori untuk pengelompokan Galeri Kegiatan dan Katalog Produk.</p>
        </div>

        <div class="flex items-center gap-2 bg-[#f6f1e2] p-1.5 rounded-full border border-[#2b2417]/14">
            <a href="{{ route('admin.kategori') }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ request('type') ? 'text-[#5a5040] hover:text-[#2c3821]' : 'bg-[#2c3821] text-[#fbf8ef] shadow-xs' }}">
                Semua
            </a>
            <a href="{{ route('admin.kategori', ['type' => 'galeri']) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ request('type') === 'galeri' ? 'bg-[#2c3821] text-[#fbf8ef] shadow-xs' : 'text-[#5a5040] hover:text-[#2c3821]' }}">
                Kategori Galeri
            </a>
            <a href="{{ route('admin.kategori', ['type' => 'katalog']) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ request('type') === 'katalog' ? 'bg-[#2c3821] text-[#fbf8ef] shadow-xs' : 'text-[#5a5040] hover:text-[#2c3821]' }}">
                Kategori Katalog
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- Form Tambah Kategori -->
        <div class="lg:col-span-1">
            <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 shadow-sm space-y-4">
                <h2 class="font-fraunces font-bold text-lg text-[#2c3821]">Tambah Kategori Baru</h2>

                <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Nama Kategori</label>
                        <input type="text" name="name" placeholder="misal: Kerajinan, Program" required class="w-full px-4 py-2.5 bg-white border border-[#2b2417]/16 rounded-2xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
                    </div>

                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Tipe Peruntukan</label>
                        <select name="type" required class="w-full px-4 py-2.5 bg-white border border-[#2b2417]/16 rounded-2xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]">
                            <option value="galeri" {{ request('type') === 'galeri' ? 'selected' : '' }}>Galeri Kegiatan</option>
                            <option value="katalog" {{ request('type') === 'katalog' ? 'selected' : '' }}>Katalog Produk</option>
                            <option value="semua">Semua Modul</option>
                        </select>
                    </div>

                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" placeholder="Keterangan singkat kategori..." class="w-full px-4 py-2.5 bg-white border border-[#2b2417]/16 rounded-2xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-xs cursor-pointer">
                        + Tambah Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Kategori -->
        <div class="lg:col-span-2">
            <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 overflow-hidden shadow-sm">
                @if ($categories->isEmpty())
                    <div class="p-12 text-center text-xs text-[#6b6150]">Belum ada data kategori.</div>
                @else
                    <table class="w-full text-left text-xs">
                        <thead class="bg-[#f6f1e2]/80 text-[#2c3821] uppercase text-[10px] font-bold tracking-wider">
                            <tr>
                                <th class="px-5 py-3.5">Kategori</th>
                                <th class="px-5 py-3.5">Peruntukan</th>
                                <th class="px-5 py-3.5">Jumlah Item</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#2b2417]/10 font-semibold">
                            @foreach ($categories as $cat)
                                <tr class="hover:bg-[#f6f1e2]/50 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-[#2c3821] text-sm">{{ $cat->name }}</div>
                                        <div class="text-[10px] text-[#6b6150] font-normal">{{ $cat->description ?: 'Tanpa deskripsi' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $cat->type === 'galeri' ? 'bg-emerald-100 text-emerald-800' : ($cat->type === 'katalog' ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-800') }}">
                                            {{ strtoupper($cat->type) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-[#5a5040]">
                                        @if($cat->type === 'galeri')
                                            {{ $cat->galleries_count }} Kegiatan
                                        @elseif($cat->type === 'katalog')
                                            {{ $cat->products_count }} Produk
                                        @else
                                            {{ $cat->galleries_count + $cat->products_count }} Item
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" 
                                                    onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->type }}', '{{ addslashes($cat->description ?? '') }}')" 
                                                    class="px-3.5 py-1.5 rounded-xl bg-[#e9c688]/40 text-[#2c3821] hover:bg-[#e9c688] font-bold transition-colors cursor-pointer">
                                                Edit
                                            </button>
                                            <button type="button" 
                                                    onclick="openDeleteCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}')" 
                                                    class="px-3.5 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold transition-colors cursor-pointer">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- EDIT CATEGORY MODAL -->
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-[#141008]/75 backdrop-blur-xs transition-all">
    <div class="relative bg-[#fbf8ef] border border-[#2b2417]/16 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5">
        <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3">
            <h3 class="font-fraunces font-bold text-xl text-[#2c3821]">Edit Kategori</h3>
            <button type="button" onclick="closeEditCategoryModal()" class="text-[#6b6150] hover:text-[#2c3821] text-lg font-bold cursor-pointer">✕</button>
        </div>

        <form id="editCategoryForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid gap-1.5">
                <label class="text-xs font-bold text-[#2c3821]">Nama Kategori</label>
                <input type="text" id="edit_cat_name" name="name" required class="w-full px-4 py-2.5 bg-white border border-[#2b2417]/16 rounded-2xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]" />
            </div>

            <div class="grid gap-1.5">
                <label class="text-xs font-bold text-[#2c3821]">Tipe Peruntukan</label>
                <select id="edit_cat_type" name="type" required class="w-full px-4 py-2.5 bg-white border border-[#2b2417]/16 rounded-2xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]">
                    <option value="galeri">Galeri Kegiatan</option>
                    <option value="katalog">Katalog Produk</option>
                    <option value="semua">Semua Modul</option>
                </select>
            </div>

            <div class="grid gap-1.5">
                <label class="text-xs font-bold text-[#2c3821]">Deskripsi Singkat</label>
                <textarea id="edit_cat_description" name="description" rows="3" class="w-full px-4 py-2.5 bg-white border border-[#2b2417]/16 rounded-2xl text-xs font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c]"></textarea>
            </div>

            <div class="flex items-center gap-3 pt-3 border-t border-[#2b2417]/10">
                <button type="button" onclick="closeEditCategoryModal()" class="flex-1 py-2.5 px-4 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold shadow-xs cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE CATEGORY MODAL (THEME STYLED) -->
<div id="deleteCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-[#141008]/75 backdrop-blur-xs transition-all">
    <div class="relative bg-[#fbf8ef] border border-[#2b2417]/16 rounded-3xl p-6 sm:p-8 max-w-sm w-full shadow-2xl space-y-5 text-center">
        <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-xs border border-rose-200">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18"/>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </svg>
        </div>

        <div class="space-y-1.5">
            <h3 class="font-fraunces font-bold text-xl text-[#2c3821]">Konfirmasi Hapus</h3>
            <p class="text-xs text-[#6b6150] leading-relaxed font-medium">
                Apakah Anda yakin ingin menghapus kategori <span id="delete_cat_name_display" class="font-bold text-[#2c3821]"></span>?
            </p>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="button" onclick="closeDeleteCategoryModal()" class="flex-1 py-2.5 px-4 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] cursor-pointer">
                Batal
            </button>

            <form id="deleteCategoryForm" method="POST" action="" class="flex-1">
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
function openEditCategoryModal(id, name, type, description) {
    const modal = document.getElementById('editCategoryModal');
    const form = document.getElementById('editCategoryForm');
    
    if (form) form.action = `/admin/kategori/${id}`;
    document.getElementById('edit_cat_name').value = name;
    document.getElementById('edit_cat_type').value = type;
    document.getElementById('edit_cat_description').value = description;

    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeEditCategoryModal() {
    const modal = document.getElementById('editCategoryModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

function openDeleteCategoryModal(id, name) {
    const modal = document.getElementById('deleteCategoryModal');
    const form = document.getElementById('deleteCategoryForm');
    
    if (form) form.action = `/admin/kategori/${id}`;
    document.getElementById('delete_cat_name_display').textContent = name;

    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeDeleteCategoryModal() {
    const modal = document.getElementById('deleteCategoryModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}
</script>
@endsection
