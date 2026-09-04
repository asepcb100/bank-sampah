@extends('layouts.admin')

@section('title', 'Kelola Katalog — Admin')

@section('page-heading', 'Kelola Katalog')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2b2417]/10 pb-4">
        <div>
            <h1 class="font-fraunces font-bold text-2xl text-[#2c3821]">Produk Katalog Olahan</h1>
            <p class="text-xs text-[#6b6150] mt-0.5">Kelola daftar produk hasil olahan daur ulang & ekonomi sirkular warga.</p>
        </div>
        <a href="{{ route('admin.katalog.create') }}" class="inline-flex items-center justify-center bg-[#2c3821] text-[#fbf8ef] px-5 py-2.5 rounded-full text-xs font-bold hover:bg-[#4c5c31] transition-all shadow-xs shrink-0 cursor-pointer">
            + Tambah Produk Baru
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.katalog') }}" class="bg-[#fbf8ef] border border-[#2b2417]/16 rounded-2xl p-4 flex flex-col sm:flex-row items-center gap-3 shadow-xs">
        <div class="relative flex-1 w-full">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#6b6150]">
                🔍
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk, deskripsi, harga..." class="w-full pl-9 pr-4 py-2 bg-white border border-[#2b2417]/14 rounded-xl text-xs text-[#2c3821] focus:outline-none focus:border-[#2c3821] focus:ring-1 focus:ring-[#2c3821]">
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
                <a href="{{ route('admin.katalog') }}" class="px-4 py-2 bg-[#f6f1e2] border border-[#2b2417]/14 text-[#2c3821] rounded-xl text-xs font-bold hover:bg-[#e9c688]/40 transition-colors shrink-0">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Table Section -->
    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 overflow-hidden shadow-sm">
        @if ($products->isEmpty())
            <div class="p-12 text-center text-xs text-[#6b6150]">
                @if(request('search') || request('category_id'))
                    Data produk tidak ditemukan untuk pencarian ini.
                @else
                    Belum ada data produk katalog.
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-[#2c3821] text-[#fbf8ef] uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Gambar</th>
                            <th class="px-5 py-3.5">Nama Produk</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Harga</th>
                            <th class="px-5 py-3.5">Stok</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2b2417]/10 font-semibold">
                        @foreach ($products as $product)
                        <tr class="odd:bg-white even:bg-[#f6f1e2]/40 hover:bg-[#e9c688]/20 transition-colors">
                            <td class="px-5 py-3.5">
                                <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-14 h-11 rounded-xl object-cover border border-[#2b2417]/14 shadow-2xs" />
                            </td>
                            <td class="px-5 py-3.5 font-bold text-[#2c3821] text-sm">{{ $product->title }}</td>
                            <td class="px-5 py-3.5 text-[#c1852c]">
                                <span class="px-2.5 py-1 rounded-full bg-amber-100/70 text-amber-900 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $product->category?->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-[#2c3821] font-bold">{{ $product->price_text ?: 'Hubungi kami' }}</td>
                            <td class="px-5 py-3.5 text-[#5a5040]">{{ $product->stock }} unit</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $product->is_available ? 'bg-emerald-100 text-emerald-800 border border-emerald-300/60' : 'bg-rose-100 text-rose-800 border border-rose-300/60' }}">
                                    {{ $product->is_available ? 'Tersedia' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.katalog.show', $product->id) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#f6f1e2] text-[#2c3821] hover:bg-[#e9c688]/40 transition-colors">Lihat</a>
                                    <a href="{{ route('admin.katalog.edit', $product->id) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#e9c688]/40 text-[#2c3821] hover:bg-[#e9c688] transition-colors">Edit</a>
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ route('admin.katalog.destroy', $product->id) }}', '{{ addslashes($product->title) }}')" 
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
            {{ $products->links() }}
        @endif
    </div>
</div>

@endsection
