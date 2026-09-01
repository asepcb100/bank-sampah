<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Search,
    SlidersHorizontal,
    ChevronDown,
    MapPin,
    Calendar,
    FileText,
    Package,
    HeartHandshake,
    GraduationCap,
    Layers,
    ChevronLeft,
    ChevronRight,
    X,
    ZoomIn,
    Leaf,
    Eye
} from '@lucide/vue';

interface CategoryItem {
    id: number;
    name: string;
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

const props = defineProps<{
    galleries?: GalleryItem[];
    categories?: CategoryItem[];
}>();

const activeCategory = ref<string>('Semua');
const searchQuery = ref<string>('');
const selectedItem = ref<GalleryItem | null>(null);

function getPrimaryImage(item: any): string {
    if (item?.images && item.images.length > 0) {
        const primary = item.images.find((img: any) => img.is_primary);
        if (primary && primary.image_url) return primary.image_url;
        return item.images[0].image_url;
    }
    return item?.image_url || 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop';
}

const defaultGalleries: GalleryItem[] = [
    {
        id: 1,
        title: 'Program Penimbangan & Sedekah Sampah Rutin',
        category: { id: 1, name: 'Program' },
        location: 'Balai Desa Karangampel',
        event_date: '2026-08-15',
        image_url: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop',
        description: 'Kegiatan rutin bulanan penimbangan dan penyetoran sedekah sampah anorganik.'
    },
    {
        id: 2,
        title: 'Pelatihan Pembuatan Sabun Minyak Jelantah',
        category: { id: 2, name: 'Produk' },
        location: 'Sanggar Daur Ulang BIL',
        event_date: '2026-08-10',
        image_url: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
        description: 'Pelatihan olahan limbah minyak goreng bekas menjadi sabun padat alami.'
    },
    {
        id: 3,
        title: 'Kolaborasi PKK Margadadi',
        category: { id: 3, name: 'Kolaborasi' },
        location: 'Kec. Indramayu',
        event_date: '2026-08-05',
        image_url: 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=800&auto=format&fit=crop',
        description: 'Sinergi program pemilahan sampah dapur bersama penggerak PKK.'
    }
];

const listGalleries = computed(() => {
    const data = props.galleries && props.galleries.length > 0 ? props.galleries : defaultGalleries;
    return data.filter(item => {
        const catName = item.category?.name || 'Program';
        const matchesCategory = activeCategory.value === 'Semua' || catName === activeCategory.value;
        const matchesQuery = searchQuery.value === '' || 
            item.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.location.toLowerCase().includes(searchQuery.value.toLowerCase());
        return matchesCategory && matchesQuery;
    });
});

const categoryPills = computed(() => {
    const dbCats = props.categories && props.categories.length > 0 ? props.categories.map(c => c.name) : ['Program', 'Produk', 'Kolaborasi', 'Edukasi'];
    return ['Semua', ...Array.from(new Set(dbCats))];
});

function openLightbox(item: GalleryItem) {
    selectedItem.value = item;
}

function closeLightbox() {
    selectedItem.value = null;
}
</script>

<template>
    <Head title="Galeri Kegiatan — Bumi Indramayu Lestari" />

    <PublicLayout>
        <div class="max-w-[1180px] mx-auto px-6 sm:px-8 py-10">
            
            <!-- Page Header Section -->
            <div class="relative bg-[#fbf8ef] rounded-2xl p-8 sm:p-10 mb-8 border border-[#2b2417]/16 overflow-hidden shadow-2xs">
                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-2">
                        <FileText class="w-3.5 h-3.5" />
                        <span>Dokumentasi Komunitas</span>
                    </div>
                    <h1 class="font-fraunces font-bold text-3xl sm:text-4xl text-[#2c3821] tracking-tight mb-2.5">
                        Galeri Kegiatan Warga
                    </h1>
                    <p class="text-[#5a5040] text-sm sm:text-base leading-relaxed">
                        Dokumentasi asli program penimbangan bank sampah, edukasi lingkungan, dan kolaborasi bersama mitra di Kabupaten Indramayu.
                    </p>
                </div>
            </div>

            <!-- Controls Bar: Category Tabs + Search Bar -->
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 mb-8">
                
                <!-- Category Pill Buttons -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
                    <button
                        v-for="cat in categoryPills"
                        :key="cat"
                        @click="activeCategory = cat"
                        type="button"
                        class="px-5 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all duration-200 focus:outline-none cursor-pointer"
                        :class="[
                            activeCategory === cat
                                ? 'bg-[#2c3821] text-[#fbf8ef] border border-[#2c3821] shadow-xs'
                                : 'bg-[#fbf8ef] text-[#2b2417] hover:bg-[#e9c688]/30 border border-[#2b2417]/16'
                        ]"
                    >
                        <span>{{ cat }}</span>
                    </button>
                </div>

                <!-- Search Bar -->
                <div class="relative sm:w-72">
                    <Search class="w-4 h-4 text-[#5a5040] absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Cari kegiatan atau lokasi..."
                        class="w-full pl-10 pr-4 py-2.5 bg-[#fbf8ef] rounded-full text-xs font-semibold text-[#2b2417] border border-[#2b2417]/16 focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs"
                    />
                </div>
            </div>

            <!-- Gallery Grid Cards -->
            <div v-if="listGalleries.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <div
                    v-for="item in listGalleries"
                    :key="item.id"
                    class="group bg-[#fbf8ef] rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
                >
                    <!-- Thumbnail Container with Link to Detail Page -->
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-900 cursor-pointer" @click="openLightbox(item)">
                        <img
                            :src="getPrimaryImage(item)"
                            :alt="item.title"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                        
                        <!-- Floating Category Badge -->
                        <div class="absolute top-3 left-3 bg-[#2c3821]/90 text-[#fbf8ef] px-3 py-1 rounded-full border border-[#2b2417]/20 text-[10px] font-bold uppercase tracking-wider backdrop-blur-2xs shadow-xs">
                            {{ item.category?.name || 'Program' }}
                        </div>

                        <!-- Hover Zoom Icon Overlay -->
                        <div class="absolute inset-0 bg-[#2c3821]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="w-10 h-10 rounded-full bg-[#fbf8ef] text-[#2c3821] flex items-center justify-center shadow-md">
                                <ZoomIn class="w-5 h-5" />
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex flex-col justify-between flex-1">
                        <Link :href="`/galeri/${item.slug || item.id}`" class="block group-hover:text-[#c1852c] transition-colors mb-3">
                            <h3 class="font-fraunces font-bold text-[#2c3821] text-base leading-snug line-clamp-2">
                                {{ item.title }}
                            </h3>
                        </Link>

                        <div class="pt-3 border-t border-[#2b2417]/10 flex items-center justify-between text-xs text-slate-600">
                            <div class="flex items-center gap-1 font-medium">
                                <MapPin class="w-3.5 h-3.5 text-[#c1852c]" />
                                <span class="truncate max-w-[150px]">{{ item.location }}</span>
                            </div>

                            <Link
                                :href="`/galeri/${item.slug || item.id}`"
                                class="inline-flex items-center gap-1 text-[11px] font-bold text-[#2c3821] hover:text-[#c1852c] transition-colors"
                            >
                                <Eye class="w-3.5 h-3.5" />
                                <span>Detail</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="bg-[#fbf8ef] rounded-2xl p-12 text-center border border-[#2b2417]/16 my-8">
                <Leaf class="w-12 h-12 text-[#93a869] mx-auto mb-3" />
                <h3 class="font-fraunces font-bold text-[#2c3821] text-lg mb-1">Tidak Ada Kegiatan Ditemukan</h3>
                <p class="text-xs text-[#5a5040] max-w-sm mx-auto">Coba ubah kata kunci pencarian atau pilih filter kategori lainnya.</p>
            </div>

            <!-- Lightbox / Preview Modal -->
            <div
                v-if="selectedItem"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/86 backdrop-blur-xs"
                @click.self="closeLightbox"
            >
                <div class="relative bg-[#fbf8ef] rounded-2xl max-w-2xl w-full max-h-[85vh] overflow-hidden shadow-2xl border border-[#2b2417]/16 flex flex-col">
                    <button
                        @click="closeLightbox"
                        class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-[#141008]/60 text-[#f6f1e2] flex items-center justify-center hover:bg-[#141008]/85 transition-colors shadow-md"
                    >
                        <X class="w-5 h-5" />
                    </button>

                    <div class="aspect-[16/10] bg-[#2c3821] relative max-h-[45vh] overflow-hidden flex-shrink-0">
                        <img :src="getPrimaryImage(selectedItem)" :alt="selectedItem.title" class="w-full h-full object-cover" />
                        <div class="absolute bottom-4 left-4 bg-[#2c3821] text-[#f6f1e2] px-3 py-1 rounded-full border border-[#2b2417]/20 text-xs font-bold uppercase tracking-wider">
                            {{ selectedItem.category?.name || 'Program' }}
                        </div>
                    </div>

                    <div class="p-6 overflow-y-auto flex-1 space-y-4">
                        <div class="flex items-center gap-1.5 text-[#5a5040] text-xs font-bold">
                            <MapPin class="w-4 h-4 text-[#c1852c]" />
                            <span>{{ selectedItem.location }}</span>
                        </div>
                        
                        <h2 class="font-fraunces font-bold text-xl text-[#2c3821]">{{ selectedItem.title }}</h2>
                        
                        <p v-if="selectedItem.description" class="text-[#54493a] text-xs leading-relaxed">
                            {{ selectedItem.description }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-[#2b2417]/10">
                            <Link
                                :href="`/galeri/${selectedItem.slug || selectedItem.id}`"
                                class="px-5 py-2.5 bg-[#c1852c] text-white rounded-full text-xs font-bold hover:bg-[#a67022] transition-colors"
                            >
                                Buka Halaman Show Detail →
                            </Link>

                            <button
                                @click="closeLightbox"
                                class="px-5 py-2.5 bg-slate-200 text-slate-800 rounded-full text-xs font-semibold hover:bg-slate-300 transition-colors"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </PublicLayout>
</template>
