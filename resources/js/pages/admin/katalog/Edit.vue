<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ShoppingBag,
    Save,
    Phone,
    Link as LinkIcon,
    Package,
    Tag,
    Image,
    Check,
    Plus,
    X,
    Star,
    ChevronDown,
    FolderPlus,
    Upload
} from '@lucide/vue';
import Select2Input from '@/components/Select2Input.vue';
import { reactive, computed, ref } from 'vue';

interface CategoryItem {
    id: number;
    name: string;
}

interface ContactItem {
    id: number;
    name: string;
    phone: string;
}

interface PhotoMedia {
    id: number | string;
    url: string;
    file?: File;
    is_primary: boolean;
    label?: string;
}

interface ProductItem {
    id: number;
    title: string;
    category_id?: number;
    contact_id?: number;
    price_text: string;
    stock: number;
    image_url?: string;
    description?: string;
    is_available: boolean;
}

const props = defineProps<{
    product?: ProductItem;
    categories?: CategoryItem[];
    contacts?: ContactItem[];
}>();

const defaultCategories = [
    { id: 1, name: 'Perawatan' },
    { id: 2, name: 'Kerajinan' },
    { id: 3, name: 'Organik' },
    { id: 4, name: 'Daur Ulang' }
];

const availableCategoriesList = ref<CategoryItem[]>(
    props.categories && props.categories.length > 0 ? [...props.categories] : defaultCategories
);

// Add Category Modal States
const showAddCategoryModal = ref(false);
const newCategoryName = ref('');
const newCategoryType = ref('katalog');

function saveCategory() {
    if (!newCategoryName.value.trim()) return;
    const newId = Date.now();
    const newCat = { id: newId, name: newCategoryName.value.trim() };
    availableCategoriesList.value.push(newCat);
    form.category_id = newId;
    newCategoryName.value = '';
    showAddCategoryModal.value = false;
}

const availableContacts = computed(() => {
    return props.contacts && props.contacts.length > 0 ? props.contacts : [
        { id: 1, name: 'Layanan Utama BIL', phone: '628112442322' },
        { id: 2, name: 'Ibu Siti Khadijah (PIC Sabun)', phone: '6281234567890' },
        { id: 3, name: 'Pak Budi Santoso (PIC Kompos)', phone: '6281987654321' },
        { id: 4, name: 'Mbak Rina Wati (PIC Perca/Ecobrick)', phone: '6285712345678' }
    ];
});

const categorySelectOptions = computed(() => {
    return availableCategoriesList.value.map(c => ({
        id: c.id,
        name: c.name,
        subtitle: (c as any).description || undefined
    }));
});

const contactSelectOptions = computed(() => {
    return availableContacts.value.map(c => ({
        id: c.id,
        name: c.name,
        subtitle: `+${(c as any).phone || (c as any).phone_number}`
    }));
});

const initialData = props.product || {
    id: 1,
    title: 'Sabun Minyak Jelantah Alami',
    category_id: 1,
    contact_id: 2,
    price_text: 'Rp 10.000 / pcs',
    stock: 50,
    image_url: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
    description: 'Sabun pembersih serbaguna ramah lingkungan buatan tangan warga.',
    is_available: true
};

// Multi-photo Media List
const photosList = ref<PhotoMedia[]>([
    {
        id: 1,
        url: initialData.image_url || 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
        is_primary: true
    },
    {
        id: 2,
        url: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?q=80&w=800&auto=format&fit=crop',
        is_primary: false,
        label: 'BARU'
    }
]);

// Hidden File Input Reference
const fileInputRef = ref<HTMLInputElement | null>(null);
const showAddUrlModal = ref(false);
const newPhotoUrl = ref('');

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
    contact_id: initialData.contact_id || 1,
    price_text: initialData.price_text,
    stock: initialData.stock,
    description: initialData.description || '',
    is_available: initialData.is_available
});

function handleSubmit() {
    if (!form.title) return;
    const primaryImg = photosList.value.find(p => p.is_primary)?.url || photosList.value[0]?.url || '';

    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('title', form.title);
    formData.append('category_id', String(form.category_id));
    formData.append('contact_id', String(form.contact_id));
    formData.append('price_text', form.price_text);
    formData.append('stock', String(form.stock));
    formData.append('description', form.description || '');
    formData.append('is_available', form.is_available ? '1' : '0');
    formData.append('image_url', primaryImg);

    photosList.value.forEach((photo, idx) => {
        if (photo.file) {
            formData.append(`photos[${idx}][file]`, photo.file);
        }
        formData.append(`photos[${idx}][url]`, photo.url);
        formData.append(`photos[${idx}][is_primary]`, photo.is_primary ? '1' : '0');
    });

    router.post(`/admin/katalog/${form.id}`, formData, {
        forceFormData: true
    });
}
</script>

<template>
    <Head :title="`Edit Produk: ${form.title} — Admin BIL`" />

    <!-- Hidden Native File Input for Direct File Upload -->
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
                href="/admin/katalog"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-2xs"
            >
                <ArrowLeft class="w-4 h-4 text-[#c1852c]" />
                <span>Kembali ke Daftar Katalog</span>
            </Link>
        </div>

        <!-- Header Banner -->
        <div class="bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 sm:p-8 shadow-sm border border-[#2b2417]/16">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-semibold mb-2">
                <ShoppingBag class="w-3.5 h-3.5" />
                <span>Edit Produk</span>
            </div>
            <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white">Edit Produk Katalog</h1>
            <p class="text-xs sm:text-sm text-[#f6f1e2]/85 mt-1">Perbarui detail produk, harga, stok, dan PIC WA penanggung jawab.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-[#fbf8ef] rounded-2xl p-6 sm:p-8 border border-[#2b2417]/16 shadow-xs w-full">
            <form @submit.prevent="handleSubmit" class="space-y-6">
                
                <!-- Nama Produk -->
                <div>
                    <label class="block font-fraunces font-semibold text-sm text-[#2c3821] mb-1.5">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="form.title"
                        type="text"
                        required
                        class="w-full px-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none shadow-2xs"
                    />
                </div>

                <!-- Grid Kategori & PIC WA -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <!-- Category Header with "+ Tambah Kategori Baru" button -->
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block font-semibold text-xs text-[#2c3821]">Kategori Produk</label>
                            <button
                                type="button"
                                @click="showAddCategoryModal = true"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#c1852c] hover:text-[#a67022] hover:underline cursor-pointer"
                            >
                                <Plus class="w-3.5 h-3.5" />
                                <span>Tambah Kategori Baru</span>
                            </button>
                        </div>

                        <!-- Select2 Component for Kategori -->
                        <Select2Input
                            v-model="form.category_id"
                            :options="categorySelectOptions"
                            placeholder="Pilih Kategori Produk..."
                            search-placeholder="Cari nama kategori..."
                        />
                    </div>

                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">PIC Pemesanan WA</label>
                        <!-- Select2 Component for PIC Pemesanan WA -->
                        <Select2Input
                            v-model="form.contact_id"
                            :options="contactSelectOptions"
                            placeholder="Pilih PIC Pemesanan WA..."
                            search-placeholder="Cari nama PIC atau nomor WA..."
                        />
                    </div>
                </div>

                <!-- Grid Harga & Stok -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">
                            Teks Harga / Donasi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <Tag class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.price_text"
                                type="text"
                                required
                                class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none font-semibold"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">
                            Jumlah Stok Tersedia <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <Package class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.stock"
                                type="number"
                                required
                                min="0"
                                class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none font-semibold"
                            />
                        </div>
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
                                GALERI MEDIA PRODUK
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
                            <img :src="photo.url" alt="Foto Produk" class="w-full h-full object-cover" />

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
                                    title="Jadikan Foto Utama Produk"
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

                <!-- Deskripsi Produk -->
                <div>
                    <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">Deskripsi Produk</label>
                    <textarea
                        v-model="form.description"
                        rows="4"
                        class="w-full px-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none"
                    ></textarea>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#2b2417]/10">
                    <Link
                        href="/admin/katalog"
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
                            placeholder="Contoh: Pupuk & Nutrisi"
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
                            <option value="katalog">Katalog Produk</option>
                            <option value="galeri">Galeri Kegiatan</option>
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
