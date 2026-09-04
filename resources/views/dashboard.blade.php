@extends('layouts.admin')

@section('title', 'Dashboard Admin — Bank Sampah Bumi Indramayu Lestari')

@section('page-heading', 'Dashboard Admin Overview')

@section('content')
<div class="space-y-8">

    <!-- Welcome Hero Banner -->
    <div class="relative bg-[#2c3821] text-[#f6f1e2] rounded-3xl p-6 sm:p-10 overflow-hidden shadow-xl border border-[#4c5c31]">
        <div class="absolute -right-6 -bottom-6 opacity-15 pointer-events-none text-[#93a869]">
            <svg class="w-64 h-64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.4 19 2c1 2 2 4.1 2 9 0 4.9-4 9-9 9z"/><path d="M11 20v-5"/></svg>
        </div>

        <div class="relative z-10 max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#c1852c] text-white text-xs font-bold uppercase tracking-wider shadow-xs">
                <span>Panel Utama Admin</span>
            </div>

            <h1 class="font-fraunces font-bold text-2xl sm:text-4xl text-white leading-tight">
                Selamat Datang di Bank Sampah Bumi Indramayu Lestari
            </h1>

            <p class="text-xs sm:text-sm text-[#f6f1e2]/85 leading-relaxed font-medium">
                Kelola dokumentasi galeri kegiatan warga, katalog produk olahan ekonomi sirkular, kontak penanggung jawab WA, dan tanggapi pesan masuk warga secara terpadu.
            </p>

            <div class="flex flex-wrap gap-3 pt-2">
                <a href="{{ route('admin.galeri') }}" class="px-5 py-2.5 bg-[#fbf8ef] hover:bg-[#e9c688] text-[#2c3821] rounded-full text-xs font-bold transition-all shadow-xs">
                    📷 Kelola Galeri Kegiatan
                </a>
                <a href="{{ route('admin.katalog') }}" class="px-5 py-2.5 bg-[#c1852c] hover:bg-[#a67022] text-white rounded-full text-xs font-bold transition-all shadow-xs">
                    🛍️ Kelola Katalog Produk
                </a>
                <a href="{{ route('admin.kontak') }}" class="px-5 py-2.5 bg-[#4c5c31] hover:bg-[#3f4f29] text-white rounded-full text-xs font-bold transition-all shadow-xs">
                    📞 Kelola Kontak & Pesan
                </a>
            </div>
        </div>
    </div>

    <!-- Metric Stats Grid -->
    @php
        $statsCards = [
            [
                'label' => 'Total Galeri Kegiatan', 
                'value' => $stats['total_galleries'], 
                'unit' => 'Dokumentasi Program Warga', 
                'color' => 'text-[#4c5c31]', 
                'bg' => 'bg-[#dce6c8]', 
                'icon' => '📷',
                'href' => route('admin.galeri')
            ],
            [
                'label' => 'Katalog Produk Olahan', 
                'value' => $stats['total_products'], 
                'unit' => 'Produk Ekonomi Sirkular', 
                'color' => 'text-[#c1852c]', 
                'bg' => 'bg-[#e9c688]/30', 
                'icon' => '🛍️',
                'href' => route('admin.katalog')
            ],
            [
                'label' => 'Kontak PIC Layanan', 
                'value' => $stats['total_contacts'], 
                'unit' => 'Penanggung Jawab WA', 
                'color' => 'text-[#2c3821]', 
                'bg' => 'bg-[#2c3821]/10', 
                'icon' => '📞',
                'href' => route('admin.kontak')
            ],
            [
                'label' => 'Pesan Belum Dibaca', 
                'value' => $stats['unread_messages'], 
                'unit' => 'Pesan Masuk Warga', 
                'color' => 'text-blue-600', 
                'bg' => 'bg-blue-100', 
                'icon' => '💬',
                'href' => route('admin.kontak')
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($statsCards as $card)
            <a href="{{ $card['href'] }}" class="bg-white rounded-2xl p-5 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 group flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-[#6b6150] uppercase tracking-wider">{{ $card['label'] }}</span>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg {{ $card['bg'] }} shrink-0">
                        {{ $card['icon'] }}
                    </div>
                </div>

                <div>
                    <div class="font-fraunces font-bold text-3xl text-[#2c3821] group-hover:text-[#c1852c] transition-colors mb-1">
                        {{ $card['value'] }}
                    </div>
                    <p class="text-xs text-slate-500 font-medium">{{ $card['unit'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Recent Data Section Grid (Galeri & Katalog) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Galleries -->
        <div class="bg-white rounded-3xl p-6 border border-[#2b2417]/14 shadow-2xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="text-base">📷</span>
                    <h2 class="font-fraunces font-bold text-base text-[#2c3821]">Dokumentasi Galeri Terkini</h2>
                </div>
                <a href="{{ route('admin.galeri') }}" class="text-xs font-bold text-[#c1852c] hover:underline">Kelola Semua →</a>
            </div>

            @if (!isset($recent_galleries) || $recent_galleries->isEmpty())
                <p class="text-xs text-slate-500 py-6 text-center">Belum ada dokumentasi galeri kegiatan.</p>
            @else
                <div class="space-y-3">
                    @foreach ($recent_galleries as $rg)
                        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-[#fbf8ef] border border-[#2b2417]/10">
                            <div class="w-14 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                <img src="{{ $rg->image_url ?: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $rg->title }}" class="w-full h-full object-cover" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xs sm:text-sm font-bold text-[#2c3821] truncate">{{ $rg->title }}</h3>
                                <div class="flex items-center gap-2 text-[11px] text-slate-500 mt-0.5">
                                    <span class="text-[#c1852c] font-semibold">{{ $rg->category->name ?? 'Program' }}</span>
                                    <span>·</span>
                                    <span>{{ \Carbon\Carbon::parse($rg->event_date)->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Products -->
        <div class="bg-white rounded-3xl p-6 border border-[#2b2417]/14 shadow-2xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="text-base">🛍️</span>
                    <h2 class="font-fraunces font-bold text-base text-[#2c3821]">Produk Katalog Terkini</h2>
                </div>
                <a href="{{ route('admin.katalog') }}" class="text-xs font-bold text-[#c1852c] hover:underline">Kelola Semua →</a>
            </div>

            @if (!isset($recent_products) || $recent_products->isEmpty())
                <p class="text-xs text-slate-500 py-6 text-center">Belum ada produk katalog.</p>
            @else
                <div class="space-y-3">
                    @foreach ($recent_products as $rp)
                        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-[#fbf8ef] border border-[#2b2417]/10">
                            <div class="w-14 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                <img src="{{ $rp->image_url ?: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $rp->title }}" class="w-full h-full object-cover" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xs sm:text-sm font-bold text-[#2c3821] truncate">{{ $rp->title }}</h3>
                                <div class="flex items-center gap-2 text-[11px] mt-0.5">
                                    <span class="font-bold text-[#c1852c]">{{ $rp->price_text ?: 'Hubungi kami' }}</span>
                                    <span>·</span>
                                    <span class="{{ $rp->stock > 0 ? 'text-emerald-700 font-semibold' : 'text-rose-600 font-semibold' }}">Stok: {{ $rp->stock }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
