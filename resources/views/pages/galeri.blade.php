@extends('layouts.public')

@section('title', 'Galeri Kegiatan Warga — Bumi Indramayu Lestari')

@section('content')
<div class="bg-[#f6f1e2] py-12 sm:py-16">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        
        <!-- Header Section -->
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                Dokumentasi Program
            </span>
            <h1 class="font-fraunces font-bold text-3xl sm:text-4xl text-[#2c3821]">Galeri Kegiatan Warga</h1>
            <p class="text-sm sm:text-base text-[#6b6150] mt-3 leading-relaxed">
                Dokumentasi aksi nyata komunitas bersama masyarakat Indramayu dalam pelestarian lingkungan, penimbangan bank sampah, dan edukasi daur ulang.
            </p>
        </div>

        <!-- Filter Categories Pills -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <a href="{{ route('galeri') }}" 
               class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ !request()->has('kategori') ? 'bg-[#2c3821] text-[#fbf8ef] shadow-md' : 'bg-white text-[#2b2417] border border-[#2b2417]/14 hover:bg-[#fbf8ef] hover:border-[#c1852c]' }}">
               Semua Dokumentasi
            </a>
            @foreach ($categories as $category)
            <a href="{{ route('galeri', ['kategori' => $category->slug]) }}" 
               class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ request('kategori') === $category->slug ? 'bg-[#2c3821] text-[#fbf8ef] shadow-md' : 'bg-white text-[#2b2417] border border-[#2b2417]/14 hover:bg-[#fbf8ef] hover:border-[#c1852c]' }}">
               {{ $category->name }}
            </a>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        @if ($galleries->isEmpty())
            <div class="p-12 text-center bg-white rounded-3xl border border-[#2b2417]/14 shadow-sm max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-[#f6f1e2] text-[#c1852c] flex items-center justify-center mx-auto mb-4 text-2xl">📷</div>
                <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">Belum Ada Dokumentasi</h3>
                <p class="text-xs text-[#6b6150] mt-1">Dokumentasi kegiatan untuk kategori ini belum tersedia.</p>
                <a href="{{ route('galeri') }}" class="inline-block mt-4 text-xs font-bold text-[#c1852c] hover:underline">← Tampilkan Semua Galeri</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($galleries as $gallery)
                <a href="{{ route('galeri.show', $gallery->slug) }}" 
                   class="group bg-white rounded-2xl overflow-hidden border border-[#2b2417]/16 shadow-2xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ $gallery->primary_image_url }}" 
                                 alt="{{ $gallery->title }}" 
                                 loading="lazy" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            
                            @if($gallery->category)
                                <span class="absolute top-3 left-3 bg-[#2c3821]/90 text-[#fbf8ef] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-xs shadow-xs">
                                    {{ $gallery->category->name }}
                                </span>
                            @endif

                            @if($gallery->images->count() > 0)
                                <span class="absolute top-3 right-3 bg-[#141008]/70 text-[#fbf8ef] text-[10px] font-bold px-2.5 py-0.5 rounded-full flex items-center gap-1 backdrop-blur-xs shadow-xs">
                                    <span>📷</span>
                                    <span>{{ $gallery->images->count() }} Foto</span>
                                </span>
                            @endif
                        </div>

                        <div class="p-5 space-y-2">
                            <h3 class="font-fraunces font-bold text-base sm:text-lg text-[#2c3821] group-hover:text-[#c1852c] transition-colors line-clamp-2 leading-snug">
                                {{ $gallery->title }}
                            </h3>
                            @if($gallery->description)
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">
                                    {{ $gallery->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                        <div class="flex items-center gap-1 font-medium">
                            <span class="text-[#c1852c]">📍</span>
                            <span class="truncate max-w-[170px]">{{ $gallery->location ?: 'Indramayu' }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-semibold">
                            {{ \Carbon\Carbon::parse($gallery->event_date)->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
