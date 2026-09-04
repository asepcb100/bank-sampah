<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') — Bank Sampah Bumi Indramayu Lestari</title>
    <meta name="description" content="Bank Sampah Bumi Indramayu Lestari — Solusi Pengelolaan Sampah Berkelanjutan" />
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
    @stack('styles')
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#2c3821">
</head>
<body class="font-sans antialiased text-slate-800">

<div class="relative min-h-screen grid items-center justify-center lg:grid-cols-12 bg-[#f3f6f0] text-slate-800">

    {{-- Left hero --}}
    <div class="relative hidden lg:flex lg:col-span-7 flex-col p-10 lg:p-14 text-white overflow-hidden bg-cover bg-left-bottom min-h-screen" style="background-image: url('/img/bg.png');">
        <div class="absolute inset-0 bg-[#1b4317]/65 mix-blend-multiply pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#244f1c]/55 via-[#183a12]/45 to-[#0e2709]/75 pointer-events-none"></div>
        <svg class="absolute right-0 top-0 bottom-0 h-full w-20 lg:w-28 text-[#f3f6f0] fill-current z-10 translate-x-[1px] pointer-events-none" viewBox="0 0 100 1000" preserveAspectRatio="none">
            <path d="M0,0 C70,220 90,380 30,520 C-30,680 70,860 100,1000 L100,0 Z" />
        </svg>

        <div class="relative z-20 flex flex-wrap items-center justify-between gap-4 pr-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-full bg-white p-0.5 flex items-center justify-center shadow-xl border-2 border-white overflow-hidden">
                    <img src="/img/logo.png" alt="Logo Bank Sampah" class="w-full h-full object-contain" />
                </div>
                <div class="flex flex-col justify-center text-left">
                    <span class="text-[#f59e0b] font-black text-sm lg:text-base tracking-wider uppercase leading-tight drop-shadow-sm">BANK SAMPAH</span>
                    <span class="text-[#3b82f6] font-extrabold text-base lg:text-lg tracking-tight leading-tight drop-shadow-sm">Bumi Indramayu Lestari</span>
                </div>
            </a>
            <div class="flex items-center gap-2 bg-slate-950/45 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/20 shadow-sm">
                <span class="text-[10px] font-bold text-white/90 uppercase tracking-wider pr-0.5">Mitra:</span>
                <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center overflow-hidden"><img src="/img/logo_desa.png" alt="" class="w-full h-full object-contain" /></div>
                <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center overflow-hidden"><img src="/img/logo_kampus.png" alt="" class="w-full h-full object-contain" /></div>
                <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center overflow-hidden"><img src="/img/logo_kkn.png" alt="" class="w-full h-full object-contain" /></div>
            </div>
        </div>

        <div class="relative z-20 my-auto max-w-xl pr-6">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-white leading-tight tracking-tight drop-shadow-md">
                Bersama Kelola Sampah,<br /> Wujudkan <span class="text-[#4ade80] font-black">Bumi Lestari</span>
            </h1>
            <div class="w-16 h-1.5 bg-[#4ade80] rounded-full my-5"></div>
            <p class="text-xs sm:text-sm text-white/95 leading-relaxed max-w-md drop-shadow-xs font-normal mb-8">
                Bank Sampah Bumi Indramayu Lestari hadir sebagai solusi pengelolaan sampah yang berkelanjutan untuk lingkungan yang lebih bersih dan sehat.
            </p>
            <div class="grid grid-cols-4 gap-3 pt-2 max-w-lg">
                @foreach ([['Lingkungan Lebih Bersih'], ['Kelola Sampah Berkelanjutan'], ['Bersama Masyarakat'], ['Dampak Nyata']] as [$t])
                <div class="flex flex-col items-center text-center">
                    <div class="w-11 h-11 rounded-full bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center text-[#4ade80] mb-2 text-lg">🍃</div>
                    <span class="text-[11px] font-medium text-white/95 leading-tight">{{ $t }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-20 mt-auto">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#4ade80] hover:underline bg-slate-950/50 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 transition-all">← Kembali ke Beranda Utama</a>
        </div>
    </div>

    {{-- Right form --}}
    <div class="relative p-6 sm:p-10 lg:col-span-5 flex flex-col items-center justify-center w-full h-full min-h-screen bg-[#f3f6f0] overflow-hidden">
        <div class="lg:hidden mb-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-white p-0.5 flex items-center justify-center shadow-md border border-slate-200 overflow-hidden">
                    <img src="/img/logo.png" alt="Logo" class="w-full h-full object-contain" />
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[#f59e0b] font-black text-sm">BANK SAMPAH</span>
                    <span class="text-[#3b82f6] font-extrabold text-sm">Bumi Indramayu Lestari</span>
                </div>
            </a>
        </div>

        <div class="mx-auto flex w-full flex-col justify-center max-w-[410px] bg-white p-7 sm:p-9 rounded-[28px] border border-slate-200/60 shadow-xl relative mt-4">
            <div class="absolute -top-7 left-1/2 -translate-x-1/2 w-14 h-14 rounded-full bg-white border border-slate-100 shadow-md flex items-center justify-center">
                <div class="w-10 h-10 rounded-full bg-[#f0f4eb] flex items-center justify-center text-[#527838]">🍃</div>
            </div>
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mt-2 mb-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#527838] hover:text-[#3d5a2a]">← <span>Kembali ke Halaman Utama</span></a>
            </div>
            <div class="flex flex-col items-center text-center mb-6">
                <span class="text-[11px] font-bold text-[#527838] tracking-wide uppercase mb-1">🍃 @yield('eyebrow', 'Selamat Datang!') 🍃</span>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 mb-1">@yield('page-title', '')</h1>
                <p class="text-xs text-slate-500 leading-relaxed max-w-xs">@yield('description', '')</p>
            </div>
            @yield('form')
        </div>

        <div class="mt-6 text-center text-[11px] text-slate-500 space-y-0.5">
            <p>© 2026 Bank Sampah Bumi Indramayu Lestari</p>
            <p class="font-medium text-[#527838]">Untuk lingkungan yang lebih baik 🍃</p>
        </div>
    </div>
</div>

@stack('scripts')
</body>
</html>
