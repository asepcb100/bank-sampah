@extends('layouts.public')

@section('title', 'Katalog Produk Olahan — Bumi Indramayu Lestari')

@section('content')
<div class="bg-[#f6f1e2] py-12 sm:py-16">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        
        <!-- Header Section -->
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                Ekonomi Sirkular
            </span>
            <h1 class="font-fraunces font-bold text-3xl sm:text-4xl text-[#2c3821]">Katalog Produk Olahan</h1>
            <p class="text-sm sm:text-base text-[#6b6150] mt-3 leading-relaxed">
                Produk ramah lingkungan hasil olahan kreasi warga — dari purifikasi minyak jelantah, karya anorganik ecobrick, hingga kerajinan kain perca.
            </p>
        </div>

        <!-- Filter Categories Pills -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <a href="{{ route('katalog') }}" 
               class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ !request()->has('kategori') ? 'bg-[#2c3821] text-[#fbf8ef] shadow-md' : 'bg-white text-[#2b2417] border border-[#2b2417]/14 hover:bg-[#fbf8ef] hover:border-[#c1852c]' }}">
               Semua Produk
            </a>
            @foreach ($categories as $category)
            <a href="{{ route('katalog', ['kategori' => $category->slug]) }}" 
               class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ request('kategori') === $category->slug ? 'bg-[#2c3821] text-[#fbf8ef] shadow-md' : 'bg-white text-[#2b2417] border border-[#2b2417]/14 hover:bg-[#fbf8ef] hover:border-[#c1852c]' }}">
               {{ $category->name }}
            </a>
            @endforeach
        </div>

        <!-- Product Cards Grid -->
        @if ($products->isEmpty())
            <div class="p-12 text-center bg-white rounded-3xl border border-[#2b2417]/14 shadow-sm max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-[#f6f1e2] text-[#c1852c] flex items-center justify-center mx-auto mb-4 text-2xl">🛍️</div>
                <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">Belum Ada Produk</h3>
                <p class="text-xs text-[#6b6150] mt-1">Produk untuk kategori ini belum tersedia saat ini.</p>
                <a href="{{ route('katalog') }}" class="inline-block mt-4 text-xs font-bold text-[#c1852c] hover:underline">← Tampilkan Semua Produk</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                <div class="group bg-white rounded-2xl overflow-hidden border border-[#2b2417]/16 shadow-2xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ $product->image_url ?: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop' }}" 
                                 alt="{{ $product->title }}" 
                                 loading="lazy" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            
                            @if($product->category)
                                <span class="absolute top-3 left-3 bg-[#c1852c] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                    {{ $product->category->name }}
                                </span>
                            @endif

                            <span class="absolute bottom-3 right-3 text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-md shadow-2xs {{ $product->stock > 0 ? 'bg-emerald-600/90 text-white' : 'bg-rose-600/90 text-white' }}">
                                {{ $product->stock > 0 ? 'Tersedia (' . $product->stock . ')' : 'Stok Habis' }}
                            </span>
                        </div>

                        <div class="p-5 space-y-2">
                            <a href="{{ route('katalog.show', $product->slug) }}">
                                <h3 class="font-fraunces font-bold text-base sm:text-lg text-[#2c3821] group-hover:text-[#c1852c] transition-colors line-clamp-2 leading-snug">
                                    {{ $product->title }}
                                </h3>
                            </a>
                            @if($product->description)
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">
                                    {{ $product->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Harga / Donasi</span>
                            <span class="font-bold text-sm text-[#c1852c]">{{ $product->price_text ?: 'Hubungi kami' }}</span>
                        </div>

                        @php
                            $phone = preg_replace('/[^0-9]/', '', $product->contact->phone ?? '628112442322');
                            $waUrl = "https://wa.me/{$phone}?text=" . urlencode("Halo " . ($product->contact->name ?? 'Admin BIL') . ", saya tertarik untuk memesan produk " . $product->title . ". Apakah stok masih tersedia?");
                        @endphp
                        <a href="{{ $waUrl }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs">
                            💬 <span>Pesan via WA</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
