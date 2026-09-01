<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    ArrowLeft,
    MapPin,
    Tag,
    FileText,
    Share2,
    Eye,
    Layers
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
    slug?: string;
    category?: CategoryItem;
    location: string;
    event_date: string;
    image_url: string;
    images?: GalleryImageItem[];
    description?: string;
}

const props = defineProps<{
    gallery: GalleryItem;
    related?: GalleryItem[];
}>();

const galleryImages = computed(() => {
    if (props.gallery.images && props.gallery.images.length > 0) {
        return props.gallery.images.map(img => img.image_url);
    }
    return [props.gallery.image_url || 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop'];
});

const activeImageIndex = ref(0);
const activeImageUrl = computed(() => galleryImages.value[activeImageIndex.value]);

const pageUrl = computed(() => typeof window !== 'undefined' ? window.location.href : '');

function copyShareLink() {
    if (typeof window !== 'undefined') {
        navigator.clipboard.writeText(window.location.href);
        alert('Tautan kegiatan berhasil disalin!');
    }
}
</script>

<template>
    <Head>
        <title>{{ gallery.title }} — Galeri Kegiatan Bumi Indramayu Lestari</title>

        <!-- SEO Standard Meta Tags -->
        <meta name="description" :content="gallery.description || `Dokumentasi resmi kegiatan ${gallery.title} oleh Bank Sampah Bumi Indramayu Lestari.`" />
        <meta name="keywords" :content="`kegiatan, ${gallery.category?.name || 'program'}, bank sampah, indramayu, ${gallery.title}, ${gallery.location}`" />
        <meta name="robots" content="index, follow" />

        <!-- OpenGraph Meta Tags (WhatsApp, Facebook, LinkedIn) -->
        <meta property="og:type" content="article" />
        <meta property="og:title" :content="gallery.title" />
        <meta property="og:description" :content="gallery.description || `Dokumentasi kegiatan ${gallery.title} di ${gallery.location}.`" />
        <meta property="og:image" :content="activeImageUrl" />
        <meta property="og:url" :content="pageUrl" />
        <meta property="og:site_name" content="Bumi Indramayu Lestari" />

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="gallery.title" />
        <meta name="twitter:description" :content="gallery.description || `Dokumentasi kegiatan ${gallery.title} di ${gallery.location}.`" />
        <meta name="twitter:image" :content="activeImageUrl" />
    </Head>

    <PublicLayout>
        <div class="max-w-[1180px] mx-auto px-6 sm:px-8 py-10">
            
            <!-- Back Navigation Link -->
            <div class="mb-6">
                <Link
                    href="/galeri"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#fbf8ef] border border-[#2b2417]/16 text-xs font-semibold text-[#2c3821] hover:bg-[#e9c688]/30 transition-colors shadow-2xs"
                >
                    <ArrowLeft class="w-4 h-4 text-[#c1852c]" />
                    <span>Kembali ke Galeri Kegiatan</span>
                </Link>
            </div>

            <!-- Detail Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
                
                <!-- Left Main Photo Viewer (8 Cols) -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="relative bg-slate-900 rounded-2xl overflow-hidden aspect-[4/3] sm:aspect-[16/10] border border-[#2b2417]/16 shadow-lg group">
                        <img
                            :src="activeImageUrl"
                            :alt="gallery.title"
                            class="w-full h-full object-cover transition-transform duration-500"
                        />
                        <span class="absolute top-4 left-4 bg-[#2c3821]/90 text-[#fbf8ef] text-xs font-bold px-3.5 py-1 rounded-full backdrop-blur-2xs uppercase tracking-wider">
                            {{ gallery.category?.name || 'Kegiatan Warga' }}
                        </span>
                    </div>

                    <!-- Gallery Thumbnails (If multiple photos exist) -->
                    <div v-if="galleryImages.length > 1" class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
                        <button
                            v-for="(imgUrl, idx) in galleryImages"
                            :key="idx"
                            @click="activeImageIndex = idx"
                            class="relative w-20 h-20 rounded-xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer"
                            :class="[activeImageIndex === idx ? 'border-[#c1852c] ring-2 ring-[#c1852c]/40 scale-95' : 'border-transparent opacity-70 hover:opacity-100']"
                        >
                            <img :src="imgUrl" :alt="`Foto ${idx + 1}`" class="w-full h-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Right Detail Card Sidebar (4 Cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-[#fbf8ef] rounded-2xl p-6 sm:p-8 border border-[#2b2417]/16 shadow-2xs space-y-5">
                        
                        <div class="space-y-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#c1852c]">
                                {{ gallery.category?.name || 'Program' }}
                            </span>
                            <h1 class="font-fraunces font-bold text-2xl text-[#2c3821] leading-tight">
                                {{ gallery.title }}
                            </h1>
                        </div>

                        <!-- Location Metadata -->
                        <div class="p-3.5 bg-white rounded-xl border border-[#2b2417]/10 flex items-center gap-3 text-xs text-slate-700">
                            <MapPin class="w-5 h-5 text-[#c1852c] shrink-0" />
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Lokasi Kegiatan</span>
                                <span class="font-bold text-[#2c3821]">{{ gallery.location }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2 pt-2 border-t border-[#2b2417]/10">
                            <h3 class="font-fraunces font-bold text-sm text-[#2c3821]">Deskripsi Kegiatan</h3>
                            <p class="text-xs text-[#54493a] leading-relaxed whitespace-pre-line font-medium">
                                {{ gallery.description || 'Dokumentasi kegiatan resmi Bank Sampah Bumi Indramayu Lestari bersama warga.' }}
                            </p>
                        </div>

                        <!-- Share Button -->
                        <div class="pt-3">
                            <button
                                @click="copyShareLink"
                                class="w-full py-2.5 bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] rounded-full text-xs font-bold flex items-center justify-center gap-2 transition-colors shadow-2xs cursor-pointer"
                            >
                                <Share2 class="w-4 h-4 text-[#c1852c]" />
                                <span>Bagikan Tautan Kegiatan</span>
                            </button>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Related Galleries Section -->
            <div v-if="related && related.length > 0" class="pt-8 border-t border-[#2b2417]/16">
                <h3 class="font-fraunces font-bold text-2xl text-[#2c3821] mb-6">
                    Dokumentasi Kegiatan Lainnya
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <Link
                        v-for="rel in related"
                        :key="rel.id"
                        :href="`/galeri/${rel.slug || rel.id}`"
                        class="group bg-[#fbf8ef] rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between"
                    >
                        <div>
                            <div class="h-44 bg-slate-100 overflow-hidden relative">
                                <img :src="rel.image_url || 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop'" :alt="rel.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                <span class="absolute top-3 left-3 bg-[#2c3821] text-[#fbf8ef] text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ rel.category?.name || 'Program' }}
                                </span>
                            </div>
                            <div class="p-4 space-y-1">
                                <h4 class="font-fraunces font-bold text-sm text-[#2c3821] group-hover:text-[#c1852c] transition-colors line-clamp-2">
                                    {{ rel.title }}
                                </h4>
                            </div>
                        </div>

                        <div class="p-3 bg-white border-t border-slate-100 text-xs text-slate-600 flex items-center gap-1 font-medium">
                            <MapPin class="w-3.5 h-3.5 text-[#c1852c]" />
                            <span class="truncate">{{ rel.location }}</span>
                        </div>
                    </Link>
                </div>
            </div>

        </div>
    </PublicLayout>
</template>
