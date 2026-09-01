<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import {
    Image,
    ShoppingBag,
    Phone,
    Globe,
    Leaf,
    RefreshCw,
    Users,
    ArrowUpRight,
    CheckCircle2,
    Calendar,
    Sparkles,
    MessageSquare
} from '@lucide/vue';
import { computed } from 'vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard Admin',
                href: dashboard(),
            },
        ],
    },
});

const props = defineProps<{
    stats?: {
        total_galleries: number;
        total_products: number;
        total_contacts: number;
        unread_messages: number;
    };
    recent_galleries?: Array<any>;
    recent_products?: Array<any>;
    recent_messages?: Array<any>;
}>();

const metricStats = computed(() => [
    {
        title: 'Total Galeri Kegiatan',
        value: props.stats ? String(props.stats.total_galleries) : '6',
        unit: 'Dokumentasi Program',
        icon: Image,
        color: 'text-[#4c5c31]',
        bgColor: 'bg-[#4c5c31]/10',
        borderColor: 'border-[#4c5c31]/20',
        href: '/admin/galeri'
    },
    {
        title: 'Katalog Produk Daur Ulang',
        value: props.stats ? String(props.stats.total_products) : '6',
        unit: 'Produk Ekonomi Sirkular',
        icon: ShoppingBag,
        color: 'text-[#c1852c]',
        bgColor: 'bg-[#c1852c]/10',
        borderColor: 'border-[#c1852c]/20',
        href: '/admin/katalog'
    },
    {
        title: 'Kontak PIC WA',
        value: props.stats ? String(props.stats.total_contacts) : '4',
        unit: 'Penanggung Jawab Produk',
        icon: Phone,
        color: 'text-[#2c3821]',
        bgColor: 'bg-[#2c3821]/10',
        borderColor: 'border-[#2c3821]/20',
        href: '/admin/kontak'
    },
    {
        title: 'Pesan Belum Dibaca',
        value: props.stats ? String(props.stats.unread_messages) : '1',
        unit: 'Pesan Masuk Warga',
        icon: MessageSquare,
        color: 'text-[#2563eb]',
        bgColor: 'bg-[#2563eb]/10',
        borderColor: 'border-[#2563eb]/20',
        href: '/admin/kontak'
    }
]);

const quickActions = [
    {
        title: 'Kelola Galeri Kegiatan',
        desc: 'Tambah, edit, dan atur dokumentasi kegiatan kelestarian warga',
        icon: Image,
        href: '/admin/galeri',
        btnText: 'Buka Kelola Galeri'
    },
    {
        title: 'Kelola Katalog Produk',
        desc: 'Atur daftar produk olahan minyak jelantah & PIC WA pemesanan',
        icon: ShoppingBag,
        href: '/admin/katalog',
        btnText: 'Buka Kelola Katalog'
    },
    {
        title: 'Kelola Kontak & Pesan Warga',
        desc: 'Atur master PIC kontak dan tanggapi pesan masuk warga',
        icon: Phone,
        href: '/admin/kontak',
        btnText: 'Buka Kelola Kontak'
    },
    {
        title: 'Lihat Tampilan Web Publik',
        desc: 'Pratinjau tampilan utama website yang dilihat oleh pengunjung',
        icon: Globe,
        href: '/',
        btnText: 'Ke Beranda Utama'
    }
];
</script>

<template>
    <Head title="Dashboard Admin — Bank Sampah Bumi Indramayu Lestari" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 sm:p-6 bg-[#f6f1e2]/40 rounded-2xl">
        
        <!-- Welcome Hero Banner -->
        <div class="relative bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 sm:p-8 overflow-hidden shadow-md border border-[#2b2417]/16">
            <div class="absolute -right-8 -bottom-8 opacity-15 pointer-events-none">
                <Leaf class="w-64 h-64 text-[#93a869] fill-current" />
            </div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-semibold mb-3">
                    <Sparkles class="w-3.5 h-3.5" />
                    <span>Panel Utama Admin</span>
                </div>
                <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white tracking-tight mb-2">
                    Selamat Datang di Bank Sampah Bumi Indramayu Lestari
                </h1>
                <p class="text-xs sm:text-sm text-[#f6f1e2]/85 leading-relaxed mb-4">
                    Kelola dokumentasi galeri kegiatan, produk ekonomi sirkular, kontak PIC WA, dan pesan masuk warga secara terpadu.
                </p>
                <div class="flex flex-wrap gap-3">
                    <Link
                        href="/admin/galeri"
                        class="px-4 py-2 bg-[#fbf8ef] text-[#2c3821] hover:bg-[#e9c688] rounded-full text-xs font-semibold transition-colors shadow-2xs"
                    >
                        Kelola Galeri
                    </Link>
                    <Link
                        href="/admin/katalog"
                        class="px-4 py-2 bg-[#c1852c] hover:bg-[#a67022] text-[#fbf8ef] rounded-full text-xs font-semibold transition-colors shadow-2xs"
                    >
                        Kelola Katalog
                    </Link>
                    <Link
                        href="/admin/kontak"
                        class="px-4 py-2 bg-[#4c5c31] hover:bg-[#3d4b27] text-[#fbf8ef] rounded-full text-xs font-semibold transition-colors shadow-2xs"
                    >
                        Kelola Kontak
                    </Link>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <Link
                v-for="stat in metricStats"
                :key="stat.title"
                :href="stat.href"
                class="bg-[#fbf8ef] rounded-xl p-5 border border-[#2b2417]/16 shadow-2xs hover:shadow-md transition-all group relative overflow-hidden"
            >
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-[#5a5040]">{{ stat.title }}</span>
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center border" :class="[stat.bgColor, stat.borderColor, stat.color]">
                        <component :is="stat.icon" class="w-4 h-4" />
                    </div>
                </div>

                <div class="flex items-baseline gap-2 mb-1">
                    <span class="font-fraunces font-bold text-2xl text-[#2c3821]">{{ stat.value }}</span>
                    <ArrowUpRight class="w-4 h-4 text-[#c1852c] opacity-0 group-hover:opacity-100 transition-opacity" />
                </div>
                <p class="text-[11px] text-[#54493a]">{{ stat.unit }}</p>
            </Link>
        </div>

        <!-- Quick Actions Grid -->
        <div class="space-y-4">
            <h2 class="font-fraunces font-semibold text-lg text-[#2c3821] flex items-center gap-2">
                <Sparkles class="w-4 h-4 text-[#c1852c]" />
                <span>Aksi Kelola Khusus Admin</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div
                    v-for="action in quickActions"
                    :key="action.title"
                    class="bg-[#fbf8ef] rounded-xl p-5 border border-[#2b2417]/16 shadow-2xs flex flex-col justify-between"
                >
                    <div>
                        <div class="w-8 h-8 rounded-lg bg-[#2c3821] text-[#f6f1e2] flex items-center justify-center mb-3">
                            <component :is="action.icon" class="w-4 h-4" />
                        </div>
                        <h3 class="font-fraunces font-semibold text-sm text-[#2c3821] mb-1">
                            {{ action.title }}
                        </h3>
                        <p class="text-xs text-[#54493a] leading-relaxed mb-4">
                            {{ action.desc }}
                        </p>
                    </div>

                    <Link
                        :href="action.href"
                        class="inline-flex items-center justify-center gap-1.5 py-2 px-4 bg-[#f6f1e2] hover:bg-[#e9c688]/40 border border-[#2b2417]/16 text-[#2c3821] text-xs font-semibold rounded-full transition-colors w-full"
                    >
                        <span>{{ action.btnText }}</span>
                        <ArrowUpRight class="w-3.5 h-3.5 text-[#c1852c]" />
                    </Link>
                </div>
            </div>
        </div>

    </div>
</template>
