<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Image,
    Plus,
    Search,
    MapPin,
    Calendar,
    Eye,
    Edit3,
    Trash2,
    CheckCircle2,
    SlidersHorizontal,
    AlertTriangle,
    FolderPlus,
    Folder,
    X,
    Save,
    Tag,
    Check,
    Camera
} from '@lucide/vue';
import { ref, computed, reactive } from 'vue';

interface CategoryItem {
    id: number;
    name: string;
    type?: 'galeri' | 'katalog' | 'semua';
    description?: string;
}

interface GalleryImageItem {
    id: number;
    image_url: string;
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
}

const props = defineProps<{
    galleries?: GalleryItem[];
    categories?: CategoryItem[];
}>();

const searchQuery = ref('');
const selectedCategory = ref('semua');

// Delete Modal state
const showDeleteModal = ref(false);
const selectedItem = ref<GalleryItem | null>(null);

// Category Management Modal state
const showCategoryManageModal = ref(false);
const editingCatId = ref<number | null>(null);

const categoryForm = reactive({
    name: '',
    type: 'galeri' as 'galeri' | 'katalog' | 'semua',
    description: ''
});

const defaultCategories: CategoryItem[] = [
    { id: 1, name: 'Program', type: 'galeri', description: 'Program kerja rutin dan kegiatan sedekah sampah' },
    { id: 2, name: 'Produk', type: 'galeri', description: 'Dokumentasi pelatihan & proses produksi produk olahan' },
    { id: 3, name: 'Kolaborasi', type: 'galeri', description: 'Aksi bersama pemerintah desa, kampus & KKN' },
    { id: 4, name: 'Edukasi', type: 'galeri', description: 'Sosialisasi pemilahan sampah organik & anorganik' },
    { id: 5, name: 'Perawatan', type: 'katalog', description: 'Produk perawatan alami dari bahan ramah lingkungan' },
    { id: 6, name: 'Kerajinan', type: 'katalog', description: 'Produk olahan daur ulang anorganik & ecobrick' },
    { id: 7, name: 'Organik', type: 'katalog', description: 'Pupuk & cairan fermentasi olahan sampah organik' },
    { id: 8, name: 'Daur Ulang', type: 'katalog', description: 'Wadah & pot tanaman serbaguna dari bahan bekas' },
];

const categoryList = ref<CategoryItem[]>(
    props.categories && props.categories.length > 0 ? [...props.categories] : defaultCategories
);

const availableCategories = computed(() => {
    return categoryList.value;
});

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

function getPrimaryImage(item: GalleryItem): string {
    const fallback = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop';
    if (item.images && item.images.length > 0) {
        const primary = item.images.find(img => img.is_primary);
        if (primary && primary.image_url) return formatImageUrl(primary.image_url, fallback);
        if (item.images[0]?.image_url) return formatImageUrl(item.images[0].image_url, fallback);
    }
    return formatImageUrl(item.image_url, fallback);
}

function saveCategoryItem() {
    if (!categoryForm.name.trim()) return;

    if (editingCatId.value !== null) {
        const idx = categoryList.value.findIndex(c => c.id === editingCatId.value);
        if (idx !== -1) {
            categoryList.value[idx] = {
                ...categoryList.value[idx],
                name: categoryForm.name.trim(),
                type: categoryForm.type,
                description: categoryForm.description.trim()
            };
        }
        editingCatId.value = null;
    } else {
        categoryList.value.unshift({
            id: Date.now(),
            name: categoryForm.name.trim(),
            type: categoryForm.type,
            description: categoryForm.description.trim()
        });
    }

    categoryForm.name = '';
    categoryForm.type = 'galeri';
    categoryForm.description = '';

    window.dispatchEvent(new CustomEvent('show-theme-toast', {
        detail: { message: 'Kategori berhasil disimpan!', type: 'success', title: 'Kategori Disimpan!' }
    }));
}

function startEditCategory(cat: CategoryItem) {
    editingCatId.value = cat.id;
    categoryForm.name = cat.name;
    categoryForm.type = cat.type || 'galeri';
    categoryForm.description = cat.description || '';
}

function cancelCategoryEdit() {
    editingCatId.value = null;
    categoryForm.name = '';
    categoryForm.type = 'galeri';
    categoryForm.description = '';
}

function deleteCategoryItem(id: number) {
    categoryList.value = categoryList.value.filter(c => c.id !== id);
    window.dispatchEvent(new CustomEvent('show-theme-toast', {
        detail: { message: 'Kategori telah dihapus dari daftar.', type: 'success', title: 'Kategori Dihapus!' }
    }));
}

// Local dataset with fallback
const galleriesList = ref<GalleryItem[]>(
    props.galleries && props.galleries.length > 0 ? [...props.galleries] : [
        {
            id: 1,
            title: 'Program Penimbangan & Sedekah Sampah Rutin Pekan Pertama',
            category_id: 1,
            category: { id: 1, name: 'Program' },
            location: 'Balai Desa Karangampel',
            event_date: '2026-08-15',
            image_url: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop',
            description: 'Kegiatan rutin bulanan penimbangan dan penyetoran sedekah sampah anorganik.',
            is_published: true
        },
        {
            id: 2,
            title: 'Pelatihan Pembuatan Sabun Alami Minyak Jelantah Bersama Kelompok Perempuan',
            category_id: 2,
            category: { id: 2, name: 'Produk' },
            location: 'Sanggar Daur Ulang BIL',
            event_date: '2026-08-10',
            image_url: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
            description: 'Pelatihan praktek olahan limbah minyak goreng bekas menjadi sabun padat.',
            is_published: true
        },
        {
            id: 3,
            title: 'Aksi Bersih Pantai & Kolaborasi Lingkungan Bersama Mahasiswa KKN',
            category_id: 3,
            category: { id: 3, name: 'Kolaborasi' },
            location: 'Pesisir Pantai Indramayu',
            event_date: '2026-08-01',
            image_url: 'https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?q=80&w=800&auto=format&fit=crop',
            description: 'Aksi pembersihan sampah plastik pesisir pantai Indramayu.',
            is_published: true
        }
    ]
);

const filteredGalleries = computed(() => {
    return galleriesList.value.filter(item => {
        const matchesQuery = item.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.location.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesCat = selectedCategory.value === 'semua' || 
            item.category?.name.toLowerCase() === selectedCategory.value.toLowerCase();
        return matchesQuery && matchesCat;
    });
});

function confirmDelete(item: GalleryItem) {
    selectedItem.value = item;
    showDeleteModal.value = true;
}

function deleteItem() {
    if (selectedItem.value) {
        const deletedTitle = selectedItem.value.title;
        galleriesList.value = galleriesList.value.filter(g => g.id !== selectedItem.value?.id);
        window.dispatchEvent(new CustomEvent('show-theme-toast', {
            detail: { message: `Kegiatan "${deletedTitle}" berhasil dihapus!`, type: 'success', title: 'Berhasil Dihapus!' }
        }));
    }
    showDeleteModal.value = false;
    selectedItem.value = null;
}
</script>

<template>
    <Head title="Kelola Galeri Kegiatan — Admin BIL" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 sm:p-6 bg-[#f6f1e2]/30 rounded-2xl w-full">
        
        <!-- Header Banner -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 sm:p-7 shadow-sm border border-[#2b2417]/16">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-semibold mb-2">
                    <Image class="w-3.5 h-3.5" />
                    <span>Manajemen Galeri</span>
                </div>
                <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white">Kelola Galeri Kegiatan</h1>
                <p class="text-xs sm:text-sm text-[#f6f1e2]/85 mt-1">Tambah, edit, dan atur foto dokumentasi utama kegiatan warga yang tampil pada website publik.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button
                    @click="showCategoryManageModal = true"
                    type="button"
                    class="px-4 py-2.5 bg-[#fbf8ef] text-[#2c3821] hover:bg-[#e9c688] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs cursor-pointer border border-[#2b2417]/16"
                >
                    <FolderPlus class="w-4 h-4 text-[#c1852c]" />
                    <span>Kelola Kategori</span>
                </button>

                <Link
                    href="/galeri"
                    target="_blank"
                    class="px-4 py-2.5 bg-[#fbf8ef] text-[#2c3821] hover:bg-[#e9c688] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                >
                    <Eye class="w-4 h-4" />
                    <span>Halaman Publik</span>
                </Link>

                <Link
                    href="/admin/galeri/create"
                    class="px-4.5 py-2.5 bg-[#c1852c] hover:bg-[#a67022] text-[#fbf8ef] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-sm cursor-pointer"
                >
                    <Plus class="w-4 h-4" />
                    <span>Tambah Kegiatan</span>
                </Link>
            </div>
        </div>

        <!-- Controls: Search + Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <div class="relative sm:w-80">
                <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Cari judul kegiatan atau lokasi..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 focus:bg-white rounded-full text-xs text-slate-800 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#c1852c] shadow-2xs"
                />
            </div>

            <div class="flex items-center gap-2 text-xs">
                <SlidersHorizontal class="w-4 h-4 text-slate-500" />
                <span class="font-semibold text-slate-600">Filter Kategori:</span>
                <select
                    v-model="selectedCategory"
                    class="bg-slate-50 border border-slate-200 rounded-full px-3.5 py-2 text-xs text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-[#c1852c]"
                >
                    <option value="semua">Semua Kategori</option>
                    <option v-for="cat in availableCategories" :key="cat.id" :value="cat.name">
                        {{ cat.name }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Gallery Items Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-[#f8f9fa] border-b border-slate-200 text-slate-600 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3.5 px-4 font-semibold">Foto Utama (Primary Cover)</th>
                            <th class="py-3.5 px-4 font-semibold">Judul Kegiatan</th>
                            <th class="py-3.5 px-4 font-semibold">Kategori</th>
                            <th class="py-3.5 px-4 font-semibold">Lokasi & Tanggal</th>
                            <th class="py-3.5 px-4 font-semibold">Status</th>
                            <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="item in filteredGalleries" :key="item.id" class="hover:bg-slate-50/80 transition-colors">
                            
                            <!-- Thumbnail Cover Utama -->
                            <td class="py-3 px-4">
                                <div class="relative group w-20 h-14 rounded-xl bg-slate-100 overflow-hidden border-2 border-emerald-500 shadow-xs">
                                    <img :src="getPrimaryImage(item)" :alt="item.title" class="w-full h-full object-cover" />
                                    <!-- Primary Badge (UTAMA) -->
                                    <div class="absolute top-1 left-1 px-1.5 py-0.5 rounded-full bg-emerald-600/90 text-white text-[8px] font-black uppercase tracking-wider shadow-xs flex items-center gap-0.5 backdrop-blur-2xs">
                                        <Check class="w-2.5 h-2.5" />
                                        <span>UTAMA</span>
                                    </div>
                                    <!-- Multi photo count indicator -->
                                    <div v-if="item.images && item.images.length > 1" class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded-md bg-black/70 text-white text-[9px] font-bold flex items-center gap-1">
                                        <Camera class="w-2.5 h-2.5" />
                                        <span>{{ item.images.length }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Judul Kegiatan -->
                            <td class="py-3 px-4 font-semibold text-slate-800 max-w-xs sm:max-w-md">
                                <div class="line-clamp-2 font-fraunces text-xs sm:text-sm text-[#2c3821]">{{ item.title }}</div>
                                <p v-if="item.description" class="text-[11px] font-normal text-slate-500 line-clamp-1 mt-0.5">
                                    {{ item.description }}
                                </p>
                            </td>

                            <!-- Kategori -->
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full bg-[#2c3821]/10 text-[#2c3821] font-bold text-[11px] inline-block">
                                    {{ item.category?.name || 'Umum' }}
                                </span>
                            </td>

                            <!-- Lokasi & Tanggal -->
                            <td class="py-3 px-4 text-slate-600">
                                <div class="flex items-center gap-1 mb-1 font-semibold text-slate-800">
                                    <MapPin class="w-3.5 h-3.5 text-[#c1852c]" />
                                    <span>{{ item.location }}</span>
                                </div>
                                <div class="flex items-center gap-1 text-[11px] text-slate-500">
                                    <Calendar class="w-3.5 h-3.5 text-slate-400" />
                                    <span>{{ item.event_date }}</span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold text-[11px]">
                                    <CheckCircle2 class="w-3.5 h-3.5" />
                                    <span>Publik</span>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Link
                                        :href="`/admin/galeri/${item.id}`"
                                        class="p-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-[#c1852c] hover:text-white transition-colors cursor-pointer shadow-2xs"
                                        title="Lihat Detail Kegiatan"
                                    >
                                        <Eye class="w-4 h-4" />
                                    </Link>
                                    <Link
                                        :href="`/admin/galeri/${item.id}/edit`"
                                        class="p-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-[#2c3821] hover:text-white transition-colors cursor-pointer shadow-2xs"
                                        title="Edit Kegiatan & Media Foto"
                                    >
                                        <Edit3 class="w-4 h-4" />
                                    </Link>
                                    <button
                                        @click="confirmDelete(item)"
                                        class="p-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-600 hover:text-white transition-colors cursor-pointer shadow-2xs"
                                        title="Hapus Kegiatan"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="filteredGalleries.length === 0">
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                    <Image class="w-6 h-6" />
                                </div>
                                <p class="font-semibold text-slate-700 text-sm">Tidak ada kegiatan galeri ditemukan</p>
                                <p class="text-xs text-slate-400 mt-1">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CATEGORY MANAGEMENT MODAL WITH TABLE & INLINE CRUD -->
        <div
            v-if="showCategoryManageModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/80 backdrop-blur-xs"
            @click.self="showCategoryManageModal = false"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-[#2b2417]/16 flex flex-col max-h-[85vh]">
                <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 rounded-lg bg-[#c1852c]/10 text-[#c1852c]">
                            <FolderPlus class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">Kelola Master Kategori</h3>
                            <p class="text-[11px] text-slate-500">Kelola daftar kategori kegiatan galeri dan katalog produk</p>
                        </div>
                    </div>
                    <button @click="showCategoryManageModal = false" class="text-slate-400 hover:text-slate-600">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <!-- Form Bar to Add or Edit Category -->
                <div class="bg-white p-4 rounded-xl border border-[#2b2417]/16 mb-4 shadow-2xs">
                    <div class="text-xs font-semibold text-[#2c3821] mb-2">
                        {{ editingCatId !== null ? '✏️ Edit Kategori' : '✨ Tambah Kategori Baru' }}
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        <input
                            v-model="categoryForm.name"
                            type="text"
                            placeholder="Nama Kategori..."
                            class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-[#c1852c] focus:outline-none font-semibold text-slate-800"
                        />
                        <select
                            v-model="categoryForm.type"
                            class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-[#c1852c] focus:outline-none"
                        >
                            <option value="galeri">Galeri Kegiatan</option>
                            <option value="katalog">Katalog Produk</option>
                            <option value="semua">Semua Tipe</option>
                        </select>
                        <div class="flex items-center gap-1.5">
                            <button
                                type="button"
                                @click="saveCategoryItem"
                                class="flex-1 py-2 px-3 bg-[#2c3821] hover:bg-[#4c5c31] text-[#f6f1e2] text-xs font-semibold rounded-lg flex items-center justify-center gap-1 transition-colors shadow-2xs cursor-pointer"
                            >
                                <Save class="w-3.5 h-3.5" />
                                <span>{{ editingCatId !== null ? 'Update' : 'Tambah' }}</span>
                            </button>
                            <button
                                v-if="editingCatId !== null"
                                type="button"
                                @click="cancelCategoryEdit"
                                class="py-2 px-2.5 bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-300 transition-colors"
                            >
                                Batal
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Category Table -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-2xs overflow-hidden flex-1 overflow-y-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-[#f8f9fa] border-b border-slate-200 text-slate-600 uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="py-2.5 px-3.5 font-semibold">Nama Kategori</th>
                                <th class="py-2.5 px-3.5 font-semibold">Tipe</th>
                                <th class="py-2.5 px-3.5 font-semibold">Deskripsi</th>
                                <th class="py-2.5 px-3.5 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="cat in categoryList" :key="cat.id" class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-2.5 px-3.5 font-semibold text-slate-800">
                                    {{ cat.name }}
                                </td>
                                <td class="py-2.5 px-3.5">
                                    <span
                                        class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                                        :class="[
                                            cat.type === 'galeri' ? 'bg-[#2c3821]/10 text-[#2c3821]' :
                                            cat.type === 'katalog' ? 'bg-[#c1852c]/10 text-[#c1852c]' : 'bg-blue-50 text-blue-700'
                                        ]"
                                    >
                                        {{ cat.type || 'galeri' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3.5 text-slate-500 text-[11px] max-w-xs truncate">
                                    {{ cat.description || '-' }}
                                </td>
                                <td class="py-2.5 px-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button
                                            @click="startEditCategory(cat)"
                                            class="p-1 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-100 transition-colors"
                                            title="Edit"
                                        >
                                            <Edit3 class="w-3.5 h-3.5" />
                                        </button>
                                        <button
                                            @click="deleteCategoryItem(cat.id)"
                                            class="p-1 rounded-md border border-red-200 text-red-600 hover:bg-red-50 transition-colors"
                                            title="Hapus"
                                        >
                                            <Trash2 class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
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
                    Apakah Anda yakin ingin menghapus kegiatan <span class="font-semibold text-slate-900">"{{ selectedItem?.title }}"</span>? Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex items-center justify-center gap-3">
                    <button
                        @click="showDeleteModal = false"
                        class="flex-1 py-2.5 rounded-full border border-slate-200 text-slate-700 bg-white hover:bg-slate-100 text-xs font-semibold transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        @click="deleteItem"
                        class="flex-1 py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-md transition-colors"
                    >
                        Ya, Hapus Kegiatan
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>
