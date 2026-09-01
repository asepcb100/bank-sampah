<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Image,
    Save,
    Calendar,
    MapPin,
    Link as LinkIcon,
    FileText,
    Check,
    Plus,
    X,
    Star,
    ChevronDown,
    FolderPlus,
    Upload,
    CheckCircle2,
    AlertCircle,
    ClipboardCheck
} from '@lucide/vue';
import { reactive, computed, ref } from 'vue';

interface CategoryItem {
    id: number;
    name: string;
}

interface PhotoMedia {
    id: number;
    url: string;
    file?: File;
    is_primary: boolean;
    label?: string;
}

interface GalleryItem {
    id: number;
    title: string;
    category_id?: number;
    location: string;
    event_date: string;
    image_url: string;
    description?: string;
    is_published: boolean;
}

const props = defineProps<{
    gallery?: GalleryItem;
    categories?: CategoryItem[];
    errors?: Record<string, string>;
}>();

const defaultCategories = [
    { id: 1, name: 'Program' },
    { id: 2, name: 'Produk' },
    { id: 3, name: 'Kolaborasi' },
    { id: 4, name: 'Edukasi' }
];

const availableCategoriesList = ref<CategoryItem[]>(
    props.categories && props.categories.length > 0 ? [...props.categories] : defaultCategories
);

// Add Category Modal States
const showAddCategoryModal = ref(false);
const newCategoryName = ref('');
const newCategoryType = ref('galeri');

function saveCategory() {
    if (!newCategoryName.value.trim()) return;
    const newId = Date.now();
    const newCat = { id: newId, name: newCategoryName.value.trim() };
    availableCategoriesList.value.push(newCat);
    form.category_id = newId;
    newCategoryName.value = '';
    showAddCategoryModal.value = false;
}

const initialData = props.gallery || {
    id: 1,
    title: 'Program Penimbangan & Sedekah Sampah Rutin Pekan Pertama',
    category_id: 1,
    location: 'Balai Desa Karangampel',
    event_date: '2026-08-15',
    image_url: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop',
    description: 'Kegiatan rutin bulanan penimbangan dan penyetoran sedekah sampah anorganik.',
    is_published: true
};

// Multi-photo Media List
const getInitialPhotos = () => {
    if (props.gallery?.images && props.gallery.images.length > 0) {
        return props.gallery.images.map((img: any) => ({
            id: img.id,
            url: img.image_url,
            is_primary: !!img.is_primary
        }));
    }
    return [
        {
            id: 1,
            url: initialData.image_url,
            is_primary: true
        }
    ];
};

const photosList = ref<PhotoMedia[]>(getInitialPhotos());

// Hidden File Input Reference
const fileInputRef = ref<HTMLInputElement | null>(null);
const showAddUrlModal = ref(false);
const newPhotoUrl = ref('');

// Form Summary Confirmation Modal State
const showConfirmModal = ref(false);
const validationError = ref('');
const isSubmitting = ref(false);

function triggerFileInput() {
    fileInputRef.value?.click();
}

function handleFileUpload(event: Event) {
    const target = event.target as HTMLInputElement;
    if (!target.files || target.files.length === 0) return;

    Array.from(target.files).forEach(file => {
        const objectUrl = URL.createObjectURL(file);
        const isFirst = photosList.value.length === 0;
        photosList.value.push({
            id: Date.now() + Math.random(),
            url: objectUrl,
            file: file,
            is_primary: isFirst,
            label: 'BARU'
        });
    });

    target.value = '';
}

function setPrimaryPhoto(index: number) {
    photosList.value.forEach((photo, i) => {
        photo.is_primary = i === index;
    });
}

function removePhoto(index: number) {
    const wasPrimary = photosList.value[index]?.is_primary;
    photosList.value.splice(index, 1);
    if (wasPrimary && photosList.value.length > 0) {
        photosList.value[0].is_primary = true;
    }
}

function addUrlPhoto() {
    if (!newPhotoUrl.value) return;
    const isFirst = photosList.value.length === 0;
    photosList.value.push({
        id: Date.now(),
        url: newPhotoUrl.value,
        is_primary: isFirst,
        label: 'BARU'
    });
    newPhotoUrl.value = '';
    showAddUrlModal.value = false;
}

const form = reactive({
    id: initialData.id,
    title: initialData.title,
    category_id: initialData.category_id || 1,
    location: initialData.location,
    event_date: initialData.event_date,
    description: initialData.description || '',
    is_published: initialData.is_published
});

const selectedCategoryName = computed(() => {
    const cat = availableCategoriesList.value.find(c => c.id === form.category_id);
    return cat ? cat.name : 'Umum';
});

const primaryPhoto = computed(() => {
    return photosList.value.find(p => p.is_primary) || photosList.value[0] || null;
});

function openConfirmModal() {
    validationError.value = '';
    if (!form.title.trim()) {
        validationError.value = 'Judul kegiatan wajib diisi!';
        return;
    }
    if (!form.location.trim()) {
        validationError.value = 'Lokasi pelaksanaan wajib diisi!';
        return;
    }
    if (!form.event_date) {
        validationError.value = 'Tanggal pelaksanaan wajib diisi!';
        return;
    }
    showConfirmModal.value = true;
}

function submitForm() {
    isSubmitting.value = true;
    const primaryImg = primaryPhoto.value ? primaryPhoto.value.url : '';

    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('title', form.title);
    formData.append('category_id', String(form.category_id));
    formData.append('location', form.location);
    formData.append('event_date', form.event_date);
    formData.append('description', form.description || '');
    formData.append('is_published', form.is_published ? '1' : '0');
    formData.append('image_url', primaryImg);

    photosList.value.forEach((photo, idx) => {
        if (photo.file) {
            formData.append(`photos[${idx}][file]`, photo.file);
        }
        formData.append(`photos[${idx}][url]`, photo.url);
        formData.append(`photos[${idx}][is_primary]`, photo.is_primary ? '1' : '0');
    });

    router.post(`/admin/galeri/${form.id}`, formData, {
        forceFormData: true,
        onFinish: () => {
            isSubmitting.value = false;
            showConfirmModal.value = false;
        }
    });
}
</script>

<template>
    <Head :title="`Edit Kegiatan: ${form.title} — Admin BIL`" />

    <!-- Hidden Native File Input -->
    <input
        ref="fileInputRef"
        type="file"
        accept="image/*"
        multiple
        @change="handleFileUpload"
        class="hidden"
    />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 sm:p-6 bg-[#f6f1e2]/30 rounded-2xl w-full">
        
        <!-- Top Back Link -->
        <div class="flex items-center justify-between">
            <Link
                href="/admin/galeri"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-2xs"
            >
                <ArrowLeft class="w-4 h-4 text-[#c1852c]" />
                <span>Kembali ke Daftar Galeri</span>
            </Link>
        </div>

        <!-- Header Banner -->
        <div class="bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 sm:p-8 shadow-sm border border-[#2b2417]/16">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-semibold mb-2">
                <Image class="w-3.5 h-3.5" />
                <span>Edit Kegiatan</span>
            </div>
            <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white">Edit Dokumentasi Kegiatan</h1>
            <p class="text-xs sm:text-sm text-[#f6f1e2]/85 mt-1">Perbarui data atau ubah foto dokumentasi kegiatan ini.</p>
        </div>

        <!-- Inline Validation Alert -->
        <div v-if="validationError" class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3 text-red-700 text-xs font-semibold">
            <AlertCircle class="w-5 h-5 shrink-0 text-red-600" />
            <span>{{ validationError }}</span>
        </div>

        <!-- Form Card -->
        <div class="bg-[#fbf8ef] rounded-2xl p-6 sm:p-8 border border-[#2b2417]/16 shadow-xs w-full">
            <form @submit.prevent="openConfirmModal" class="space-y-6">
                
                <!-- Judul Kegiatan -->
                <div>
                    <label class="block font-fraunces font-semibold text-sm text-[#2c3821] mb-1.5">
                        Judul Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="form.title"
                        type="text"
                        required
                        class="w-full px-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none shadow-2xs"
                    />
                </div>

                <!-- Grid Kategori & Tanggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block font-semibold text-xs text-[#2c3821]">Kategori Kegiatan</label>
                            <button
                                type="button"
                                @click="showAddCategoryModal = true"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#c1852c] hover:text-[#a67022] hover:underline cursor-pointer"
                            >
                                <Plus class="w-3.5 h-3.5" />
                                <span>Tambah Kategori Baru</span>
                            </button>
                        </div>

                        <div class="relative">
                            <select
                                v-model="form.category_id"
                                class="w-full px-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none appearance-none cursor-pointer pr-10 font-semibold"
                            >
                                <option v-for="cat in availableCategoriesList" :key="cat.id" :value="cat.id">
                                    {{ cat.name }}
                                </option>
                            </select>
                            <ChevronDown class="w-4 h-4 text-slate-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">
                            Tanggal Pelaksanaan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <Calendar class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.event_date"
                                type="date"
                                required
                                class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none font-semibold"
                            />
                        </div>
                    </div>
                </div>

                <!-- Lokasi Pelaksanaan -->
                <div>
                    <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">
                        Lokasi Pelaksanaan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <MapPin class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                        <input
                            v-model="form.location"
                            type="text"
                            required
                            class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none"
                        />
                    </div>
                </div>

                <!-- GALERI MEDIA MULTI-PHOTO UPLOAD & PREVIEW SECTION -->
                <div class="p-5 bg-white rounded-2xl border border-[#2b2417]/16 shadow-2xs">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600">
                                <Image class="w-4 h-4" />
                            </div>
                            <span class="font-fraunces font-bold text-xs sm:text-sm tracking-wider uppercase text-slate-700">
                                GALERI MEDIA
                            </span>
                            <span class="text-[11px] text-slate-500 font-medium">({{ photosList.length }} Foto Terunggah)</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="showAddUrlModal = true"
                                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors cursor-pointer"
                                title="Tambah Via URL"
                            >
                                <LinkIcon class="w-3.5 h-3.5" />
                                <span>Input URL</span>
                            </button>
                            <button
                                type="button"
                                @click="triggerFileInput"
                                class="px-4 py-1.5 bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors cursor-pointer shadow-2xs"
                            >
                                <Upload class="w-3.5 h-3.5" />
                                <span>Upload File Foto</span>
                            </button>
                        </div>
                    </div>

                    <!-- Scrollable / Flex Wrap Photo Thumbnails Row -->
                    <div class="flex flex-wrap items-center gap-3.5">
                        <div
                            v-for="(photo, idx) in photosList"
                            :key="photo.id"
                            class="relative group w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden border-2 transition-all bg-slate-100 shadow-xs"
                            :class="[
                                photo.is_primary ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200 hover:border-emerald-300'
                            ]"
                        >
                            <img :src="photo.url" alt="Foto Dokumentasi" class="w-full h-full object-cover" />

                            <!-- Primary Badge (UTAMA) -->
                            <div v-if="photo.is_primary" class="absolute top-1.5 left-1.5 z-10 px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[9px] font-bold shadow-xs flex items-center gap-1">
                                <Check class="w-3 h-3" />
                                <span>UTAMA</span>
                            </div>

                            <!-- Additional Photo Badge (BARU) -->
                            <div v-else-if="photo.label" class="absolute top-0 right-0 z-10 px-2 py-0.5 rounded-bl-lg bg-emerald-500 text-white text-[9px] font-black uppercase tracking-wider">
                                {{ photo.label }}
                            </div>

                            <!-- Action Overlay on Hover -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 z-20">
                                <button
                                    type="button"
                                    @click="setPrimaryPhoto(idx)"
                                    class="w-8 h-8 rounded-full bg-white text-emerald-600 hover:bg-emerald-50 flex items-center justify-center shadow-md transition-transform hover:scale-110 cursor-pointer"
                                    title="Jadikan Foto Utama Cover"
                                >
                                    <Star class="w-4 h-4 fill-emerald-600" />
                                </button>
                                <button
                                    type="button"
                                    @click="removePhoto(idx)"
                                    class="w-8 h-8 rounded-full bg-red-500 text-white hover:bg-red-600 flex items-center justify-center shadow-md transition-transform hover:scale-110 cursor-pointer"
                                    title="Hapus Foto"
                                >
                                    <X class="w-4 h-4" />
                                </button>
                            </div>
                        </div>

                        <!-- Plus Add Photo Card -->
                        <button
                            type="button"
                            @click="triggerFileInput"
                            class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl border-2 border-dashed border-slate-300 hover:border-[#c1852c] bg-slate-50 hover:bg-white flex flex-col items-center justify-center text-slate-400 hover:text-[#c1852c] transition-all cursor-pointer group shadow-2xs"
                        >
                            <Plus class="w-8 h-8 group-hover:scale-110 transition-transform" />
                            <span class="text-[10px] font-semibold mt-1">Upload File</span>
                        </button>
                    </div>
                </div>

                <!-- Deskripsi Kegiatan -->
                <div>
                    <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">Deskripsi Kegiatan</label>
                    <textarea
                        v-model="form.description"
                        rows="4"
                        class="w-full px-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none"
                    ></textarea>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#2b2417]/10">
                    <Link
                        href="/admin/galeri"
                        class="px-6 py-3 rounded-full border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold text-slate-700 transition-colors"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        class="px-6 py-3 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#f6f1e2] text-xs font-semibold flex items-center gap-2 shadow-md transition-all cursor-pointer"
                    >
                        <Save class="w-4 h-4" />
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- FORM SUMMARY CONFIRMATION MODAL -->
        <div
            v-if="showConfirmModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/80 backdrop-blur-xs"
            @click.self="showConfirmModal = false"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-[#2b2417]/16">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700">
                            <ClipboardCheck class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">Konfirmasi Perubahan Kegiatan</h3>
                            <p class="text-[11px] text-slate-500">Periksa kembali ringkasan data sebelum disimpan</p>
                        </div>
                    </div>
                    <button @click="showConfirmModal = false" class="text-slate-400 hover:text-slate-600">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <!-- Form Entries Summary List -->
                <div class="bg-white p-4 rounded-xl border border-[#2b2417]/16 space-y-3.5 text-xs text-slate-700 mb-5 shadow-2xs">
                    
                    <div>
                        <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Judul Kegiatan:</span>
                        <span class="font-fraunces font-semibold text-sm text-[#2c3821] block">{{ form.title }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                        <div>
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Kategori:</span>
                            <span class="inline-flex px-2.5 py-0.5 rounded-full bg-[#2c3821]/10 text-[#2c3821] font-semibold text-[11px]">
                                {{ selectedCategoryName }}
                            </span>
                        </div>

                        <div>
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Tanggal:</span>
                            <span class="font-semibold text-slate-800">{{ form.event_date }}</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Lokasi Pelaksanaan:</span>
                        <span class="font-semibold text-slate-800">{{ form.location }}</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center gap-3">
                        <div v-if="primaryPhoto" class="w-16 h-12 rounded-lg bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                            <img :src="primaryPhoto.url" alt="Cover Utama" class="w-full h-full object-cover" />
                        </div>
                        <div>
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Galeri Media Foto:</span>
                            <span class="font-semibold text-emerald-700 text-xs">{{ photosList.length }} Foto Terunggah (Termasuk Foto Utama)</span>
                        </div>
                    </div>

                    <div v-if="form.description" class="pt-2 border-t border-slate-100">
                        <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Deskripsi Ringkas:</span>
                        <p class="text-slate-600 text-[11px] italic line-clamp-2">"{{ form.description }}"</p>
                    </div>

                </div>

                <!-- Footer Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#2b2417]/10">
                    <button
                        type="button"
                        @click="showConfirmModal = false"
                        class="px-4 py-2.5 rounded-full border border-slate-200 text-slate-700 bg-white hover:bg-slate-100 font-semibold text-xs"
                    >
                        Periksa Kembali
                    </button>
                    <button
                        type="button"
                        @click="submitForm"
                        :disabled="isSubmitting"
                        class="px-6 py-2.5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#f6f1e2] font-semibold text-xs flex items-center gap-2 transition-colors shadow-md cursor-pointer"
                    >
                        <CheckCircle2 class="w-4 h-4 text-emerald-400" />
                        <span>{{ isSubmitting ? 'Menyimpan...' : 'Ya, Simpan Perubahan' }}</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- Add Category Modal Prompt -->
        <div
            v-if="showAddCategoryModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/80 backdrop-blur-xs"
            @click.self="showAddCategoryModal = false"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-md w-full p-6 shadow-2xl border border-[#2b2417]/16">
                <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <FolderPlus class="w-5 h-5 text-[#c1852c]" />
                        <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">Tambah Kategori Baru</h3>
                    </div>
                    <button @click="showAddCategoryModal = false" class="text-slate-400 hover:text-slate-600">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-[#2c3821] mb-1">Nama Kategori Baru <span class="text-red-500">*</span></label>
                        <input
                            v-model="newCategoryName"
                            type="text"
                            placeholder="Contoh: Workshop & Pelatihan"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#2b2417]/20 rounded-xl focus:ring-2 focus:ring-[#c1852c] focus:outline-none text-slate-800 font-semibold"
                            @keyup.enter="saveCategory"
                        />
                    </div>

                    <div>
                        <label class="block font-semibold text-[#2c3821] mb-1">Tipe Kategori</label>
                        <select
                            v-model="newCategoryType"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#2b2417]/20 rounded-xl focus:ring-2 focus:ring-[#c1852c] focus:outline-none"
                        >
                            <option value="galeri">Galeri Kegiatan</option>
                            <option value="katalog">Katalog Produk</option>
                            <option value="semua">Semua Tipe</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#2b2417]/10">
                        <button
                            type="button"
                            @click="showAddCategoryModal = false"
                            class="px-4 py-2 rounded-full border border-slate-200 text-slate-700 bg-white hover:bg-slate-100 font-semibold"
                        >
                            Batal
                        </button>
                        <button
                            type="button"
                            @click="saveCategory"
                            class="px-5 py-2 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#f6f1e2] font-semibold transition-colors shadow-sm cursor-pointer"
                        >
                            Simpan Kategori
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Photo URL Modal Prompt -->
        <div
            v-if="showAddUrlModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/80 backdrop-blur-xs"
            @click.self="showAddUrlModal = false"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-md w-full p-6 shadow-2xl border border-[#2b2417]/16">
                <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3 mb-4">
                    <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">Tambah Foto via URL</h3>
                    <button @click="showAddUrlModal = false" class="text-slate-400 hover:text-slate-600">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-[#2c3821] mb-1">URL / Link Foto Online</label>
                        <input
                            v-model="newPhotoUrl"
                            type="url"
                            placeholder="https://images.unsplash.com/..."
                            class="w-full px-3.5 py-2.5 bg-white border border-[#2b2417]/20 rounded-xl focus:ring-2 focus:ring-[#c1852c] focus:outline-none"
                            @keyup.enter="addUrlPhoto"
                        />
                    </div>

                    <div v-if="newPhotoUrl" class="mt-2">
                        <span class="block text-[11px] font-semibold text-slate-500 mb-1">Pratinjau Foto:</span>
                        <div class="w-full h-36 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                            <img :src="newPhotoUrl" alt="Pratinjau" class="w-full h-full object-cover" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#2b2417]/10">
                        <button
                            type="button"
                            @click="showAddUrlModal = false"
                            class="px-4 py-2 rounded-full border border-slate-200 text-slate-700 bg-white hover:bg-slate-100 font-semibold"
                        >
                            Batal
                        </button>
                        <button
                            type="button"
                            @click="addUrlPhoto"
                            class="px-5 py-2 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#f6f1e2] font-semibold transition-colors shadow-sm"
                        >
                            Tambahkan Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
