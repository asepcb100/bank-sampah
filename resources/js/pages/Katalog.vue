<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Search,
    ShoppingBag,
    MessageSquare,
    CheckCircle2,
    Leaf,
    Eye,
    Tag
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
}

interface ProductImageItem {
    id: number;
    image_url: string;
    is_primary: boolean;
}

interface ProductItem {
    id: number;
    title: string;
    category?: CategoryItem;
    contact?: ContactItem;
    price_text: string;
    stock: number;
    image_url: string;
    images?: ProductImageItem[];
    description?: string;
}

const props = defineProps<{
    products?: ProductItem[];
    categories?: CategoryItem[];
}>();

const activeCategory = ref<string>('Semua');
const searchQuery = ref<string>('');

function getPrimaryImage(item: any): string {
    if (item?.images && item.images.length > 0) {
        const primary = item.images.find((img: any) => img.is_primary);
        if (primary && primary.image_url) return primary.image_url;
        return item.images[0].image_url;
    }
    return item?.image_url || 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop';
}

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

const listProducts = computed(() => {
    const data = props.products && props.products.length > 0 ? props.products : defaultProducts;
    return data.filter(item => {
        const catName = item.category?.name || 'Produk';
        const matchesCategory = activeCategory.value === 'Semua' || catName === activeCategory.value;
        const matchesQuery = searchQuery.value === '' || 
            item.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.price_text.toLowerCase().includes(searchQuery.value.toLowerCase());
        return matchesCategory && matchesQuery;
    });
});

const categoryPills = computed(() => {
    const dbCats = props.categories && props.categories.length > 0 ? props.categories.map(c => c.name) : ['Perawatan', 'Kerajinan', 'Organik'];
    return ['Semua', ...Array.from(new Set(dbCats))];
});
</script>

<template>
    <Head title="Katalog Produk Olahan — Bumi Indramayu Lestari" />

    <PublicLayout>
        <div class="max-w-[1180px] mx-auto px-6 sm:px-8 py-10">
            
            <!-- Page Header Section -->
            <div class="relative bg-[#fbf8ef] rounded-2xl p-8 sm:p-10 mb-8 border border-[#2b2417]/16 overflow-hidden shadow-2xs">
                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-2">
                        <ShoppingBag class="w-3.5 h-3.5" />
                        <span>Katalog Sirkular</span>
                    </div>
                    <h1 class="font-fraunces font-bold text-3xl sm:text-4xl text-[#2c3821] tracking-tight mb-2.5">
                        Katalog Produk Olahan Komunitas
                    </h1>
                    <p class="text-[#5a5040] text-sm sm:text-base leading-relaxed">
                        Produk kreatif & ramah lingkungan hasil karya pengolahan limbah minyak jelantah, sampah anorganik, dan kain perca oleh warga Indramayu.
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
                                ? 'bg-[#c1852c] text-[#fbf8ef] border border-[#c1852c] shadow-xs'
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
                        placeholder="Cari nama produk..."
                        class="w-full pl-10 pr-4 py-2.5 bg-[#fbf8ef] rounded-full text-xs font-semibold text-[#2b2417] border border-[#2b2417]/16 focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs"
                    />
                </div>
            </div>

            <!-- Products Grid Cards -->
            <div v-if="listProducts.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <div
                    v-for="item in listProducts"
                    :key="item.id"
                    class="group bg-[#fbf8ef] rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
                >
                    <div>
                        <!-- Thumbnail Image -->
                        <Link :href="`/katalog/${item.slug || item.id}`" class="block relative h-52 w-full overflow-hidden bg-slate-100">
                            <img
                                :src="getPrimaryImage(item)"
                                :alt="item.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            />
                            <span class="absolute top-3 left-3 bg-[#c1852c] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                {{ item.category?.name || 'Produk' }}
                            </span>
                        </Link>

                        <!-- Card Content -->
                        <div class="p-5 space-y-2">
                            <Link :href="`/katalog/${item.slug || item.id}`">
                                <h3 class="font-fraunces font-bold text-[#2c3821] text-base group-hover:text-[#c1852c] transition-colors line-clamp-2">
                                    {{ item.title }}
                                </h3>
                            </Link>

                            <p v-if="item.description" class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-normal">
                                {{ item.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="p-4 bg-white border-t border-slate-100 space-y-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Harga</span>
                                <span class="font-bold text-sm text-[#c1852c]">{{ item.price_text }}</span>
                            </div>

                            <Link
                                :href="`/katalog/${item.slug || item.id}`"
                                class="inline-flex items-center gap-1 text-xs font-bold text-[#2c3821] hover:text-[#c1852c] transition-colors"
                            >
                                <Eye class="w-3.5 h-3.5" />
                                <span>Show Detail</span>
                            </Link>
                        </div>

                        <!-- Direct WhatsApp Order Button -->
                        <a
                            :href="`https://wa.me/${(item.contact?.phone || '628112442322').replace(/[^0-9]/g, '')}?text=${encodeURIComponent('Halo ' + (item.contact?.name || 'Admin BIL') + ', saya tertarik untuk memesan produk ' + item.title + '. Apakah stok masih tersedia?')}`"
                            target="_blank"
                            class="w-full py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-full text-xs font-bold flex items-center justify-center gap-1.5 transition-colors shadow-2xs"
                        >
                            <MessageSquare class="w-3.5 h-3.5" />
                            <span>Pesan via WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="bg-[#fbf8ef] rounded-2xl p-12 text-center border border-[#2b2417]/16 my-8">
                <ShoppingBag class="w-12 h-12 text-[#c1852c] mx-auto mb-3" />
                <h3 class="font-fraunces font-bold text-[#2c3821] text-lg mb-1">Tidak Ada Produk Ditemukan</h3>
                <p class="text-xs text-[#5a5040] max-w-sm mx-auto">Coba ubah kata kunci pencarian atau pilih filter kategori lainnya.</p>
            </div>

        </div>
    </PublicLayout>
</template>
