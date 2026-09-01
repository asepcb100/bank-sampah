<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Image,
    Edit3,
    Trash2,
    Calendar,
    MapPin,
    Tag,
    CheckCircle2,
    Clock,
    Check,
    AlertTriangle,
    Eye
} from '@lucide/vue';
import { ref, computed } from 'vue';

interface CategoryItem {
    id: number;
    name: string;
}

interface GalleryImageItem {
    id: number;
    image_url: string;
    caption?: string;
    is_primary: boolean;
}

interface GalleryItem {
    id: number;
    title: string;
    category_id?: number;
    category?: CategoryItem;
    location: string;
    event_date: string;
    image_url: string;
    images?: GalleryImageItem[];
    description?: string;
    is_published: boolean;
    created_at?: string;
}

const props = defineProps<{
    gallery?: GalleryItem;
}>();

const initialGallery = props.gallery || {
    id: 1,
    title: 'Program Penimbangan & Sedekah Sampah Rutin Pekan Pertama',
    category: { id: 1, name: 'Program' },
    location: 'Balai Desa Karangampel, Indramayu',
    event_date: '2026-08-15',
    image_url: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop',
    images: [
        {
            id: 1,
            image_url: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop',
            is_primary: true
        },
        {
            id: 2,
            image_url: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop',
            is_primary: false
        },
        {
            id: 3,
            image_url: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
            is_primary: false
        }
    ],
    description: 'Kegiatan rutin bulanan penimbangan dan penyetoran sedekah sampah anorganik oleh warga desa Karangampel. Sampah yang dikumpulkan meliputi botol plastik, minyak jelantah, kertas, dan kardus bekas.',
    is_published: true,
    created_at: '2026-08-15'
};

const allPhotos = computed<GalleryImageItem[]>(() => {
    if (initialGallery.images && initialGallery.images.length > 0) {
        return initialGallery.images;
    }
    return [
        {
            id: 1,
            image_url: initialGallery.image_url,
            is_primary: true
        }
    ];
});

// Active Selected Image for Main Preview Box
const activePhotoUrl = ref<string>(
    allPhotos.value.find(p => p.is_primary)?.image_url || allPhotos.value[0]?.image_url || initialGallery.image_url
);

// Delete Modal State
const showDeleteModal = ref(false);

function deleteGallery() {
    router.delete(`/admin/galeri/${initialGallery.id}`, {
        onFinish: () => {
            showDeleteModal.value = false;
        }
    });
}
</script>

<template>
    <Head :title="`Detail Kegiatan: ${initialGallery.title} — Admin BIL`" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 sm:p-6 bg-[#f6f1e2]/30 rounded-2xl w-full">
        
        <!-- Top Back Link & Action Buttons -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <Link
                href="/admin/galeri"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-2xs"
            >
                <ArrowLeft class="w-4 h-4 text-[#c1852c]" />
                <span>Kembali ke Daftar Galeri</span>
            </Link>

            <div class="flex items-center gap-2">
                <Link
                    :href="`/admin/galeri/${initialGallery.id}/edit`"
                    class="px-4 py-2 bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                >
                    <Edit3 class="w-3.5 h-3.5" />
                    <span>Edit Kegiatan</span>
                </Link>
                <button
                    @click="showDeleteModal = true"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs cursor-pointer"
                >
                    <Trash2 class="w-3.5 h-3.5" />
                    <span>Hapus</span>
                </button>
            </div>
        </div>

        <!-- Header Banner -->
        <div class="bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 sm:p-8 shadow-sm border border-[#2b2417]/16">
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider">
                    <Tag class="w-3.5 h-3.5" />
                    <span>{{ initialGallery.category?.name || 'Program' }}</span>
                </span>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold border border-emerald-500/30">
                    <CheckCircle2 class="w-3.5 h-3.5" />
                    <span>Publik</span>
                </span>
            </div>
            <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white leading-tight">
                {{ initialGallery.title }}
            </h1>
        </div>

        <!-- Key Details Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-[#fbf8ef] p-4 rounded-2xl border border-[#2b2417]/16 shadow-2xs flex items-center gap-3">
                <div class="p-2.5 rounded-xl bg-[#c1852c]/10 text-[#c1852c] shrink-0">
                    <Calendar class="w-5 h-5" />
                </div>
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pelaksanaan</span>
                    <span class="font-semibold text-xs sm:text-sm text-slate-800">{{ initialGallery.event_date }}</span>
                </div>
            </div>

            <div class="bg-[#fbf8ef] p-4 rounded-2xl border border-[#2b2417]/16 shadow-2xs flex items-center gap-3">
                <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-700 shrink-0">
                    <MapPin class="w-5 h-5" />
                </div>
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Lokasi Pelaksanaan</span>
                    <span class="font-semibold text-xs sm:text-sm text-slate-800">{{ initialGallery.location }}</span>
                </div>
            </div>

            <div class="bg-[#fbf8ef] p-4 rounded-2xl border border-[#2b2417]/16 shadow-2xs flex items-center gap-3">
                <div class="p-2.5 rounded-xl bg-blue-50 text-blue-700 shrink-0">
                    <Image class="w-5 h-5" />
                </div>
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Galeri Media Foto</span>
                    <span class="font-semibold text-xs sm:text-sm text-slate-800">{{ allPhotos.length }} Foto Terunggah</span>
                </div>
            </div>
        </div>

        <!-- Main Showcase & Multi-Photo Gallery Showcase -->
        <div class="bg-white rounded-2xl border border-[#2b2417]/16 p-6 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="font-fraunces font-bold text-lg text-[#2c3821]">Dokumentasi Foto Kegiatan</h2>
                <span class="text-xs text-slate-500 font-medium">Klik foto di bawah untuk memperbesar pratinjau</span>
            </div>

            <!-- Large Hero Active Photo Box -->
            <div class="relative w-full h-80 sm:h-96 rounded-2xl overflow-hidden bg-slate-900 border border-slate-200 shadow-sm">
                <img :src="activePhotoUrl" :alt="initialGallery.title" class="w-full h-full object-contain" />
            </div>

            <!-- Thumbnails Row -->
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button
                    v-for="(photo, idx) in allPhotos"
                    :key="photo.id"
                    type="button"
                    @click="activePhotoUrl = photo.image_url"
                    class="relative group w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden border-2 transition-all bg-slate-100 cursor-pointer"
                    :class="[
                        activePhotoUrl === photo.image_url ? 'border-emerald-500 ring-2 ring-emerald-500/30 scale-105' : 'border-slate-200 opacity-70 hover:opacity-100'
                    ]"
                >
                    <img :src="photo.image_url" alt="Foto Dokumentasi" class="w-full h-full object-cover" />
                    
                    <div v-if="photo.is_primary" class="absolute top-1 left-1 px-1.5 py-0.5 rounded-full bg-emerald-600 text-white text-[8px] font-bold shadow-2xs flex items-center gap-0.5">
                        <Check class="w-2.5 h-2.5" />
                        <span>UTAMA</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Deskripsi Lengkap Kegiatan -->
        <div class="bg-[#fbf8ef] rounded-2xl border border-[#2b2417]/16 p-6 shadow-xs">
            <h2 class="font-fraunces font-bold text-lg text-[#2c3821] mb-3">Deskripsi Lengkap Kegiatan</h2>
            <p v-if="initialGallery.description" class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                {{ initialGallery.description }}
            </p>
            <p v-else class="text-xs text-slate-400 italic">
                Belum ada deskripsi kegiatan yang dituliskan.
            </p>
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/80 backdrop-blur-xs"
            @click.self="showDeleteModal = false"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-md w-full p-6 shadow-2xl border border-[#2b2417]/16 text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 mx-auto flex items-center justify-center mb-4">
                    <AlertTriangle class="w-6 h-6" />
                </div>

                <h3 class="font-fraunces font-bold text-lg text-[#2c3821] mb-2">Konfirmasi Hapus Kegiatan</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-6">
                    Apakah Anda yakin ingin menghapus kegiatan <span class="font-semibold text-slate-900">"{{ initialGallery.title }}"</span>? Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex items-center justify-center gap-3">
                    <button
                        @click="showDeleteModal = false"
                        class="flex-1 py-2.5 rounded-full border border-slate-200 text-slate-700 bg-white hover:bg-slate-100 text-xs font-semibold transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        @click="deleteGallery"
                        class="flex-1 py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-md transition-colors"
                    >
                        Ya, Hapus Kegiatan
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>
