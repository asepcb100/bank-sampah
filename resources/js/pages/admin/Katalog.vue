<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ShoppingBag,
    Plus,
    Search,
    Phone,
    Eye,
    Edit3,
    Trash2,
    CheckCircle2,
    SlidersHorizontal,
    AlertTriangle,
    FolderPlus,
    X,
    Save
} from '@lucide/vue';
import { ref, computed, reactive } from 'vue';

interface CategoryItem {
    id: number;
    name: string;
    type?: 'galeri' | 'katalog' | 'semua';
    description?: string;
}

interface ContactItem {
    id: number;
    name: string;
    phone: string;
}

interface ProductItem {
    id: number;
    title: string;
    category_id?: number;
    category?: CategoryItem;
    contact_id?: number;
    contact?: ContactItem;
    price_text: string;
    stock: number;
    image_url?: string;
    description?: string;
    is_available: boolean;
}

const props = defineProps<{
    products?: ProductItem[];
    categories?: CategoryItem[];
    contacts?: ContactItem[];
}>();

const searchQuery = ref('');
const selectedCategory = ref('semua');

// Delete Modal state
const showDeleteModal = ref(false);
const selectedItem = ref<ProductItem | null>(null);

// Category Management Modal state
const showCategoryManageModal = ref(false);
const editingCatId = ref<number | null>(null);

const categoryForm = reactive({
    name: '',
    type: 'katalog' as 'galeri' | 'katalog' | 'semua',
    description: ''
});

const defaultCategories: CategoryItem[] = [
    { id: 1, name: 'Perawatan', type: 'katalog', description: 'Produk perawatan alami dari bahan ramah lingkungan' },
    { id: 2, name: 'Kerajinan', type: 'katalog', description: 'Produk olahan daur ulang anorganik & ecobrick' },
    { id: 3, name: 'Organik', type: 'katalog', description: 'Pupuk & cairan fermentasi olahan sampah organik' },
    { id: 4, name: 'Daur Ulang', type: 'katalog', description: 'Wadah & pot tanaman serbaguna dari bahan bekas' },
    { id: 5, name: 'Program', type: 'galeri', description: 'Program kerja rutin dan kegiatan sedekah sampah' },
    { id: 6, name: 'Produk', type: 'galeri', description: 'Dokumentasi pelatihan & proses produksi produk olahan' },
    { id: 7, name: 'Kolaborasi', type: 'galeri', description: 'Aksi bersama pemerintah desa, kampus & KKN' },
    { id: 8, name: 'Edukasi', type: 'galeri', description: 'Sosialisasi pemilahan sampah organik & anorganik' },
];

const categoryList = ref<CategoryItem[]>(
    props.categories && props.categories.length > 0 ? [...props.categories] : defaultCategories
);

const availableCategories = computed(() => {
    return categoryList.value;
});

function formatImageUrl(url: string | null | undefined): string {
    const fallback = 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop';
    if (!url) return fallback;
    if (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('data:') || url.startsWith('blob:')) {
        return url;
    }
    if (!url.startsWith('/')) {
        return '/' + url;
    }
    return url;
}

function getProductImage(item: ProductItem): string {
    if (item.images && item.images.length > 0) {
        const primary = item.images.find(img => img.is_primary);
        if (primary && primary.image_url) return formatImageUrl(primary.image_url);
        if (item.images[0]?.image_url) return formatImageUrl(item.images[0].image_url);
    }
    return formatImageUrl(item.image_url);
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
    categoryForm.type = 'katalog';
    categoryForm.description = '';

    window.dispatchEvent(new CustomEvent('show-theme-toast', {
        detail: { message: 'Kategori berhasil disimpan!', type: 'success', title: 'Kategori Disimpan!' }
    }));
}

function startEditCategory(cat: CategoryItem) {
    editingCatId.value = cat.id;
    categoryForm.name = cat.name;
    categoryForm.type = cat.type || 'katalog';
    categoryForm.description = cat.description || '';
}

function cancelCategoryEdit() {
    editingCatId.value = null;
    categoryForm.name = '';
    categoryForm.type = 'katalog';
    categoryForm.description = '';
}

function deleteCategoryItem(id: number) {
    categoryList.value = categoryList.value.filter(c => c.id !== id);
    window.dispatchEvent(new CustomEvent('show-theme-toast', {
        detail: { message: 'Kategori telah dihapus dari daftar.', type: 'success', title: 'Kategori Dihapus!' }
    }));
}

// Local dataset
const productsList = ref<ProductItem[]>(
    props.products && props.products.length > 0 ? [...props.products] : [
        {
            id: 1,
            title: 'Sabun Minyak Jelantah Alami',
            category_id: 1,
            category: { id: 1, name: 'Perawatan' },
            contact_id: 2,
            contact: { id: 2, name: 'Ibu Siti Khadijah', phone: '6281234567890' },
            price_text: 'Rp 10.000 / pcs',
            stock: 50,
            image_url: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop',
            description: 'Sabun pembersih serbaguna ramah lingkungan buatan tangan warga.',
            is_available: true
        },
        {
            id: 2,
            title: 'Ecobrick Modular Furnitur',
            category_id: 2,
            category: { id: 2, name: 'Kerajinan' },
            contact_id: 4,
            contact: { id: 4, name: 'Mbak Rina Wati', phone: '6285712345678' },
            price_text: 'Hubungi Kami',
            stock: 100,
            image_url: 'https://images.unsplash.com/photo-1530587191325-3db32d826c18?q=80&w=800&auto=format&fit=crop',
            description: 'Botol PET padat terisi plastik anorganik kering siap dirangkai.',
            is_available: true
        },
        {
            id: 3,
            title: 'Cairan Fermentasi Eco-Enzyme (500ml)',
            category_id: 3,
            category: { id: 3, name: 'Organik' },
            contact_id: 3,
            contact: { id: 3, name: 'Pak Budi Santoso', phone: '6281987654321' },
            price_text: 'Rp 20.000',
            stock: 40,
            image_url: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=800&auto=format&fit=crop',
            description: 'Cairan pembersih serbaguna hasil fermentasi sampah buah.',
            is_available: true
        }
    ]
);

const filteredProducts = computed(() => {
    return productsList.value.filter(item => {
        const matchesQuery = item.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.contact?.name.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesCat = selectedCategory.value === 'semua' || 
            item.category?.name.toLowerCase() === selectedCategory.value.toLowerCase();
        return matchesQuery && matchesCat;
    });
});

function confirmDelete(item: ProductItem) {
    selectedItem.value = item;
    showDeleteModal.value = true;
}

function deleteItem() {
    if (selectedItem.value) {
        const deletedTitle = selectedItem.value.title;
        productsList.value = productsList.value.filter(p => p.id !== selectedItem.value?.id);
        window.dispatchEvent(new CustomEvent('show-theme-toast', {
            detail: { message: `Produk "${deletedTitle}" berhasil dihapus!`, type: 'success', title: 'Berhasil Dihapus!' }
        }));
    }
    showDeleteModal.value = false;
    selectedItem.value = null;
}
</script>

<template>
    <Head title="Kelola Katalog Produk — Admin BIL" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 sm:p-6 bg-[#f6f1e2]/30 rounded-2xl">
        
        <!-- Header Banner -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 shadow-sm border border-[#2b2417]/16">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-semibold mb-2">
                    <ShoppingBag class="w-3.5 h-3.5" />
                    <span>Manajemen Katalog</span>
                </div>
                <h1 class="font-fraunces font-bold text-2xl text-white">Kelola Katalog Produk Daur Ulang</h1>
                <p class="text-xs text-[#f6f1e2]/85 mt-1">Kelola daftar produk sirkular, harga, foto produk, dan relasi PIC Kontak WA pemesanan.</p>
            </div>

            <div class="flex items-center gap-2">
                <button
                    @click="showCategoryManageModal = true"
                    type="button"
                    class="px-4 py-2.5 bg-[#fbf8ef] text-[#2c3821] hover:bg-[#e9c688] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs cursor-pointer border border-[#2b2417]/16"
                >
                    <FolderPlus class="w-4 h-4 text-[#c1852c]" />
                    <span>Kelola Kategori</span>
                </button>

                <Link
                    href="/katalog"
                    target="_blank"
                    class="px-4 py-2.5 bg-[#fbf8ef] text-[#2c3821] hover:bg-[#e9c688] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                >
                    <Eye class="w-4 h-4" />
                    <span>Lihat Katalog Publik</span>
                </Link>

                <Link
                    href="/admin/katalog/create"
                    class="px-4 py-2.5 bg-[#c1852c] hover:bg-[#a67022] text-[#fbf8ef] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs cursor-pointer"
                >
                    <Plus class="w-4 h-4" />
                    <span>Tambah Produk</span>
                </Link>
            </div>
        </div>

        <!-- Controls: Search + Filter -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <div class="relative sm:w-80">
                <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Cari nama produk atau PIC..."
                    class="w-full pl-10 pr-4 py-2 bg-white rounded-full text-xs text-slate-800 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#c1852c] shadow-2xs"
                />
            </div>

            <div class="flex items-center gap-2 text-xs">
                <SlidersHorizontal class="w-4 h-4 text-slate-500" />
                <span class="font-semibold text-slate-600">Filter Kategori:</span>
                <select
                    v-model="selectedCategory"
                    class="bg-white border border-slate-200 rounded-full px-3 py-1.5 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#c1852c]"
                >
                    <option value="semua">Semua Kategori</option>
                    <option v-for="cat in availableCategories" :key="cat.id" :value="cat.name">
                        {{ cat.name }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-[#f8f9fa] border-b border-slate-200 text-slate-600 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3.5 px-4 font-semibold">Foto Produk</th>
                            <th class="py-3.5 px-4 font-semibold">Nama Produk</th>
                            <th class="py-3.5 px-4 font-semibold">Kategori</th>
                            <th class="py-3.5 px-4 font-semibold">Harga / Donasi</th>
                            <th class="py-3.5 px-4 font-semibold">PIC Pemesanan WA</th>
                            <th class="py-3.5 px-4 font-semibold">Stok</th>
                            <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="item in filteredProducts" :key="item.id" class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4">
                                <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden border border-slate-200">
                                    <img :src="getProductImage(item)" :alt="item.title" class="w-full h-full object-cover" />
                                </div>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800 max-w-xs">
                                <div class="font-fraunces text-xs sm:text-sm">{{ item.title }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full bg-[#c1852c]/10 text-[#c1852c] font-semibold text-[11px]">
                                    {{ item.category?.name || 'Umum' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-[#2c3821]">
                                {{ item.price_text }}
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                <div class="font-medium text-slate-800">{{ item.contact?.name || 'Admin BIL' }}</div>
                                <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                    <Phone class="w-3 h-3 text-emerald-600" />
                                    <span>+{{ item.contact?.phone }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-semibold">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px]">
                                    {{ item.stock }} unit
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <Link
                                        :href="`/admin/katalog/${item.id}`"
                                        class="p-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-[#c1852c] hover:text-white transition-colors cursor-pointer"
                                        title="Lihat Detail Produk"
                                    >
                                        <Eye class="w-3.5 h-3.5" />
                                    </Link>
                                    <Link
                                        :href="`/admin/katalog/${item.id}/edit`"
                                        class="p-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                                        title="Edit Produk"
                                    >
                                        <Edit3 class="w-3.5 h-3.5" />
                                    </Link>
                                    <button
                                        @click="confirmDelete(item)"
                                        class="p-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition-colors cursor-pointer"
                                        title="Hapus Produk"
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
                            <option value="katalog">Katalog Produk</option>
                            <option value="galeri">Galeri Kegiatan</option>
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
                                        {{ cat.type || 'katalog' }}
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

                <h3 class="font-fraunces font-bold text-lg text-[#2c3821] mb-2">Konfirmasi Hapus Produk</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-6">
                    Apakah Anda yakin ingin menghapus produk <span class="font-semibold text-slate-900">"{{ selectedItem?.title }}"</span>? Tindakan ini tidak dapat dibatalkan.
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
                        Ya, Hapus Produk
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>
