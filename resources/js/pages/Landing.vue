<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Phone,
    MapPin,
    Mail,
    Calendar,
    Tag,
    ShoppingBag,
    Image as ImageIcon,
    CheckCircle2,
    MessageSquare,
    ArrowRight,
    Sparkles,
    Check,
    Eye,
    Users,
    Recycle,
    Leaf,
    FileText,
    ChevronRight,
    X,
    Award,
    Briefcase,
    GraduationCap,
    HeartHandshake,
    BookOpen,
    UserCheck,
    Layers
} from '@lucide/vue';

interface CategoryItem {
    id: number;
    name: string;
}

interface ContactItem {
    id: number;
    name: string;
    phone: string;
    role?: string;
    email?: string;
    address?: string;
}

interface GalleryImageItem {
    id: number;
    image_url: string;
    is_primary: boolean;
}

interface GalleryItem {
    id: number;
    title: string;
    category?: CategoryItem;
    location: string;
    event_date: string;
    image_url: string;
    images?: GalleryImageItem[];
    description?: string;
}

interface ProductItem {
    id: number;
    title: string;
    category?: CategoryItem;
    contact?: ContactItem;
    price_text: string;
    stock: number;
    image_url: string;
    images?: GalleryImageItem[];
    description?: string;
}

const props = defineProps<{
    galleries?: GalleryItem[];
    products?: ProductItem[];
    contacts?: ContactItem[];
}>();

const activeTab = ref<'pendidikan' | 'ekonomi' | 'humas'>('pendidikan');
const selectedLightboxItem = ref<GalleryItem | null>(null);

// Hero Gallery Showcase Carousel Index
const heroCarouselIdx = ref(0);

function formatImageUrl(url: string | null | undefined, fallback: string): string {
    if (!url) return fallback;
    if (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('data:') || url.startsWith('blob:')) {
        return url;
    }
    if (!url.startsWith('/')) {
        return '/' + url;
    }
    return url;
}

function getPrimaryImage(item: any, fallbackUrl: string): string {
    if (item?.images && item.images.length > 0) {
        const primary = item.images.find((img: any) => img.is_primary);
        if (primary && primary.image_url) return formatImageUrl(primary.image_url, fallbackUrl);
        if (item.images[0]?.image_url) return formatImageUrl(item.images[0].image_url, fallbackUrl);
    }
    return formatImageUrl(item?.image_url, fallbackUrl);
}

// Fallback dataset if database empty
const defaultGalleries: GalleryItem[] = [
    {
        id: 1,
        title: 'Program Sodaqoh',
        category: { id: 1, name: 'Program' },
        location: 'Balai Desa Karangampel',
        event_date: '2026-08-15',
        image_url: '/images/hero-landscape.jpg',
        description: 'Kegiatan rutin bulanan penimbangan dan penyetoran sedekah sampah anorganik oleh warga.'
    },
    {
        id: 2,
        title: 'Pelatihan Sabun Minyak Jelantah',
        category: { id: 2, name: 'Produk' },
        location: 'Sanggar Daur Ulang BIL',
        event_date: '2026-08-10',
        image_url: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
        description: 'Pelatihan praktek olahan limbah minyak goreng bekas menjadi sabun padat ramah lingkungan.'
    },
    {
        id: 3,
        title: 'Aksi Bersih & Edukasi Ecobrick',
        category: { id: 3, name: 'Kolaborasi' },
        location: 'Pesisir Pantai Indramayu',
        event_date: '2026-08-01',
        image_url: 'https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?q=80&w=800&auto=format&fit=crop',
        description: 'Aksi pembersihan sampah plastik dan pembuatan ecobrick bersama mahasiswa KKN.'
    }
];

const defaultProducts: ProductItem[] = [
    {
        id: 1,
        title: 'Sabun Minyak Jelantah Alami 100g',
        category: { id: 1, name: 'Perawatan' },
        contact: { id: 1, name: 'Ibu Siti Khadijah', phone: '6281234567890' },
        price_text: 'Rp 15.000 / batang',
        stock: 45,
        image_url: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
        description: 'Sabun batang alami hasil purifikasi minyak jelantah.'
    },
    {
        id: 2,
        title: 'Ecobrick Botol Plastik Daur Ulang',
        category: { id: 2, name: 'Kerajinan' },
        contact: { id: 2, name: 'Mbak Rina Wati', phone: '6285712345678' },
        price_text: 'Rp 10.000 / botol',
        stock: 120,
        image_url: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop',
        description: 'Botol padat berisi sampah anorganik siap guna.'
    },
    {
        id: 3,
        title: 'Pupuk Cair Organik Eco-Enzyme 500ml',
        category: { id: 3, name: 'Organik' },
        contact: { id: 3, name: 'Pak Budi Santoso', phone: '6281987654321' },
        price_text: 'Rp 20.000 / botol',
        stock: 30,
        image_url: 'https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?q=80&w=800&auto=format&fit=crop',
        description: 'Cairan fermentasi sampah buah dan sayuran.'
    }
];

const defaultContacts: ContactItem[] = [
    {
        id: 1,
        name: 'Layanan Utama BIL',
        phone: '628112442322',
        role: 'Customer Service & Admin Utama',
        email: 'admin@bumi-indramayu.id',
        address: 'Ruko Komplek Masjid Abdurrahman Basuri, Jl. MT Haryono, Sindang – Indramayu'
    },
    {
        id: 2,
        name: 'Ibu Siti Khadijah',
        phone: '6281234567890',
        role: 'PIC Produk Sabun & Olahan Jelantah'
    },
    {
        id: 3,
        name: 'Pak Budi Santoso',
        phone: '6281987654321',
        role: 'PIC Pupuk Kompos & Eco-Enzyme Organik'
    }
];

const displayGalleries = computed(() => {
    return props.galleries && props.galleries.length > 0 ? props.galleries : defaultGalleries;
});

const activeHeroGallery = computed(() => {
    const list = displayGalleries.value;
    return list[heroCarouselIdx.value % list.length] || defaultGalleries[0];
});

const displayProducts = computed(() => {
    return props.products && props.products.length > 0 ? props.products : defaultProducts;
});

const displayContacts = computed(() => {
    return props.contacts && props.contacts.length > 0 ? props.contacts : defaultContacts;
});

function openLightbox(item: GalleryItem) {
    selectedLightboxItem.value = item;
}

function closeLightbox() {
    selectedLightboxItem.value = null;
}
</script>

<template>
    <Head title="Bumi Indramayu Lestari — Berkontribusi memberi solusi untuk bumi lestari" />

    <PublicLayout>
        <!-- HERO SECTION (MATCHING DESIGN REFERENCE IMAGE EXACTLY) -->
        <section class="relative bg-[#f4efe4] pt-8 sm:pt-12 pb-16 sm:pb-24 overflow-hidden" id="beranda">
            
            <!-- Floating Decorative Leaves & Background Matrix Pattern -->
            <div class="absolute left-6 top-24 w-32 h-32 opacity-15 pointer-events-none hidden lg:block">
                <div class="grid grid-cols-4 gap-3 text-[#2c3821]">
                    <span v-for="i in 16" :key="i" class="w-1.5 h-1.5 rounded-full bg-[#2c3821]"></span>
                </div>
            </div>

            <!-- Foreground Bottom-Left Blurred Leaves Ornament -->
            <div class="absolute -bottom-10 -left-10 w-48 sm:w-64 h-48 sm:h-64 opacity-80 pointer-events-none z-20">
                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-[#4c5c31]/40 filter blur-[1px]">
                    <path d="M40 160C80 120 120 40 180 20C180 20 160 100 100 140C60 166.7 40 160 40 160Z" fill="#3f4f29" />
                    <path d="M10 190C60 160 90 90 140 70C140 70 120 140 70 170C30 190 10 190 10 190Z" fill="#2c3821" opacity="0.6" />
                </svg>
            </div>

            <div class="max-w-[1240px] mx-auto px-6 sm:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
                    
                    <!-- Left Hero Content Column -->
                    <div class="lg:col-span-6 space-y-6 sm:space-y-7">
                        
                        <!-- Top Pill Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#dce6c8] text-[#2c3821] font-bold text-xs sm:text-sm border border-[#c6d6ab] shadow-2xs">
                            <Leaf class="w-4 h-4 text-[#4c5c31] fill-[#4c5c31]/30" />
                            <span>Komunitas Peduli Lingkungan · Kabupaten Indramayu</span>
                        </div>

                        <!-- Main Heading with Handwritten Brush Underline -->
                        <h1 class="font-fraunces font-bold text-[#2c3821] text-4xl sm:text-5xl lg:text-[3.6rem] leading-[1.08] tracking-tight">
                            Berkontribusi<br />
                            memberi<br />
                            <span class="relative inline-block font-fraunces italic font-medium text-[#2c3821] px-1">
                                solusi
                                <!-- Hand-drawn brush underline SVG -->
                                <svg class="absolute -bottom-2 left-0 w-full h-4 text-[#c1852c]" viewBox="0 0 200 20" fill="none" preserveAspectRatio="none">
                                    <path d="M5 12C50 4 150 16 195 8" stroke="currentColor" stroke-width="4" stroke-linecap="round" />
                                </svg>
                            </span>
                            untuk<br />
                            bumi lestari.
                        </h1>

                        <!-- Paragraph Description -->
                        <p class="text-[#4a4030] text-sm sm:text-base max-w-[48ch] leading-relaxed font-medium">
                            Sejak 2021, kami mengajak warga Indramayu menjalani hidup ramah lingkungan lewat langkah sederhana — dari memilah sampah di rumah sampai membangun ekonomi sirkular bersama.
                        </p>

                        <!-- CTA Action Buttons -->
                        <div class="flex flex-wrap items-center gap-4 pt-2">
                            <a
                                href="#latar-belakang"
                                class="inline-flex items-center gap-2 bg-[#4c5c31] hover:bg-[#2c3821] text-[#fbf8ef] px-7 py-3.5 rounded-full font-bold text-xs sm:text-sm transition-all shadow-md hover:shadow-lg cursor-pointer"
                            >
                                <Leaf class="w-4 h-4 fill-white/20" />
                                <span>Kenali Komunitas</span>
                            </a>
                            <a
                                href="#kontak"
                                class="inline-flex items-center gap-2 border-2 border-[#2c3821] hover:bg-[#2c3821] hover:text-[#fbf8ef] text-[#2c3821] px-7 py-3.5 rounded-full font-bold text-xs sm:text-sm transition-all"
                            >
                                <Phone class="w-4 h-4" />
                                <span>Hubungi Kami</span>
                            </a>
                        </div>

                        <!-- Bottom Floating Metrics / Stats Card (Strictly 1 Row 3 Columns Grid) -->
                        <div class="pt-4 max-w-xl">
                            <div class="bg-[#fbf8ef]/95 backdrop-blur-md border border-[#2b2417]/14 rounded-2xl p-3.5 sm:p-5 shadow-sm grid grid-cols-3 divide-x divide-[#2b2417]/14 items-center">
                                
                                <!-- Stat 1 -->
                                <div class="flex items-center gap-2 sm:gap-3.5 pr-2 sm:pr-4">
                                    <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center shrink-0">
                                        <Users class="w-4 h-4 sm:w-5 sm:h-5" />
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-fraunces font-bold text-xs sm:text-base text-[#2c3821] truncate">2.150+</div>
                                        <div class="text-[10px] sm:text-xs font-semibold text-slate-500 truncate">Warga Terlibat</div>
                                    </div>
                                </div>

                                <!-- Stat 2 -->
                                <div class="flex items-center gap-2 sm:gap-3.5 px-2 sm:px-4">
                                    <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center shrink-0">
                                        <Leaf class="w-4 h-4 sm:w-5 sm:h-5" />
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-fraunces font-bold text-xs sm:text-base text-[#2c3821] truncate">48,6 Ton</div>
                                        <div class="text-[10px] sm:text-xs font-semibold text-slate-500 truncate">Sampah Terkelola</div>
                                    </div>
                                </div>

                                <!-- Stat 3 -->
                                <div class="flex items-center gap-2 sm:gap-3.5 pl-2 sm:pl-4">
                                    <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center shrink-0">
                                        <Recycle class="w-4 h-4 sm:w-5 sm:h-5" />
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-fraunces font-bold text-xs sm:text-base text-[#2c3821] truncate">16+</div>
                                        <div class="text-[10px] sm:text-xs font-semibold text-slate-500 truncate">Program Berjalan</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Right Visual Column with Organic Curved Shape -->
                    <div class="lg:col-span-6 relative flex justify-center lg:justify-end lg:-mt-4">
                        
                        <!-- Top Right Overhanging Leaves Ornament -->
                        <div class="absolute -top-12 -right-8 w-40 sm:w-56 h-40 sm:h-56 pointer-events-none z-20">
                            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-[#4c5c31]/70">
                                <path d="M160 10C120 40 40 80 20 160C20 160 100 140 140 80C166.7 40 160 10 160 10Z" fill="#3f4f29" />
                                <path d="M190 40C150 70 80 110 60 180C60 180 130 150 160 90C180 50 190 40 190 40Z" fill="#4c5c31" opacity="0.8" />
                            </svg>
                        </div>

                        <!-- Floating Leaf Particle -->
                        <div class="absolute top-1/4 left-4 w-6 h-6 text-[#4c5c31]/60 animate-bounce pointer-events-none z-20">
                            <Leaf class="w-full h-full fill-current" />
                        </div>

                        <!-- Organic Curved Hero Container -->
                        <div class="relative w-full max-w-lg aspect-[4/4.5] sm:aspect-[4/4] rounded-t-[140px] sm:rounded-t-[220px] rounded-b-[40px] overflow-hidden shadow-2xl border-4 border-white/80 bg-[#4c5c31] group">
                            
                            <!-- Hero Scenic Landscape / Community Image -->
                            <img
                                :src="getPrimaryImage(activeHeroGallery, '/images/hero-landscape.jpg')"
                                :alt="activeHeroGallery?.title || 'Bumi Indramayu Lestari'"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            />

                            <!-- Soft Gradient Vignette -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-90"></div>

                            <!-- Bottom-Right Floating Overlay Card (Dokumentasi Kegiatan) -->
                            <div class="absolute bottom-6 left-6 right-6 sm:left-auto sm:right-6 sm:max-w-xs bg-[#3c4a2a]/95 text-[#fbf8ef] p-4 sm:p-5 rounded-2xl shadow-2xl border border-white/20 backdrop-blur-md">
                                <div class="flex items-center gap-3.5">
                                    
                                    <!-- White Circle Icon Badge -->
                                    <div class="w-12 h-12 rounded-full bg-[#f4efe4] text-[#3c4a2a] flex items-center justify-center shrink-0 shadow-sm">
                                        <FileText class="w-6 h-6" />
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0 pr-1">
                                        <span class="block text-[10px] font-bold uppercase tracking-wider text-[#dce6c8]">
                                            DOKUMENTASI KEGIATAN
                                        </span>
                                        <h4 class="font-fraunces font-bold text-sm sm:text-base text-white truncate">
                                            {{ activeHeroGallery?.title || 'Program Sodaqoh' }}
                                        </h4>
                                        <button
                                            @click="openLightbox(activeHeroGallery)"
                                            class="inline-flex items-center gap-1 text-[11px] font-bold text-white hover:text-[#dce6c8] transition-colors mt-0.5"
                                        >
                                            <span>Lihat dokumentasi</span>
                                            <ArrowRight class="w-3.5 h-3.5" />
                                        </button>
                                    </div>

                                </div>

                                <!-- Pagination Dots -->
                                <div v-if="displayGalleries.length > 1" class="flex items-center justify-center gap-1.5 mt-3 pt-2 border-t border-white/10">
                                    <button
                                        v-for="(g, idx) in displayGalleries.slice(0, 3)"
                                        :key="g.id"
                                        @click="heroCarouselIdx = idx"
                                        class="w-2 h-2 rounded-full transition-all cursor-pointer"
                                        :class="[heroCarouselIdx % 3 === idx ? 'bg-white w-4' : 'bg-white/40']"
                                    ></button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- LATAR BELAKANG -->
        <section class="py-20 bg-[#f6f1e2]" id="latar-belakang">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                <div class="max-w-[56ch] mb-11">
                    <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">
                        Kenapa Komunitas Ini Berdiri
                    </h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-4">
                        <p class="text-[#2b2417] text-base leading-relaxed font-medium">
                            Kami adalah komunitas peduli lingkungan yang beraktivitas di Kabupaten Indramayu. Pendirian komunitas ini dilandasi oleh tiga hal utama:
                        </p>

                        <ul class="space-y-3.5 text-sm text-[#2b2417]">
                            <li class="flex items-start gap-3 bg-[#fbf8ef] p-3.5 rounded-xl border border-[#2b2417]/10">
                                <CheckCircle2 class="w-5 h-5 text-[#c1852c] shrink-0 mt-0.5" />
                                <span class="font-medium">Keprihatinan terhadap kualitas alam dan lingkungan akibat dampak sampah.</span>
                            </li>
                            <li class="flex items-start gap-3 bg-[#fbf8ef] p-3.5 rounded-xl border border-[#2b2417]/10">
                                <CheckCircle2 class="w-5 h-5 text-[#c1852c] shrink-0 mt-0.5" />
                                <span class="font-medium">Kepedulian masyarakat yang masih rendah terhadap pemilahan sampah dari rumah.</span>
                            </li>
                            <li class="flex items-start gap-3 bg-[#fbf8ef] p-3.5 rounded-xl border border-[#2b2417]/10">
                                <CheckCircle2 class="w-5 h-5 text-[#c1852c] shrink-0 mt-0.5" />
                                <span class="font-medium">Mengubah pola pikir warga agar menjalani gaya hidup ramah lingkungan (*sustainable living*).</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Quote Card -->
                    <div class="bg-[#2c3821] text-[#f6f1e2] p-8 sm:p-10 rounded-3xl relative shadow-xl border border-[#4c5c31]">
                        <div class="text-[#93a869]/40 font-fraunces text-7xl leading-none absolute top-4 left-6 select-none">“</div>
                        <p class="font-fraunces italic text-xl sm:text-2xl leading-relaxed relative z-10 pt-4 text-white">
                            Cara hidup ramah lingkungan yang dilakukan oleh banyak orang dengan cara sederhana, lebih baik daripada dilakukan oleh segelintir orang dengan cara yang sempurna.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- VISI MISI -->
        <section class="py-20 bg-[#fbf8ef] border-y border-[#2b2417]/16" id="visi-misi">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                <div class="max-w-[56ch] mb-11">
                    <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">
                        Visi & Misi Kami
                    </h2>
                    <p class="text-[#5a5040] mt-3 text-base">
                        Dua arah yang berjalan beriringan: kelestarian lingkungan dan pemberdayaan ekonomi warga.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-6 bg-white rounded-2xl border border-[#2b2417]/16 shadow-2xs">
                        <div class="text-xs uppercase font-bold text-[#c1852c] tracking-wider mb-2">Visi Lingkungan</div>
                        <h3 class="font-fraunces font-bold text-[#2c3821] text-lg mb-2">Bumi Bersih & Lestari</h3>
                        <p class="text-xs text-[#54493a] leading-relaxed">Mewujudkan komunitas yang berkontribusi bagi terciptanya lingkungan hidup yang bersih, sehat, dan lestari.</p>
                    </div>

                    <div class="p-6 bg-[#f6f1e2] rounded-2xl border border-[#2b2417]/16 shadow-2xs">
                        <div class="text-xs uppercase font-bold text-[#c1852c] tracking-wider mb-2">Visi Ekonomi</div>
                        <h3 class="font-fraunces font-bold text-[#2c3821] text-lg mb-2">Ekonomi Berdaya</h3>
                        <p class="text-xs text-[#54493a] leading-relaxed">Mengembangkan peran komunitas dalam pemberdayaan ekonomi masyarakat berbasis sampah.</p>
                    </div>

                    <div class="p-6 bg-white rounded-2xl border border-[#2b2417]/16 shadow-2xs">
                        <div class="text-xs uppercase font-bold text-[#c1852c] tracking-wider mb-2">Misi Edukasi</div>
                        <h3 class="font-fraunces font-bold text-[#2c3821] text-lg mb-2">Sustainable Living</h3>
                        <p class="text-xs text-[#54493a] leading-relaxed">Memberikan edukasi praktis kepada masyarakat tentang pemilahan dan pengolahan sampah dari rumah.</p>
                    </div>

                    <div class="p-6 bg-[#f6f1e2] rounded-2xl border border-[#2b2417]/16 shadow-2xs">
                        <div class="text-xs uppercase font-bold text-[#c1852c] tracking-wider mb-2">Misi Ekonomi</div>
                        <h3 class="font-fraunces font-bold text-[#2c3821] text-lg mb-2">Sampah Jadi Berkah</h3>
                        <p class="text-xs text-[#54493a] leading-relaxed">Pemberdayaan ekonomi lewat Bank Sampah, sedekah jelantah, dan kerajinan kreatif produk olahan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- STRUKTUR ORGANISASI -->
        <section class="py-20 bg-[#f6f1e2]" id="struktur">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                <div class="max-w-[62ch] mb-12">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#2c3821] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                        <UserCheck class="w-3.5 h-3.5 text-[#dce6c8]" />
                        <span>Pengurus & Tim Komunitas</span>
                    </div>
                    <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">
                        Struktur Organisasi
                    </h2>
                    <p class="text-[#5a5040] mt-3 text-sm sm:text-base leading-relaxed">
                        Pengurus dan tim penggerak komunitas Bumi Indramayu Lestari yang berdedikasi menjaga keberlanjutan dan mendampingi warga Indramayu.
                    </p>
                </div>

                <!-- Jajaran Pengurus Utama Grid -->
                <div class="mb-14">
                    <h3 class="text-xs uppercase font-bold text-[#c1852c] tracking-widest mb-6 flex items-center gap-2">
                        <Award class="w-4 h-4 text-[#c1852c]" />
                        <span>Pengurus Inti Komunitas</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        
                        <!-- Card 1: Pembina -->
                        <div class="bg-[#fbf8ef] rounded-2xl p-5 border border-[#2b2417]/14 shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div class="space-y-3">
                                <div class="w-14 h-14 rounded-2xl bg-[#dce6c8] text-[#2c3821] flex items-center justify-center font-bold font-fraunces text-xl group-hover:scale-105 transition-transform shadow-xs">
                                    ST
                                </div>
                                <div>
                                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-[#2c3821] text-[#fbf8ef] mb-1">
                                        Pembina / Penasihat
                                    </span>
                                    <h4 class="font-fraunces font-bold text-base text-[#2c3821] group-hover:text-[#c1852c] transition-colors">
                                        Sutrisno, S.P.
                                    </h4>
                                    <p class="text-xs text-[#6b6150] mt-1 leading-relaxed">
                                        Pegiat Lingkungan & Tokoh Masyarakat Indramayu. Pengarah visi strategis komunitas.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Ketua -->
                        <div class="bg-[#fbf8ef] rounded-2xl p-5 border border-[#2b2417]/14 shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div class="space-y-3">
                                <div class="w-14 h-14 rounded-2xl bg-[#4c5c31] text-white flex items-center justify-center font-bold font-fraunces text-xl group-hover:scale-105 transition-transform shadow-xs">
                                    AF
                                </div>
                                <div>
                                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-[#c1852c] text-white mb-1">
                                        Ketua Komunitas
                                    </span>
                                    <h4 class="font-fraunces font-bold text-base text-[#2c3821] group-hover:text-[#c1852c] transition-colors">
                                        Ahmad Fauzi, S.Ling.
                                    </h4>
                                    <p class="text-xs text-[#6b6150] mt-1 leading-relaxed">
                                        Koordinator utama pelaksanaan program kerja, riset lingkungan, dan pendampingan warga.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Sekretaris -->
                        <div class="bg-[#fbf8ef] rounded-2xl p-5 border border-[#2b2417]/14 shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div class="space-y-3">
                                <div class="w-14 h-14 rounded-2xl bg-[#dce6c8] text-[#2c3821] flex items-center justify-center font-bold font-fraunces text-xl group-hover:scale-105 transition-transform shadow-xs">
                                    SN
                                </div>
                                <div>
                                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-[#2c3821] text-[#fbf8ef] mb-1">
                                        Sekretaris & Admin
                                    </span>
                                    <h4 class="font-fraunces font-bold text-base text-[#2c3821] group-hover:text-[#c1852c] transition-colors">
                                        Siti Nurhaliza, S.Pd.
                                    </h4>
                                    <p class="text-xs text-[#6b6150] mt-1 leading-relaxed">
                                        Pengelola administrasi, dokumentasi, arsip program, serta alur komunikasi publik.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Bendahara -->
                        <div class="bg-[#fbf8ef] rounded-2xl p-5 border border-[#2b2417]/14 shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div class="space-y-3">
                                <div class="w-14 h-14 rounded-2xl bg-[#dce6c8] text-[#2c3821] flex items-center justify-center font-bold font-fraunces text-xl group-hover:scale-105 transition-transform shadow-xs">
                                    BS
                                </div>
                                <div>
                                    <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-[#2c3821] text-[#fbf8ef] mb-1">
                                        Bendahara & Operasional
                                    </span>
                                    <h4 class="font-fraunces font-bold text-base text-[#2c3821] group-hover:text-[#c1852c] transition-colors">
                                        Budi Santoso
                                    </h4>
                                    <p class="text-xs text-[#6b6150] mt-1 leading-relaxed">
                                        Manajemen keuangan kas komunitas, logistik timbang bank sampah, dan kemitraan pengepul.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Divisi & Bidang Kerja Grid -->
                <div>
                    <h3 class="text-xs uppercase font-bold text-[#c1852c] tracking-widest mb-6 flex items-center gap-2">
                        <Layers class="w-4 h-4 text-[#c1852c]" />
                        <span>Divisi Tim Penggerak Lapangan</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Divisi 1: Edukasi -->
                        <div class="bg-white p-6 rounded-2xl border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300">
                            <div class="w-10 h-10 rounded-xl bg-[#dce6c8] text-[#2c3821] flex items-center justify-center mb-4">
                                <GraduationCap class="w-5 h-5" />
                            </div>
                            <h4 class="font-fraunces font-bold text-lg text-[#2c3821] mb-1.5">
                                Divisi Edukasi & Pelatihan
                            </h4>
                            <p class="text-xs text-[#6b6150] leading-relaxed mb-4">
                                Menyusun kurikulum sosialisasi 3R, edukasi pemilahan sampah di RT/RW dan sekolah, serta menyelenggarakan workshop daur ulang ramah lingkungan.
                            </p>
                            <div class="text-[11px] font-semibold text-[#4c5c31] bg-[#dce6c8]/50 px-3 py-1.5 rounded-lg border border-[#c6d6ab]">
                                Focus: Edukasi Warga & Kampanye Zero-Waste
                            </div>
                        </div>

                        <!-- Divisi 2: Bank Sampah & Ekonomi -->
                        <div class="bg-white p-6 rounded-2xl border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300">
                            <div class="w-10 h-10 rounded-xl bg-[#dce6c8] text-[#2c3821] flex items-center justify-center mb-4">
                                <Recycle class="w-5 h-5" />
                            </div>
                            <h4 class="font-fraunces font-bold text-lg text-[#2c3821] mb-1.5">
                                Divisi Bank Sampah & Ekonomi
                            </h4>
                            <p class="text-xs text-[#6b6150] leading-relaxed mb-4">
                                Mengelola alur penerimaan sedekah sampah anorganik, penimbangan bulanan, pengolahan minyak jelantah, serta pembuatan pupuk organik.
                            </p>
                            <div class="text-[11px] font-semibold text-[#4c5c31] bg-[#dce6c8]/50 px-3 py-1.5 rounded-lg border border-[#c6d6ab]">
                                Focus: Bank Sampah & Ekonomi Sirkular
                            </div>
                        </div>

                        <!-- Divisi 3: Humas & Kemitraan -->
                        <div class="bg-white p-6 rounded-2xl border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300">
                            <div class="w-10 h-10 rounded-xl bg-[#dce6c8] text-[#2c3821] flex items-center justify-center mb-4">
                                <HeartHandshake class="w-5 h-5" />
                            </div>
                            <h4 class="font-fraunces font-bold text-lg text-[#2c3821] mb-1.5">
                                Divisi Humas & Kemitraan
                            </h4>
                            <p class="text-xs text-[#6b6150] leading-relaxed mb-4">
                                Membangun jaringan kolaborasi dengan pemerintah desa, instansi daerah, perguruan tinggi/mahasiswa KKN, serta komunitas lingkungan sekitar.
                            </p>
                            <div class="text-[11px] font-semibold text-[#4c5c31] bg-[#dce6c8]/50 px-3 py-1.5 rounded-lg border border-[#c6d6ab]">
                                Focus: Kemitraan Desa & Mahasiswa KKN
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- PROGRAM KERJA UTAMA -->
        <section class="py-20 bg-[#fbf8ef] border-y border-[#2b2417]/16" id="program-kerja">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                
                <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-10 gap-6">
                    <div class="max-w-[60ch]">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                            <Sparkles class="w-3.5 h-3.5" />
                            <span>Inisiatif & Aksi Nyata</span>
                        </div>
                        <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">
                            Program Kerja Utama
                        </h2>
                        <p class="text-[#5a5040] mt-3 text-sm sm:text-base leading-relaxed">
                            Rangkaian program unggulan berkelanjutan yang mengintegrasikan edukasi, pemberdayaan ekonomi warga, dan aksi kepedulian lingkungan.
                        </p>
                    </div>

                    <!-- Program Category Filter Tabs -->
                    <div class="flex items-center gap-2 p-1.5 bg-[#f6f1e2] rounded-full border border-[#2b2417]/14 shrink-0 overflow-x-auto">
                        <button
                            @click="activeTab = 'pendidikan'"
                            class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                            :class="[
                                activeTab === 'pendidikan'
                                    ? 'bg-[#2c3821] text-[#fbf8ef] shadow-xs'
                                    : 'text-[#5a5040] hover:text-[#2c3821]'
                            ]"
                        >
                            Edukasi & Literacy
                        </button>

                        <button
                            @click="activeTab = 'ekonomi'"
                            class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                            :class="[
                                activeTab === 'ekonomi'
                                    ? 'bg-[#2c3821] text-[#fbf8ef] shadow-xs'
                                    : 'text-[#5a5040] hover:text-[#2c3821]'
                            ]"
                        >
                            Ekonomi Sirkular
                        </button>

                        <button
                            @click="activeTab = 'humas'"
                            class="px-4 py-2 rounded-full text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                            :class="[
                                activeTab === 'humas'
                                    ? 'bg-[#2c3821] text-[#fbf8ef] shadow-xs'
                                    : 'text-[#5a5040] hover:text-[#2c3821]'
                            ]"
                        >
                            Humas & Kemitraan
                        </button>
                    </div>
                </div>

                <!-- Tab 1: Pendidikan & Edukasi -->
                <div v-if="activeTab === 'pendidikan'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#dce6c8] text-[#2c3821]">
                                    Rutin Bulanan
                                </span>
                                <GraduationCap class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Edukasi Pemilahan Sampah Dari Rumah
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Sosialisasi dan edukasi praktis bagi warga tentang cara memisahkan sampah organik, anorganik layak daur ulang, dan residu sejak dari dapur rumah.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Sasaran: Ibu PKK & Warga RT/RW</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#dce6c8] text-[#2c3821]">
                                    Pelatihan Berkala
                                </span>
                                <Sparkles class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Workshop Ecobrick & Kerajinan Plastik
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Pelatihan membuat ecobrick padat dari kantong/kemasan plastik tak terurai untuk dimanfaatkan menjadi mebel sederhana dan elemen konstruksi taman.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Sasaran: Pemuda & Komunitas</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#dce6c8] text-[#2c3821]">
                                    Kampanye Publik
                                </span>
                                <BookOpen class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Gerakan Sustainable Living Indramayu
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Kampanye terbuka pengurangan penggunaan kantong plastik sekali pakai, membawa botol minum sendiri, serta pembagian kantong belanja kain ramah lingkungan.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Sasaran: Pasar & Sekolah</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                </div>

                <!-- Tab 2: Ekonomi Sirkular -->
                <div v-if="activeTab === 'ekonomi'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#c1852c] text-white">
                                    Program Unggulan
                                </span>
                                <Recycle class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Sodaqoh Sampah Anorganik
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Penimbangan rutin sampah botol, kardus, dan plastik dari warga. Hasil penjualan disalurkan kembali untuk dana operasional sosial dan kas lingkungan.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Status: Penimbangan Tiap Bulan</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#c1852c] text-white">
                                    Produk Inovasi
                                </span>
                                <ShoppingBag class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Olahan Minyak Jelantah Jadi Sabun
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Penampungan limbah minyak goreng bekas dari dapur rumah tangga warga, diproses secara aman menjadi sabun padat alami untuk cuci dan pembersih.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Status: Produk Berizin & Siap Jual</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#c1852c] text-white">
                                    Pupuk & Eco-Enzyme
                                </span>
                                <Leaf class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Fermentasi Eco-Enzyme & Kompos
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Pengolahan sisa kulit buah dan sayuran dapur menjadi larutan eco-enzyme serbaguna serta pembuatan kompos organik untuk tanaman pekarangan.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Status: Produksi Mandiri Warga</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                </div>

                <!-- Tab 3: Humas & Kemitraan -->
                <div v-if="activeTab === 'humas'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#4c5c31] text-white">
                                    Aksi Lapangan
                                </span>
                                <Users class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Clean-Up Pesisir & Fasilitas Desa
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Aksi gotong royong pembersihan sampah anorganik di kawasan pesisir pantai Indramayu dan tempat umum bekerjasama dengan karang taruna setempat.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Mitra: Pemda & Karang Taruna</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#4c5c31] text-white">
                                    Kolaborasi KKN
                                </span>
                                <HeartHandshake class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Pendampingan Mahasiswa KKN
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Menjadi mitra pendamping bagi mahasiswa KKN dari berbagai perguruan tinggi dalam merealisasikan program kerja inovasi desa hijau dan bank sampah.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Mitra: Universitas / Perguruan Tinggi</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#2b2417]/14 shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#4c5c31] text-white">
                                    Pemberdayaan
                                </span>
                                <Briefcase class="w-5 h-5 text-[#c1852c]" />
                            </div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">
                                Kemitraan UMKM Daur Ulang
                            </h3>
                            <p class="text-xs text-[#54493a] leading-relaxed">
                                Membuka akses pemasaran produk hasil olahan warga (sabun jelantah, kerajinan ecobrick, pupuk) serta menjalin kerjasama dengan pembeli bahan baku daur ulang.
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-[#6b6150]">
                            <span>Mitra: Pelaku Usaha & Pasar Produk</span>
                            <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- DYNAMIC GALERI PREVIEW SECTION (FROM DATABASE) -->
        <section class="py-20 bg-[#f6f1e2]" id="galeri">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10 gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-2">
                            <ImageIcon class="w-3.5 h-3.5" />
                            <span>Dokumentasi Terkini</span>
                        </div>
                        <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl">
                            Galeri Kegiatan Warga
                        </h2>
                        <p class="text-[#5a5040] text-sm mt-1">Dokumentasi asli penimbangan bank sampah, edukasi, dan aksi lingkungan bersama warga.</p>
                    </div>

                    <Link
                        href="/galeri"
                        class="px-5 py-2.5 bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] rounded-full text-xs font-bold flex items-center gap-2 transition-colors shadow-2xs shrink-0"
                    >
                        <span>Lihat Semua Galeri</span>
                        <ArrowRight class="w-4 h-4" />
                    </Link>
                </div>

                <!-- Gallery Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="item in displayGalleries.slice(0, 6)"
                        :key="item.id"
                        @click="openLightbox(item)"
                        class="group bg-white rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-xl transition-all duration-300 cursor-pointer flex flex-col justify-between"
                    >
                        <div>
                            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-slate-100">
                                <img
                                    :src="getPrimaryImage(item, 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop')"
                                    :alt="item.title"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                />
                                <span class="absolute top-3 left-3 bg-[#2c3821]/90 text-[#fbf8ef] text-[10px] font-bold px-3 py-1 rounded-full backdrop-blur-2xs uppercase tracking-wider">
                                    {{ item.category?.name || 'Program' }}
                                </span>
                            </div>

                            <div class="p-5 space-y-2">
                                <h3 class="font-fraunces font-bold text-base text-[#2c3821] group-hover:text-[#c1852c] transition-colors line-clamp-2">
                                    {{ item.title }}
                                </h3>
                                <p v-if="item.description" class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">
                                    {{ item.description }}
                                </p>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                            <div class="flex items-center gap-1 font-medium">
                                <MapPin class="w-3.5 h-3.5 text-[#c1852c]" />
                                <span class="truncate max-w-[200px]">{{ item.location }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DYNAMIC KATALOG PREVIEW SECTION (FROM DATABASE) -->
        <section class="py-20 bg-[#fbf8ef] border-y border-[#2b2417]/16" id="katalog">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10 gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-2">
                            <ShoppingBag class="w-3.5 h-3.5" />
                            <span>Ekonomi Sirkular</span>
                        </div>
                        <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl">
                            Katalog Produk Olahan
                        </h2>
                        <p class="text-[#5a5040] text-sm mt-1">Produk ramah lingkungan hasil olahan minyak jelantah, sampah anorganik, dan kain perca.</p>
                    </div>

                    <Link
                        href="/katalog"
                        class="px-5 py-2.5 bg-[#c1852c] hover:bg-[#a67022] text-[#fbf8ef] rounded-full text-xs font-bold flex items-center gap-2 transition-colors shadow-2xs shrink-0"
                    >
                        <span>Buka Katalog Lengkap</span>
                        <ArrowRight class="w-4 h-4" />
                    </Link>
                </div>

                <!-- Product Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="item in displayProducts.slice(0, 6)"
                        :key="item.id"
                        class="bg-white rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
                    >
                        <div>
                            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-slate-100">
                                <img
                                    :src="getPrimaryImage(item, 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop')"
                                    :alt="item.title"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                                />
                                <span class="absolute top-3 left-3 bg-[#c1852c] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                    {{ item.category?.name || 'Perawatan' }}
                                </span>
                            </div>

                            <div class="p-5 space-y-2">
                                <Link :href="`/katalog/${item.slug || item.id}`">
                                    <h3 class="font-fraunces font-bold text-base text-[#2c3821] hover:text-[#c1852c] transition-colors line-clamp-2">
                                        {{ item.title }}
                                    </h3>
                                </Link>
                                <p v-if="item.description" class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ item.description }}
                                </p>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Harga</span>
                                <span class="font-bold text-sm text-[#c1852c]">{{ item.price_text }}</span>
                            </div>

                            <a
                                :href="`https://wa.me/${(item.contact?.phone || '628112442322').replace(/[^0-9]/g, '')}?text=${encodeURIComponent('Halo ' + (item.contact?.name || 'Admin BIL') + ', saya tertarik untuk memesan produk ' + item.title + '. Apakah stok masih tersedia?')}`"
                                target="_blank"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                            >
                                <MessageSquare class="w-3.5 h-3.5" />
                                <span>Pesan via WA</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DYNAMIC KONTAK & LAYANAN SECTION (FROM DATABASE) -->
        <section class="py-20 bg-[#f6f1e2]" id="kontak">
            <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 border border-[#2b2417]/16 rounded-3xl overflow-hidden shadow-xl bg-white">
                    
                    <!-- Left Info Column -->
                    <div class="lg:col-span-5 p-8 sm:p-10 bg-[#2c3821] text-[#f6f1e2] flex flex-col justify-between space-y-6">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                                <Phone class="w-3.5 h-3.5" />
                                <span>Kontak Sekretariat</span>
                            </div>
                            <h2 class="font-fraunces font-bold text-white text-3xl sm:text-4xl leading-tight">
                                Mari Terhubung
                            </h2>
                            <p class="mt-2 text-[#f6f1e2]/85 text-xs sm:text-sm leading-relaxed">
                                Terbuka untuk kolaborasi edukasi lingkungan, sedekah sampah, maupun pemesanan produk olahan minyak jelantah.
                            </p>
                        </div>

                        <div class="space-y-4 text-xs sm:text-sm">
                            <div class="flex items-start gap-3">
                                <MapPin class="w-5 h-5 text-[#c1852c] shrink-0 mt-0.5" />
                                <div>
                                    <span class="block text-[#93a869] text-[11px] font-bold uppercase tracking-wider">Alamat Kantor</span>
                                    <span>Ruko Komplek Masjid Abdurrahman Basuri, Jl. MT Haryono, Sindang – Indramayu</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <Phone class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" />
                                <div>
                                    <span class="block text-[#93a869] text-[11px] font-bold uppercase tracking-wider">Telepon / WhatsApp Layanan</span>
                                    <span class="font-bold text-white">+{{ displayContacts[0]?.phone || '628112442322' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Dynamic Contacts List from Database -->
                    <div class="lg:col-span-7 p-6 sm:p-8 bg-[#fbf8ef] space-y-4">
                        <h3 class="font-fraunces font-bold text-lg text-[#2c3821] mb-2">
                            Daftar Penanggung Jawab (PIC) Layanan
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div
                                v-for="c in displayContacts"
                                :key="c.id"
                                class="p-4 bg-white rounded-xl border border-[#2b2417]/16 shadow-2xs flex flex-col justify-between space-y-3"
                            >
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#c1852c] block mb-0.5">
                                        {{ c.role || 'Pengelola BIL' }}
                                    </span>
                                    <h4 class="font-fraunces font-bold text-sm text-[#2c3821]">{{ c.name }}</h4>
                                </div>

                                <a
                                    :href="`https://wa.me/${(c.phone || '').replace(/[^0-9]/g, '')}`"
                                    target="_blank"
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:underline"
                                >
                                    <MessageSquare class="w-3.5 h-3.5" />
                                    <span>Hubungi +{{ c.phone }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- LIGHTBOX MODAL -->
        <div
            v-if="selectedLightboxItem"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/86 backdrop-blur-xs"
            @click.self="closeLightbox"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-3xl w-full overflow-hidden shadow-2xl border border-[#2b2417]/16">
                <button
                    @click="closeLightbox"
                    class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-black/60 text-white flex items-center justify-center text-lg hover:bg-black/85 transition-colors"
                >
                    <X class="w-5 h-5" />
                </button>

                <div class="h-80 sm:h-96 bg-slate-900 overflow-hidden flex items-center justify-center">
                    <img
                        :src="getPrimaryImage(selectedLightboxItem, 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop')"
                        :alt="selectedLightboxItem.title"
                        class="w-full h-full object-contain"
                    />
                </div>

                <div class="p-6 bg-[#fbf8ef] text-[#2b2417] border-t border-[#2b2417]/16 space-y-2">
                    <span class="px-3 py-1 rounded-full bg-[#2c3821] text-[#fbf8ef] text-[10px] font-bold uppercase tracking-wider inline-block">
                        {{ selectedLightboxItem.category?.name || 'Program' }}
                    </span>
                    <h3 class="font-fraunces font-bold text-xl text-[#2c3821]">
                        {{ selectedLightboxItem.title }}
                    </h3>
                    <p v-if="selectedLightboxItem.description" class="text-xs text-slate-700 leading-relaxed">
                        {{ selectedLightboxItem.description }}
                    </p>
                    <div class="pt-2 text-xs font-semibold text-slate-500 flex items-center gap-4">
                        <span class="flex items-center gap-1"><MapPin class="w-3.5 h-3.5 text-[#c1852c]" /> {{ selectedLightboxItem.location }}</span>
                    </div>
                </div>
            </div>
        </div>

    </PublicLayout>
</template>
