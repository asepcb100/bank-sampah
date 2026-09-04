@extends('layouts.public')

@section('title', $gallery->title . ' — Galeri Kegiatan')

@section('content')
<div class="bg-[#f6f1e2] py-10 sm:py-14">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        
        <!-- Back Navigation Button -->
        <a href="{{ route('galeri') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#2c3821] hover:text-[#c1852c] transition-colors mb-8 bg-white px-4 py-2 rounded-full border border-[#2b2417]/14 shadow-2xs">
            ← Kembali ke Galeri Kegiatan
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Photo Showcase Column -->
            <div class="lg:col-span-7 space-y-4">
                <!-- Primary Image Display -->
                <div class="rounded-3xl overflow-hidden border border-[#2b2417]/16 bg-white shadow-lg aspect-[4/3]">
                    <img id="mainGalleryImage" 
                         src="{{ $gallery->primary_image_url }}" 
                         alt="{{ $gallery->title }}" 
                         class="w-full h-full object-cover transition-all duration-300" />
                </div>

                <!-- Thumbnails Carousel/Grid -->
                @if ($gallery->images->count() > 1)
                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                        @foreach ($gallery->images as $idx => $img)
                            <button type="button" 
                                    onclick="changeMainImage('{{ $img->image_url }}', this)" 
                                    class="gallery-thumb-btn rounded-xl overflow-hidden border-2 border-transparent hover:border-[#c1852c] focus:border-[#c1852c] aspect-square transition-all focus:outline-none bg-white p-0.5 cursor-pointer shadow-2xs {{ $idx === 0 ? 'border-[#c1852c]' : '' }}">
                                <img src="{{ $img->image_url }}" alt="Foto Kegiatan" class="w-full h-full object-cover rounded-lg" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Details Info Column -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#2b2417]/16 shadow-lg space-y-5">
                    
                    @if($gallery->category)
                        <span class="inline-block px-3 py-1 rounded-full bg-[#c1852c] text-white text-[10px] font-bold uppercase tracking-wider">
                            {{ $gallery->category->name }}
                        </span>
                    @endif

                    <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-[#2c3821] leading-tight">
                        {{ $gallery->title }}
                    </h1>

                    <!-- Metadata Items -->
                    <div class="space-y-3 pt-2 border-t border-[#2b2417]/10 text-xs sm:text-sm text-[#54493a]">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center font-bold text-xs shrink-0">📅</span>
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tanggal Pelaksanaan</span>
                                <span class="font-bold text-[#2c3821]">{{ \Carbon\Carbon::parse($gallery->event_date)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        @if($gallery->location)
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center font-bold text-xs shrink-0">📍</span>
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Lokasi Kegiatan</span>
                                <span class="font-bold text-[#2c3821]">{{ $gallery->location }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($gallery->description)
                        <div class="pt-4 border-t border-[#2b2417]/10 space-y-2">
                            <span class="block text-xs font-bold uppercase tracking-wider text-[#c1852c]">Deskripsi & Rangkuman Kegiatan</span>
                            <p class="text-xs sm:text-sm text-[#4a4234] leading-relaxed">
                                {{ $gallery->description }}
                            </p>
                        </div>
                    @endif

                </div>

                <!-- Related Activities Section -->
                @if ($related->isNotEmpty())
                    <div class="bg-[#fbf8ef] rounded-3xl p-6 border border-[#2b2417]/14 space-y-4">
                        <h3 class="font-fraunces font-bold text-base text-[#2c3821]">Dokumentasi Kegiatan Lainnya</h3>
                        <div class="space-y-3">
                            @foreach ($related as $rel)
                                <a href="{{ route('galeri.show', $rel->slug) }}" class="flex items-center gap-3.5 bg-white p-3 rounded-2xl border border-[#2b2417]/12 hover:shadow-md transition-all group">
                                    <div class="w-16 h-14 rounded-xl overflow-hidden shrink-0 bg-slate-100">
                                        <img src="{{ $rel->primary_image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs sm:text-sm font-bold text-[#2c3821] group-hover:text-[#c1852c] transition-colors truncate">{{ $rel->title }}</h4>
                                        <span class="text-[11px] text-slate-500 font-medium">{{ \Carbon\Carbon::parse($rel->event_date)->translatedFormat('d M Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function changeMainImage(imgUrl, clickedBtn) {
    const mainImg = document.getElementById('mainGalleryImage');
    if (mainImg) {
        mainImg.src = imgUrl;
    }
    document.querySelectorAll('.gallery-thumb-btn').forEach(btn => {
        btn.classList.remove('border-[#c1852c]');
        btn.classList.add('border-transparent');
    });
    if (clickedBtn) {
        clickedBtn.classList.remove('border-transparent');
        clickedBtn.classList.add('border-[#c1852c]');
    }
}
</script>
@endpush
