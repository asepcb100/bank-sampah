<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X, Leaf } from '@lucide/vue';

const page = usePage();
const currentRoute = computed(() => page.url);

const isMobileMenuOpen = ref(false);

const navItems = [
    { name: 'Tentang', href: '/#latar-belakang', match: '/#latar-belakang' },
    { name: 'Visi & Misi', href: '/#visi-misi', match: '/#visi-misi' },
    { name: 'Struktur', href: '/#struktur', match: '/#struktur' },
    { name: 'Program', href: '/#program-kerja', match: '/#program-kerja' },
    { name: 'Galeri', href: '/galeri', match: '/galeri' },
    { name: 'Katalog', href: '/katalog', match: '/katalog' },
];

function isActive(itemMatch: string) {
    if (itemMatch === '/') {
        return currentRoute.value === '/';
    }
    return currentRoute.value.startsWith(itemMatch);
}
</script>

<template>
    <div class="min-h-screen flex flex-col bg-[#f6f1e2] text-[#2b2417] font-nunito antialiased selection:bg-[#c1852c] selection:text-white">
        <!-- Site Header Navigation -->
        <header class="sticky top-0 z-50 bg-[#f6f1e2]/92 backdrop-blur-md border-b border-[#2b2417]/16">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                <div class="flex items-center justify-between h-20">
                    
                    <!-- Brand Logo -->
                    <Link href="/" class="flex items-center gap-3 group focus:outline-none">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white p-0.5 flex items-center justify-center shadow-md border border-[#2b2417]/16 shrink-0 group-hover:scale-105 transition-transform overflow-hidden">
                            <img src="/img/logo.png" alt="Logo Bumi Indramayu Lestari" class="w-full h-full object-contain" />
                        </div>
                        <div class="flex flex-col justify-center text-left">
                            <span class="font-bold text-sm sm:text-base text-[#2c3821] tracking-tight group-hover:text-[#c1852c] transition-colors leading-tight">
                                Bumi Indramayu Lestari
                            </span>
                        </div>
                    </Link>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center gap-7 text-[0.94rem]">
                        <Link
                            v-for="item in navItems"
                            :key="item.name"
                            :href="item.href"
                            class="relative py-1 text-[#2b2417] hover:text-[#c1852c] transition-colors after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-[1px] after:bg-[#c1852c] hover:after:w-full after:transition-all"
                            :class="[
                                isActive(item.match) ? 'font-bold text-[#c1852c] after:w-full' : ''
                            ]"
                        >
                            {{ item.name }}
                        </Link>
                    </nav>

                    <!-- CTA Header Button -->
                    <div class="hidden sm:flex items-center gap-4">
                        <a
                            href="/#kontak"
                            class="bg-[#2c3821] text-[#fbf8ef] hover:bg-[#4c5c31] px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide transition-all shadow-xs"
                        >
                            Hubungi Kami
                        </a>
                    </div>

                    <!-- Mobile Menu Toggle Button -->
                    <div class="flex md:hidden items-center">
                        <button
                            @click="isMobileMenuOpen = !isMobileMenuOpen"
                            class="p-2 rounded text-[#2c3821] hover:bg-[#e9c688]/30 focus:outline-none"
                            aria-label="Menu"
                        >
                            <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
                            <X v-else class="w-6 h-6" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div v-if="isMobileMenuOpen" class="md:hidden border-t border-[#2b2417]/16 bg-[#fbf8ef] px-6 pt-3 pb-6 space-y-3 shadow-lg">
                <Link
                    v-for="item in navItems"
                    :key="item.name"
                    :href="item.href"
                    @click="isMobileMenuOpen = false"
                    class="block py-2 text-sm font-medium text-[#2b2417] hover:text-[#c1852c] transition-colors"
                >
                    {{ item.name }}
                </Link>

                <div class="pt-3 border-t border-[#2b2417]/10">
                    <a
                        href="/#kontak"
                        @click="isMobileMenuOpen = false"
                        class="block text-center bg-[#2c3821] text-[#fbf8ef] px-4 py-2.5 rounded-full text-xs font-semibold"
                    >
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Site Footer -->
        <footer class="bg-[#fbf8ef] text-[#6b6150] border-t border-[#2b2417]/16 py-8">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-[#2c3821]">Mitra Kolaborasi:</span>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-white p-0.5 border border-[#2b2417]/16 shadow-2xs overflow-hidden" title="Pemerintah Desa">
                            <img src="/img/logo_desa.png" alt="Logo Desa" class="w-full h-full object-contain" />
                        </div>
                        <div class="w-7 h-7 rounded-full bg-white p-0.5 border border-[#2b2417]/16 shadow-2xs overflow-hidden" title="Perguruan Tinggi / Kampus">
                            <img src="/img/logo_kampus.png" alt="Logo Kampus" class="w-full h-full object-contain" />
                        </div>
                        <div class="w-7 h-7 rounded-full bg-white p-0.5 border border-[#2b2417]/16 shadow-2xs overflow-hidden" title="Program KKN">
                            <img src="/img/logo_kkn.png" alt="Logo KKN" class="w-full h-full object-contain" />
                        </div>
                    </div>
                </div>

                <div class="text-center md:text-left">
                    © 2026 Bumi Indramayu Lestari — Berkontribusi memberi solusi untuk bumi lestari.
                </div>

                <div>
                    <a href="#top" class="hover:text-[#2c3821] transition-colors font-medium">
                        Kembali ke atas ↑
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>
