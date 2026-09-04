@extends('layouts.admin')

@section('title', $gallery->title . ' — Detail Galeri')

@section('page-heading', 'Detail Galeri Kegiatan')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2b2417]/10 pb-4">
        <a href="{{ route('admin.galeri') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors shrink-0">
            ← Kembali ke Galeri
        </a>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.galeri.edit', $gallery->id) }}" class="px-4 py-2 rounded-full bg-[#c1852c] text-white hover:bg-[#a67022] text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                <span>✏️</span>
                <span>Edit Galeri</span>
            </a>
            <a href="{{ route('galeri.show', $gallery->slug) }}" target="_blank" class="px-4 py-2 rounded-full bg-[#2c3821] text-[#fbf8ef] hover:bg-[#4c5c31] text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                <span>🌐</span>
                <span>Lihat Publik ↗</span>
            </a>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: Information & Details (lg:col-span-7) -->
            <div class="lg:col-span-7 space-y-5">
                
                <!-- Category & Status Badges -->
                <div class="flex items-center gap-2.5 flex-wrap">
                    @if($gallery->category)
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300/60 text-[10px] font-extrabold uppercase tracking-wider">
                            {{ $gallery->category->name }}
                        </span>
                    @endif

                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider {{ $gallery->is_published ? 'bg-[#2c3821] text-[#fbf8ef]' : 'bg-slate-200 text-slate-700' }}">
                        {{ $gallery->is_published ? 'Terbit' : 'Draft' }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-[#2c3821] leading-tight">
                    {{ $gallery->title }}
                </h1>

                <!-- Metadata Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2">
                    <div class="p-3.5 bg-white rounded-2xl border border-[#2b2417]/12 shadow-2xs flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#f6f1e2] text-[#c1852c] flex items-center justify-center font-bold text-sm shrink-0">📅</div>
                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tanggal Pelaksanaan</span>
                            <span class="text-xs font-bold text-[#2c3821]">{{ \Carbon\Carbon::parse($gallery->event_date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="p-3.5 bg-white rounded-2xl border border-[#2b2417]/12 shadow-2xs flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#f6f1e2] text-[#c1852c] flex items-center justify-center font-bold text-sm shrink-0">📍</div>
                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Lokasi Kegiatan</span>
                            <span class="text-xs font-bold text-[#2c3821]">{{ $gallery->location ?: 'Indramayu' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($gallery->description)
                    <div class="space-y-2 pt-3 border-t border-[#2b2417]/10">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-[#c1852c]">Rincian & Deskripsi Kegiatan</h4>
                        <div class="p-4 bg-white rounded-2xl border border-[#2b2417]/12 text-xs sm:text-sm text-[#4a4234] leading-relaxed whitespace-pre-line">
                            {{ $gallery->description }}
                        </div>
                    </div>
                @endif

            </div>

            <!-- RIGHT COLUMN: Compact Media Showcase & Zoomable Gallery (lg:col-span-5) -->
            <div class="lg:col-span-5 space-y-4">
                
                <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-2">
                    <h3 class="font-fraunces font-bold text-base text-[#2c3821] flex items-center gap-2">
                        <span>🖼️</span>
                        <span>Foto Dokumentasi</span>
                    </h3>
                    <span class="text-[11px] text-slate-500 font-semibold">{{ $gallery->images->count() }} Foto</span>
                </div>

                <!-- Primary Cover Card (Compact Height) -->
                <div class="relative group h-48 sm:h-56 w-full rounded-2xl border border-[#2b2417]/16 overflow-hidden bg-white shadow-2xs cursor-pointer"
                     onclick="openImageZoom('{{ $gallery->primary_image_url }}', 'Foto Utama - {{ addslashes($gallery->title) }}')">
                    
                    <img src="{{ $gallery->primary_image_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 bg-slate-50" />
                    
                    <div class="absolute top-2 left-2 z-10 bg-[#059669] text-white text-[9px] font-extrabold px-2 py-0.5 rounded-md flex items-center gap-1 shadow-xs">
                        <span>UTAMA</span>
                    </div>

                    <!-- Zoom Overlay -->
                    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-2xs opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white gap-1 z-20">
                        <svg class="w-7 h-7 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            <line x1="11" y1="8" x2="11" y2="14"/>
                            <line x1="8" y1="11" x2="14" y2="11"/>
                        </svg>
                        <span class="text-[11px] font-bold">Klik untuk memperbesar</span>
                    </div>
                </div>

                <!-- Thumbnails Grid (Compact Small Images) -->
                @if ($gallery->images->count() > 0)
                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-2.5 pt-1">
                        @foreach ($gallery->images as $img)
                            <div class="relative group aspect-square rounded-xl border border-slate-200 overflow-hidden bg-white cursor-pointer shadow-2xs p-0.5 transition-all hover:border-[#c1852c]"
                                 onclick="openImageZoom('{{ $img->image_url }}', 'Dokumentasi {{ addslashes($gallery->title) }}')">
                                <img src="{{ $img->image_url }}" alt="Media" class="w-full h-full object-cover rounded-lg group-hover:scale-110 transition-transform duration-300 bg-slate-50" />
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>

<!-- LIGHTBOX IMAGE ZOOM MODAL -->
<div id="imageZoomModal" 
     class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-8 bg-[#141008]/90 backdrop-blur-md transition-all duration-300"
     onclick="closeImageZoom()">
    
    <!-- Close Button -->
    <button type="button" 
            onclick="closeImageZoom()" 
            class="absolute top-4 right-4 sm:top-6 sm:right-6 w-11 h-11 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center transition-transform hover:scale-110 cursor-pointer z-50">
        <svg class="w-6 h-6 stroke-[2.5]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>

    <!-- Modal Content Container -->
    <div class="relative max-w-4xl max-h-[85vh] w-full flex flex-col items-center justify-center space-y-3" onclick="event.stopPropagation()">
        <img id="zoomedImageDisplay" src="" alt="Zoomed Media" class="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl border border-white/20" />
        <p id="zoomedImageCaption" class="text-xs font-bold text-white/90 bg-slate-900/60 backdrop-blur-xs px-4 py-1.5 rounded-full text-center max-w-md truncate"></p>
    </div>
</div>

<script>
function openImageZoom(url, caption) {
    const modal = document.getElementById('imageZoomModal');
    const display = document.getElementById('zoomedImageDisplay');
    const captionEl = document.getElementById('zoomedImageCaption');

    if (display) display.src = url;
    if (captionEl) captionEl.textContent = caption || '';

    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeImageZoom() {
    const modal = document.getElementById('imageZoomModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

// Close Lightbox on Escape Key Press
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageZoom();
    }
});
</script>
@endsection
