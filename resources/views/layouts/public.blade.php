<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bumi Indramayu Lestari') — Bank Sampah Bumi Indramayu Lestari</title>
    <meta name="description" content="Bank Sampah Bumi Indramayu Lestari — Solusi Pengelolaan Sampah Berkelanjutan" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Bank Sampah Bumi Indramayu Lestari" />
    <meta property="og:image" content="{{ asset('img/bg.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
    @stack('styles')
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#2c3821">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300..900;1,300..900&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&display=swap" rel="stylesheet" />
</head>
<body id="top" class="font-nunito antialiased bg-[#f6f1e2] text-[#2b2417] selection:bg-[#c1852c] selection:text-white min-h-screen flex flex-col">

@php
    $currentUrl = request()->path();
    $navItems = [
        ['name' => 'Tentang', 'href' => '/#latar-belakang'],
        ['name' => 'Visi & Misi', 'href' => '/#visi-misi'],
        ['name' => 'Struktur', 'href' => '/#struktur'],
        ['name' => 'Program', 'href' => '/#program-kerja'],
        ['name' => 'Binaan', 'href' => '/#binaan'],
        ['name' => 'Galeri', 'href' => '/galeri'],
        ['name' => 'Katalog', 'href' => '/katalog'],
    ];
@endphp

<header class="sticky top-0 z-50 bg-[#f6f1e2]/92 backdrop-blur-md border-b border-[#2b2417]/16">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white p-0.5 flex items-center justify-center shadow-md border border-[#2b2417]/16 shrink-0 group-hover:scale-105 transition-transform overflow-hidden">
                    <img src="/img/logo.png" alt="Logo Bumi Indramayu Lestari" class="w-full h-full object-contain" />
                </div>
                <span class="font-bold text-sm sm:text-base text-[#2c3821] tracking-tight group-hover:text-[#c1852c] transition-colors leading-tight">Bumi Indramayu Lestari</span>
            </a>

            <nav class="hidden md:flex items-center gap-7 text-[0.94rem]">
                @foreach ($navItems as $item)
                <a href="{{ $item['href'] }}" class="relative py-1 text-[#2b2417] hover:text-[#c1852c] transition-colors after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[1px] after:bg-[#c1852c] hover:after:w-full after:transition-all {{ request()->is(trim($item['href'], '/')) ? 'font-bold text-[#c1852c] after:w-full' : '' }}">{{ $item['name'] }}</a>
                @endforeach
            </nav>

            <div class="hidden sm:flex items-center gap-4">
                <a href="/#kontak" class="bg-[#2c3821] text-[#fbf8ef] hover:bg-[#4c5c31] px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide transition-all">Hubungi Kami</a>
            </div>
        </div>
    </div>
</header>

<main class="flex-1">
    @yield('content')
</main>

<footer class="bg-[#fbf8ef] text-[#6b6150] border-t border-[#2b2417]/16 py-8">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
        <div class="flex items-center gap-3">
            <span class="font-semibold text-[#2c3821]">Mitra Kolaborasi:</span>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-white p-0.5 border border-[#2b2417]/16 overflow-hidden"><img src="/img/logo_desa.png" alt="Logo Desa" class="w-full h-full object-contain" /></div>
                <div class="w-7 h-7 rounded-full bg-white p-0.5 border border-[#2b2417]/16 overflow-hidden"><img src="/img/logo_kampus.png" alt="Logo Kampus" class="w-full h-full object-contain" /></div>
                <div class="w-7 h-7 rounded-full bg-white p-0.5 border border-[#2b2417]/16 overflow-hidden"><img src="/img/logo_kkn.png" alt="Logo KKN" class="w-full h-full object-contain" /></div>
            </div>
        </div>
        <div class="text-center md:text-left">© 2026 Bumi Indramayu Lestari — Berkontribusi memberi solusi untuk bumi lestari.</div>
        <div><a href="#top" class="hover:text-[#2c3821] transition-colors font-medium">Kembali ke atas ↑</a></div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
