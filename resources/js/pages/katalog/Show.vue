<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    ArrowLeft,
    Tag,
    ShoppingBag,
    MessageSquare,
    Phone,
    CheckCircle2,
    Share2,
    UserCheck,
    Check
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
    slug?: string;
    category?: CategoryItem;
    contact?: ContactItem;
    price_text: string;
    stock: number;
    image_url: string;
    images?: ProductImageItem[];
    description?: string;
}

const props = defineProps<{
    product: ProductItem;
    related?: ProductItem[];
}>();

const productImages = computed(() => {
    if (props.product.images && props.product.images.length > 0) {
        return props.product.images.map(img => img.image_url);
    }
    return [props.product.image_url || 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop'];
});

const activeImageIndex = ref(0);
const activeImageUrl = computed(() => productImages.value[activeImageIndex.value]);

const pageUrl = computed(() => typeof window !== 'undefined' ? window.location.href : '');

const orderWaUrl = computed(() => {
    const phone = (props.product.contact?.phone || '628112442322').replace(/[^0-9]/g, '');
    const picName = props.product.contact?.name || 'Admin BIL';
    const msg = `Halo ${picName}, saya tertarik ingin memesan produk "${props.product.title}". Apakah stok masih tersedia?`;
    return `https://wa.me/${phone}?text=${encodeURIComponent(msg)}`;
});

function copyShareLink() {
    if (typeof window !== 'undefined') {
        navigator.clipboard.writeText(window.location.href);
        alert('Tautan produk berhasil disalin!');
    }
}
</script>

<template>
    <Head>
        <title>{{ product.title }} — Katalog Produk Bumi Indramayu Lestari</title>

        <!-- SEO Standard Meta Tags -->
        <meta name="description" :content="product.description || `Produk sirkular ${product.title} (${product.price_text}) olahan Bank Sampah Bumi Indramayu Lestari.`" />
        <meta name="keywords" :content="`produk, ${product.category?.name || 'sirkular'}, bank sampah, indramayu, ${product.title}, ${product.price_text}`" />
        <meta name="robots" content="index, follow" />

        <!-- OpenGraph Meta Tags (WhatsApp, Facebook, LinkedIn) -->
        <meta property="og:type" content="product" />
        <meta property="og:title" :content="`${product.title} — ${product.price_text}`" />
        <meta property="og:description" :content="product.description || `Pesan produk sirkular ${product.title} olahan Bank Sampah Bumi Indramayu Lestari.`" />
        <meta property="og:image" :content="activeImageUrl" />
        <meta property="og:url" :content="pageUrl" />
        <meta property="og:site_name" content="Bumi Indramayu Lestari" />

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="`${product.title} — ${product.price_text}`" />
        <meta name="twitter:description" :content="product.description || `Pesan produk sirkular ${product.title} olahan Bank Sampah Bumi Indramayu Lestari.`" />
        <meta name="twitter:image" :content="activeImageUrl" />
    </Head>

    <PublicLayout>
        <div class="max-w-[1180px] mx-auto px-6 sm:px-8 py-10">
            
            <!-- Back Navigation Link -->
            <div class="mb-6">
                <Link
                    href="/katalog"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#fbf8ef] border border-[#2b2417]/16 text-xs font-semibold text-[#2c3821] hover:bg-[#e9c688]/30 transition-colors shadow-2xs"
                >
                    <ArrowLeft class="w-4 h-4 text-[#c1852c]" />
                    <span>Kembali ke Katalog Produk</span>
                </Link>
            </div>

            <!-- Detail Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
                
                <!-- Left Main Photo Viewer (6 Cols) -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="relative bg-slate-100 rounded-2xl overflow-hidden aspect-[4/3] border border-[#2b2417]/16 shadow-md">
                        <img
                            :src="activeImageUrl"
                            :alt="product.title"
                            class="w-full h-full object-cover transition-transform duration-500"
                        />
                        <span class="absolute top-4 left-4 bg-[#c1852c] text-white text-xs font-bold px-3.5 py-1 rounded-full shadow-xs uppercase tracking-wider">
                            {{ product.category?.name || 'Produk Sirkular' }}
                        </span>
                    </div>

                    <!-- Product Gallery Thumbnails -->
                    <div v-if="productImages.length > 1" class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
                        <button
                            v-for="(imgUrl, idx) in productImages"
                            :key="idx"
                            @click="activeImageIndex = idx"
                            class="relative w-20 h-20 rounded-xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer"
                            :class="[activeImageIndex === idx ? 'border-[#c1852c] ring-2 ring-[#c1852c]/40 scale-95' : 'border-transparent opacity-70 hover:opacity-100']"
                        >
                            <img :src="imgUrl" :alt="`Foto Produk ${idx + 1}`" class="w-full h-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Right Detail Sidebar (6 Cols) -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="bg-[#fbf8ef] rounded-2xl p-6 sm:p-8 border border-[#2b2417]/16 shadow-2xs space-y-6">
                        
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#c1852c] block mb-1">
                                {{ product.category?.name || 'Perawatan' }}
                            </span>
                            <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-[#2c3821] leading-tight mb-3">
                                {{ product.title }}
                            </h1>

                            <div class="flex items-center gap-4 bg-white p-3.5 rounded-xl border border-[#2b2417]/10">
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Harga Produk</span>
                                    <span class="font-fraunces font-bold text-xl text-[#c1852c]">{{ product.price_text }}</span>
                                </div>
                                <div class="h-8 w-[1px] bg-slate-200"></div>
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Ketersediaan Stok</span>
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700">
                                        <CheckCircle2 class="w-3.5 h-3.5" />
                                        <span>Stok Tersedia ({{ product.stock }} pcs)</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2 pt-2 border-t border-[#2b2417]/10">
                            <h3 class="font-fraunces font-bold text-sm text-[#2c3821]">Deskripsi & Keunggulan Produk</h3>
                            <p class="text-xs text-[#54493a] leading-relaxed whitespace-pre-line font-medium">
                                {{ product.description || 'Produk ramah lingkungan hasil olahan ekonomi sirkular Bank Sampah Bumi Indramayu Lestari.' }}
                            </p>
                        </div>

                        <!-- PIC Pemesanan WA Box -->
                        <div class="p-4 bg-emerald-50/80 rounded-xl border border-emerald-200/80 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <UserCheck class="w-4 h-4 text-emerald-700" />
                                    <span class="text-xs font-bold text-emerald-900">Penanggung Jawab (PIC) Pemesanan</span>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-700 uppercase bg-emerald-100 px-2 py-0.5 rounded-full">Respon Cepat</span>
                            </div>

                            <div class="text-xs text-slate-800">
                                <div class="font-bold text-slate-900">{{ product.contact?.name || 'Ibu Siti Khadijah' }}</div>
                                <div class="text-emerald-700 font-semibold">+{{ product.contact?.phone || '628112442322' }}</div>
                            </div>

                            <a
                                :href="orderWaUrl"
                                target="_blank"
                                class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-full text-xs font-bold flex items-center justify-center gap-2 transition-colors shadow-md cursor-pointer"
                            >
                                <MessageSquare class="w-4 h-4" />
                                <span>Pesan Langsung via WhatsApp →</span>
                            </a>
                        </div>

                        <!-- Share Button -->
                        <button
                            @click="copyShareLink"
                            class="w-full py-2.5 bg-white hover:bg-slate-100 text-slate-700 rounded-full text-xs font-semibold border border-slate-300 flex items-center justify-center gap-2 transition-colors cursor-pointer"
                        >
                            <Share2 class="w-4 h-4 text-[#c1852c]" />
                            <span>Bagikan Tautan Produk Ini</span>
                        </button>

                    </div>
                </div>

            </div>

            <!-- Related Products Section -->
            <div v-if="related && related.length > 0" class="pt-8 border-t border-[#2b2417]/16">
                <h3 class="font-fraunces font-bold text-2xl text-[#2c3821] mb-6">
                    Produk Olahan Lainnya
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <Link
                        v-for="rel in related"
                        :key="rel.id"
                        :href="`/katalog/${rel.slug || rel.id}`"
                        class="group bg-[#fbf8ef] rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between"
                    >
                        <div>
                            <div class="h-44 bg-slate-100 overflow-hidden relative">
                                <img :src="rel.image_url || 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop'" :alt="rel.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                <span class="absolute top-3 left-3 bg-[#c1852c] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ rel.category?.name || 'Kerajinan' }}
                                </span>
                            </div>
                            <div class="p-4 space-y-1">
                                <h4 class="font-fraunces font-bold text-sm text-[#2c3821] group-hover:text-[#c1852c] transition-colors line-clamp-2">
                                    {{ rel.title }}
                                </h4>
                            </div>
                        </div>

                        <div class="p-3 bg-white border-t border-slate-100 text-xs text-[#c1852c] font-bold flex items-center justify-between">
                            <span>{{ rel.price_text }}</span>
                            <span class="text-[#2c3821] font-semibold underline text-[11px]">Lihat Detail →</span>
                        </div>
                    </Link>
                </div>
            </div>

        </div>
    </PublicLayout>
</template>
