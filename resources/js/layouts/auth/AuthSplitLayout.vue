<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { home } from '@/routes';
import {
    ArrowLeft,
    Leaf,
    Globe,
    RefreshCw,
    Users,
    BarChart3
} from '@lucide/vue';

const page = usePage();

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="relative h-screen overflow-hidden grid items-center justify-center lg:max-w-none lg:grid-cols-12 bg-[#f3f6f0] text-slate-800 font-nunito">
        
        <!-- Left Column: Image Background + Brand + Features (7 Columns on LG) -->
        <div class="relative hidden h-full lg:flex lg:col-span-7 flex-col p-10 lg:p-14 text-white overflow-hidden bg-cover bg-left-bottom" style="background-image: url('/img/bg.png');">
            
            <!-- Rich Green Tint Overlay for background image -->
            <div class="absolute inset-0 bg-[#1b4317]/65 mix-blend-multiply pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#244f1c]/55 via-[#183a12]/45 to-[#0e2709]/75 pointer-events-none"></div>

            <!-- SVG S-Curve Divider (Right Edge of Left Panel) -->
            <svg class="absolute right-0 top-0 bottom-0 h-full w-20 lg:w-28 text-[#f3f6f0] fill-current z-10 translate-x-[1px] pointer-events-none" viewBox="0 0 100 1000" preserveAspectRatio="none">
                <path d="M0,0 C70,220 90,380 30,520 C-30,680 70,860 100,1000 L100,0 Z" />
            </svg>

            <!-- Top Brand Logo & Partner Logos Header -->
            <div class="relative z-20 flex flex-wrap items-center justify-between gap-4 pr-6">
                <!-- Main Brand Logo -->
                <Link :href="home()" class="flex items-center gap-3.5 group focus:outline-none">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-full bg-white p-0.5 flex items-center justify-center shadow-xl border-2 border-white shrink-0 group-hover:scale-105 transition-transform overflow-hidden">
                        <img src="/img/logo.png" alt="Logo Bank Sampah" class="w-full h-full object-contain" />
                    </div>
                    <div class="flex flex-col justify-center text-left">
                        <span class="text-[#f59e0b] font-black text-sm lg:text-base tracking-wider uppercase leading-tight drop-shadow-sm">
                            BANK SAMPAH
                        </span>
                        <span class="text-[#3b82f6] font-extrabold text-base lg:text-lg tracking-tight leading-tight drop-shadow-sm">
                            Bumi Indramayu Lestari
                        </span>
                    </div>
                </Link>

                <!-- Partner Logos Badge Bar (Mitra Kolaborasi) -->
                <div class="flex items-center gap-2 bg-slate-950/45 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/20 shadow-sm">
                    <span class="text-[10px] font-bold text-white/90 uppercase tracking-wider pr-0.5">Mitra:</span>
                    <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center shadow-xs overflow-hidden" title="Pemerintah Desa">
                        <img src="/img/logo_desa.png" alt="Logo Desa" class="w-full h-full object-contain" />
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center shadow-xs overflow-hidden" title="Perguruan Tinggi">
                        <img src="/img/logo_kampus.png" alt="Logo Kampus" class="w-full h-full object-contain" />
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center shadow-xs overflow-hidden" title="Program KKN">
                        <img src="/img/logo_kkn.png" alt="Logo KKN" class="w-full h-full object-contain" />
                    </div>
                </div>
            </div>

            <!-- Middle Headline Content -->
            <div class="relative z-20 my-auto max-w-xl pr-6">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-white leading-tight tracking-tight drop-shadow-md">
                    Bersama Kelola Sampah,<br />
                    Wujudkan <span class="text-[#4ade80] font-black">Bumi Lestari</span>
                </h1>
                
                <!-- Accent Underline Line -->
                <div class="w-16 h-1.5 bg-[#4ade80] rounded-full my-5 shadow-xs"></div>

                <p class="text-xs sm:text-sm text-white/95 leading-relaxed max-w-md drop-shadow-xs font-normal mb-8">
                    Bank Sampah Bumi Indramayu Lestari hadir sebagai solusi pengelolaan sampah yang berkelanjutan untuk lingkungan yang lebih bersih dan sehat.
                </p>

                <!-- 4 Feature Badges at Bottom of Left Panel -->
                <div class="grid grid-cols-4 gap-3 pt-2 max-w-lg">
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-11 h-11 rounded-full bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center text-[#4ade80] mb-2 group-hover:scale-110 transition-transform">
                            <Globe class="w-5 h-5" />
                        </div>
                        <span class="text-[11px] font-medium text-white/95 leading-tight">Lingkungan Lebih Bersih</span>
                    </div>

                    <div class="flex flex-col items-center text-center group">
                        <div class="w-11 h-11 rounded-full bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center text-[#4ade80] mb-2 group-hover:scale-110 transition-transform">
                            <RefreshCw class="w-5 h-5" />
                        </div>
                        <span class="text-[11px] font-medium text-white/95 leading-tight">Kelola Sampah Berkelanjutan</span>
                    </div>

                    <div class="flex flex-col items-center text-center group">
                        <div class="w-11 h-11 rounded-full bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center text-[#4ade80] mb-2 group-hover:scale-110 transition-transform">
                            <Users class="w-5 h-5" />
                        </div>
                        <span class="text-[11px] font-medium text-white/95 leading-tight">Bersama Masyarakat</span>
                    </div>

                    <div class="flex flex-col items-center text-center group">
                        <div class="w-11 h-11 rounded-full bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center text-[#4ade80] mb-2 group-hover:scale-110 transition-transform">
                            <BarChart3 class="w-5 h-5" />
                        </div>
                        <span class="text-[11px] font-medium text-white/95 leading-tight">Dampak Nyata</span>
                    </div>
                </div>
            </div>

            <!-- Back to main page link on left hero bottom -->
            <div class="relative z-20 mt-auto">
                <Link :href="home()" class="inline-flex items-center gap-2 text-xs font-semibold text-[#4ade80] hover:underline bg-slate-950/50 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 transition-all">
                    <ArrowLeft class="w-3.5 h-3.5" />
                    <span>Kembali ke Beranda Utama</span>
                </Link>
            </div>
        </div>

        <!-- Right Column: Login Form Container (5 Columns on LG) -->
        <div class="relative p-6 sm:p-10 lg:col-span-5 flex flex-col items-center justify-center w-full h-full bg-[#f3f6f0] overflow-hidden">
            
            <!-- Mobile Brand Header -->
            <div class="lg:hidden mb-6 text-center">
                <Link :href="home()" class="inline-flex items-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-white p-0.5 flex items-center justify-center shadow-md border border-slate-200 shrink-0 overflow-hidden">
                        <img src="/img/logo.png" alt="Logo" class="w-full h-full object-contain" />
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-[#f59e0b] font-black text-sm">BANK SAMPAH</span>
                        <span class="text-[#3b82f6] font-extrabold text-sm">Bumi Indramayu Lestari</span>
                    </div>
                </Link>
            </div>

            <!-- Form Card Wrapper -->
            <div class="mx-auto flex w-full flex-col justify-center max-w-[410px] bg-white p-7 sm:p-9 rounded-[28px] border border-slate-200/60 shadow-xl relative mt-4">
                
                <!-- Avatar Top Badge Icon -->
                <div class="absolute -top-7 left-1/2 -translate-x-1/2 w-14 h-14 rounded-full bg-white border border-slate-100 shadow-md flex items-center justify-center">
                    <div class="w-10 h-10 rounded-full bg-[#f0f4eb] flex items-center justify-center text-[#527838]">
                        <Leaf class="w-5 h-5 fill-current" />
                    </div>
                </div>

                <!-- Back Link Button Inside Form Card Header -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mt-2 mb-4">
                    <Link :href="home()" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#527838] hover:text-[#3d5a2a] transition-colors">
                        <ArrowLeft class="w-3.5 h-3.5" />
                        <span>Kembali ke Halaman Utama</span>
                    </Link>
                </div>

                <!-- Eyebrow & Title Header -->
                <div class="flex flex-col items-center text-center mb-6">
                    <span class="text-[11px] font-bold text-[#527838] tracking-wide uppercase mb-1">
                        🍃 Selamat Datang Kembali! 🍃
                    </span>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 mb-1" v-if="title">
                        {{ title }}
                    </h1>
                    <p class="text-xs text-slate-500 leading-relaxed max-w-xs" v-if="description">
                        {{ description }}
                    </p>
                </div>
                
                <slot />
            </div>

            <!-- Card Bottom Footer Copyright -->
            <div class="mt-6 text-center text-[11px] text-slate-500 space-y-0.5">
                <p>© 2026 Bank Sampah Bumi Indramayu Lestari</p>
                <p class="font-medium text-[#527838] flex items-center justify-center gap-1">
                    Untuk lingkungan yang lebih baik 🍃
                </p>
            </div>
        </div>
    </div>
</template>
