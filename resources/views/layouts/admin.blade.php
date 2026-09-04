<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Admin') — Bank Sampah Bumi Indramayu Lestari</title>
    <meta name="description" content="Panel Admin Bank Sampah Bumi Indramayu Lestari" />
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
    @stack('styles')
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#2c3821">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300..900;1,300..900&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&display=swap" rel="stylesheet" />
</head>
<body class="font-nunito antialiased bg-[#f8f9fa] text-slate-800 min-h-screen flex">

    <!-- MOBILE SIDEBAR OVERLAY BACKDROP -->
    <div id="sidebarBackdrop" 
         onclick="closeMobileSidebar()" 
         class="fixed inset-0 bg-slate-900/40 z-40 md:hidden hidden backdrop-blur-xs transition-opacity duration-300"></div>

    <!-- SIDEBAR NAVIGATION (COLLAPSIBLE) -->
    <aside id="adminSidebar" 
           class="fixed md:sticky top-0 left-0 z-50 md:z-30 w-64 h-screen bg-white border-r border-slate-200/80 flex flex-col justify-between transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out shrink-0 overflow-y-auto overflow-x-hidden">
        
        <div class="p-4 space-y-5">
            
            <!-- Brand Logo Header -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-1 py-1 group min-h-[40px]">
                <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center shadow-xs border border-slate-200 overflow-hidden shrink-0 group-hover:scale-105 transition-transform">
                    <img src="/img/logo.png" alt="Logo Bumi Indramayu Lestari" class="w-full h-full object-contain" />
                </div>
                <div id="sidebarBrandText" class="flex flex-col justify-center min-w-0 transition-opacity duration-200">
                    <span class="text-[#c1852c] font-extrabold text-[9px] tracking-wider uppercase leading-tight">BANK SAMPAH</span>
                    <span class="font-bold text-xs text-[#2c3821] truncate leading-tight group-hover:text-[#c1852c] transition-colors">Bumi Indramayu Lestari</span>
                </div>
            </a>

            <!-- Group Section 1: Platform -->
            <div class="space-y-1">
                <div class="sidebar-group-title px-2.5 py-0.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Platform
                </div>

                <nav class="space-y-0.5">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       title="Dashboard"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('dashboard') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('dashboard') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Dashboard</span>
                    </a>

                    <!-- Galeri Kegiatan -->
                    <a href="{{ route('admin.galeri') }}" 
                       title="Galeri Kegiatan"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.galeri*') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('admin.galeri*') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Galeri Kegiatan</span>
                    </a>

                    <!-- Katalog Produk -->
                    <a href="{{ route('admin.katalog') }}" 
                       title="Katalog Produk"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.katalog*') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('admin.katalog*') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Katalog Produk</span>
                    </a>

                    <!-- Kontak & Pesan -->
                    <a href="{{ route('admin.kontak') }}" 
                       title="Kontak & Pesan"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.kontak*') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('admin.kontak*') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Kontak & Pesan</span>
                    </a>

                    <!-- Kelola Binaan -->
                    <a href="{{ route('admin.binaan') }}" 
                       title="Kelola Binaan"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.binaan*') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('admin.binaan*') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Kelola Binaan</span>
                    </a>

                    <!-- Visi & Misi -->
                    <a href="{{ route('admin.visi-misi') }}" 
                       title="Visi & Misi"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.visi-misi*') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('admin.visi-misi*') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Visi & Misi</span>
                    </a>

                    <!-- Struktur Organisasi -->
                    <a href="{{ route('admin.struktur') }}" 
                       title="Struktur Organisasi"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.struktur*') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('admin.struktur*') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="6" height="6" rx="1"/><rect x="16" y="7" width="6" height="6" rx="1"/><rect x="9" y="16" width="6" height="6" rx="1"/><path d="M5 13v6M19 13v-1M9 13l4-4"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Struktur Organisasi</span>
                    </a>

                    <!-- Program Kerja -->
                    <a href="{{ route('admin.program') }}" 
                       title="Program Kerja"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.program*') ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 {{ request()->routeIs('admin.program*') ? 'text-[#2c3821]' : 'text-slate-500' }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </span>
                        <span class="sidebar-text-item truncate text-xs">Program Kerja</span>
                    </a>
                </nav>
            </div>

            <!-- Group Section 2: Kategori Management -->
            <div class="space-y-1 pt-2 border-t border-slate-100">
                <div class="sidebar-group-title px-2.5 py-0.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Kategori Sistem
                </div>

                <nav class="space-y-0.5">
                    <a href="{{ route('admin.kategori', ['type' => 'galeri']) }}" 
                       title="Kategori Galeri"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.kategori*') && request('type') === 'galeri' ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 text-slate-500 text-xs">🏷️</span>
                        <span class="sidebar-text-item truncate text-xs">Kategori Galeri</span>
                    </a>

                    <a href="{{ route('admin.kategori', ['type' => 'katalog']) }}" 
                       title="Kategori Katalog"
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold transition-all border {{ request()->routeIs('admin.kategori*') && request('type') === 'katalog' ? 'bg-slate-100 text-slate-900 border-slate-200/60 font-bold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <span class="shrink-0 text-slate-500 text-xs">🏷️</span>
                        <span class="sidebar-text-item truncate text-xs">Kategori Katalog</span>
                    </a>
                </nav>
            </div>

        </div>

        <!-- Sidebar Bottom Area: Static Profile -->
        <div class="p-3 border-t border-slate-100 bg-white mt-auto">
            
            <a href="{{ route('home') }}" 
               target="_blank" 
               title="Beranda Utama Web"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors border border-transparent mb-2">
                <span class="shrink-0 text-slate-500">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </span>
                <span class="sidebar-text-item truncate text-xs">Beranda Utama Web</span>
            </a>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-9 h-9 rounded-xl bg-[#2c3821] text-[#fbf8ef] flex items-center justify-center font-bold text-xs shrink-0 font-fraunces shadow-2xs">
                        {{ strtoupper(substr(auth()->user()->name ?? 'AS', 0, 2)) }}
                    </div>
                    <div id="sidebarUserText" class="min-w-0">
                        <div class="text-xs font-bold text-slate-800 truncate leading-tight">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-[10px] text-slate-500 truncate leading-tight">{{ auth()->user()->email ?? '' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('profile.edit') }}" class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg bg-white border border-slate-200 text-[10px] font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                        <svg class="w-3 h-3 text-[#c1852c]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span class="sidebar-text-item">Profil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-1.5 py-1.5 px-3 rounded-lg bg-white border border-slate-200 text-[10px] font-bold text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            <span class="sidebar-text-item">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </aside>

    <!-- RIGHT CONTENT WRAPPER (HEADER + MAIN BODY + FOOTER) -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col min-w-0 min-h-screen transition-all duration-300">

        <!-- TOP NAVBAR (MINIMALIST WITH COLLAPSE TOGGLE & TITLE) -->
        <header class="sticky top-0 z-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Left: Sidebar Collapse/Expand Toggle Button & Page Title -->
                <div class="flex items-center gap-3">
                    
                    <!-- Desktop/Mobile Sidebar Toggle Icon Button -->
                    <button type="button" 
                            onclick="toggleSidebarCollapse()" 
                            id="sidebarToggleBtn"
                            title="Buka/Tutup Sidebar"
                            class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors border border-slate-200/80 cursor-pointer focus:outline-none">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M9 3v18"/>
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <h1 class="font-bold text-base sm:text-lg text-slate-800 flex items-center gap-2">
                        @yield('page-heading', 'Dashboard Admin')
                    </h1>
                </div>

                <!-- Right: Profile Dropdown Button -->
                <div class="relative shrink-0">
                    <button type="button" 
                            onclick="toggleUserDropdown()" 
                            id="topUserDropdownBtn"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 transition-colors cursor-pointer focus:outline-none text-xs font-semibold text-slate-700">
                        <div class="w-6 h-6 rounded-md bg-[#2c3821] text-[#fbf8ef] flex items-center justify-center font-bold text-[10px] shrink-0 font-fraunces">
                            {{ strtoupper(substr(auth()->user()->name ?? 'AS', 0, 2)) }}
                        </div>
                        <span class="hidden sm:inline-block truncate max-w-[120px]">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <!-- User Profile Dropdown Menu Box -->
                    <div id="adminUserDropdown" class="hidden absolute right-0 top-full mt-2 w-52 bg-white border border-slate-200 rounded-2xl shadow-xl p-1.5 z-50 space-y-1">
                        <div class="px-3 py-2 border-b border-slate-100 mb-1">
                            <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name ?? 'Admin Bank Sampah' }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@bumi.org' }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4 text-[#c1852c]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>Profil Admin</span>
                        </a>

                        <button type="button" 
                                onclick="closeUserDropdown(); openLogoutModal();" 
                                class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer text-left">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </div>
                </div>

            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 max-w-[1280px] w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            
            <!-- Toast notifications (bottom-right, auto-hide) -->
            <script>
                @if (session('success')) window.__flash = { type: 'success', message: {{ Js::from(session('success')) }} }; @endif
                @if (session('error')) window.__flash = { type: 'error', message: {{ Js::from(session('error')) }} }; @endif
            </script>

            @yield('content')
        </main>

        <!-- FOOTER ADMIN -->
        <footer class="bg-white border-t border-slate-200/80 py-6 mt-auto">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500 font-medium">
                © 2026 Bank Sampah Bumi Indramayu Lestari — Panel Pengelolaan Admin.
            </div>
        </footer>

    </div>

<!-- LOGOUT CONFIRMATION MODAL -->
<div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-all">
    <div class="relative bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-sm w-full shadow-2xl space-y-5 text-center transform transition-all">
        
        <!-- Warning Badge Icon -->
        <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-xs border border-rose-200">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
        </div>

        <!-- Modal Title & Message -->
        <div class="space-y-1.5">
            <h3 class="font-bold text-xl text-slate-800">Konfirmasi Keluar</h3>
            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                Apakah Anda yakin ingin keluar dari Panel Admin Bank Sampah Bumi Indramayu Lestari?
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-2">
            <button type="button" onclick="closeLogoutModal()" class="flex-1 py-2.5 px-4 rounded-full border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">
                Batal
            </button>

            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-2.5 px-4 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                    Ya, Keluar
                </button>
            </form>
        </div>

    </div>
</div>

<!-- SHARED DELETE CONFIRMATION MODAL -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-all">
    <div class="relative bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 max-w-sm w-full shadow-2xl space-y-5 text-center transform transition-all">
        <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-xs border border-rose-200">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                <line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
            </svg>
        </div>
        <div class="space-y-1.5">
            <h3 class="font-bold text-xl text-slate-800">Hapus Data</h3>
            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                Apakah Anda yakin ingin menghapus <span id="deleteItemName" class="font-bold text-slate-700"></span>? Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex items-center gap-3 pt-2">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 px-4 rounded-full border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">
                Batal
            </button>
            <form id="deleteForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 px-4 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// INITIALIZE SIDEBAR COLLAPSE STATE ON LOAD
document.addEventListener('DOMContentLoaded', function() {
    const isCollapsed = localStorage.getItem('adminSidebarCollapsed') === 'true';
    if (isCollapsed && window.innerWidth >= 768) {
        applySidebarState(true);
    }
});

function toggleSidebarCollapse() {
    if (window.innerWidth < 768) {
        // Mobile drawer behavior
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (sidebar && backdrop) {
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    } else {
        // Desktop collapse behavior
        const sidebar = document.getElementById('adminSidebar');
        const isCollapsed = sidebar.classList.contains('w-20');
        applySidebarState(!isCollapsed);
        localStorage.setItem('adminSidebarCollapsed', !isCollapsed);
    }
}

function closeMobileSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    if (sidebar && backdrop) {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    }
}

function applySidebarState(collapsed) {
    const sidebar = document.getElementById('adminSidebar');
    const textItems = document.querySelectorAll('.sidebar-text-item');
    const groupTitles = document.querySelectorAll('.sidebar-group-title');
    const brandText = document.getElementById('sidebarBrandText');

    if (!sidebar) return;

    if (collapsed) {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        textItems.forEach(el => el.classList.add('hidden'));
        groupTitles.forEach(el => el.classList.add('hidden'));
        if (brandText) brandText.classList.add('hidden');
    } else {
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');
        textItems.forEach(el => el.classList.remove('hidden'));
        groupTitles.forEach(el => el.classList.remove('hidden'));
        if (brandText) brandText.classList.remove('hidden');
    }
}

function toggleUserDropdown() {
    const dropdown = document.getElementById('adminUserDropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

function closeUserDropdown() {
    const dropdown = document.getElementById('adminUserDropdown');
    if (dropdown) {
        dropdown.classList.add('hidden');
    }
}

function openLogoutModal() {
    const modal = document.getElementById('logoutModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeLogoutModal() {
    const modal = document.getElementById('logoutModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

function openDeleteModal(url, name) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const nameEl = document.getElementById('deleteItemName');
    if (!modal || !form) return;
    form.action = url;
    if (nameEl) nameEl.textContent = name;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

document.addEventListener('click', function(e) {
    const topUserBtn = document.getElementById('topUserDropdownBtn');
    const topUserDrop = document.getElementById('adminUserDropdown');

    if (topUserDrop && topUserBtn && !topUserBtn.contains(e.target) && !topUserDrop.contains(e.target)) {
        topUserDrop.classList.add('hidden');
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeUserDropdown();
        closeLogoutModal();
        closeDeleteModal();
        closeMobileSidebar();
    }
});
</script>

@stack('scripts')

{{-- Toasts (bottom-right, auto-hide) --}}
<style>
    #toast-container{position:fixed;bottom:1.25rem;right:1.25rem;z-index:9999;display:flex;flex-direction:column;gap:.65rem;pointer-events:none;max-width:min(92vw,22rem)}
    .toast{padding:.8rem 1rem;border-radius:0.9rem;display:flex;align-items:flex-start;gap:.6rem;font-size:.8rem;font-weight:600;box-shadow:0 10px 30px rgba(20,16,8,.28);pointer-events:auto;transform:translateX(120%);opacity:0;transition:transform .35s cubic-bezier(.2,.9,.3,1),opacity .3s;animation:toastIn .35s cubic-bezier(.2,.9,.3,1) forwards}
    .toast.show{transform:translateX(0);opacity:1}
    .toast--success{background:#ecfdf3;color:#137333;border:1px solid #b7e4c7}
    .toast--error{background:#fdeaea;color:#b42318;border:1px solid #f6c6c1}
    .toast button{margin-left:auto;background:none;border:0;color:inherit;font-weight:700;cursor:pointer;line-height:1;padding:0 .1rem;opacity:.6}
    @keyframes toastIn{from{transform:translateX(120%);opacity:0}to{transform:translateX(0);opacity:1}}
</style>
<div id="toast-container" aria-live="polite"></div>
<script>
    (function(){
        function showToast(message, type){
            if(!message) return;
            var c = document.getElementById('toast-container'); if(!c) return;
            var t = document.createElement('div');
            t.className = 'toast toast--' + (type === 'error' ? 'error' : 'success');
            t.innerHTML = '<span>' + (type === 'error' ? '⚠️' : '✅') + '</span>' +
                          '<span>' + String(message) + '</span>' +
                          '<button type="button" aria-label="Tutup">&times;</button>';
            c.appendChild(t);
            var hide = function(){ t.classList.remove('show'); setTimeout(function(){ t.remove(); }, 350); };
            t.querySelector('button').addEventListener('click', hide);
            requestAnimationFrame(function(){ t.classList.add('show'); });
            setTimeout(hide, 3500);
        }
        if (window.__flash) { showToast(window.__flash.message, window.__flash.type); }
        window.showToast = showToast;
    })();
</script>
</body>
</html>

