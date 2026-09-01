<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeft,
    PhoneCall,
    Save,
    Phone,
    User,
    Mail,
    MapPin,
    Tag,
    Check,
    CheckCircle2,
    X,
    ClipboardCheck,
    AlertCircle
} from '@lucide/vue';
import Select2Input from '@/components/Select2Input.vue';
import { reactive, ref } from 'vue';

interface ContactItem {
    id: number;
    name: string;
    phone: string;
    role?: string;
    email?: string;
    address?: string;
    is_primary?: boolean;
    is_active?: boolean;
}

const props = defineProps<{
    contact?: ContactItem;
}>();

const initialData = props.contact || {
    id: 1,
    name: 'Ibu Siti Khadijah (PIC Sabun Jelantah)',
    phone: '6281234567890',
    role: 'Pemesanan Produk Daur Ulang',
    email: 'sitikhadijah@gmail.com',
    address: 'Desa Karangampel RT 04 / RW 02',
    is_primary: true,
    is_active: true
};

const form = reactive({
    id: initialData.id,
    name: initialData.name,
    phone: initialData.phone,
    role: initialData.role || 'Pemesanan Produk Daur Ulang',
    email: initialData.email || '',
    address: initialData.address || '',
    is_primary: !!initialData.is_primary,
    is_active: initialData.is_active !== undefined ? !!initialData.is_active : true
});

const isSubmitting = ref(false);
const showConfirmModal = ref(false);
const validationError = ref('');

const roleSelectOptions = [
    { id: 'Pemesanan Produk Daur Ulang', name: 'Pemesanan Produk Daur Ulang', subtitle: 'PIC Penjualan & Katalog Produk' },
    { id: 'Penimbangan & Sedekah Sampah', name: 'Penimbangan & Sedekah Sampah', subtitle: 'Koordinator Penimbangan Bulanan' },
    { id: 'Pertanyaan Umum & Layanan BIL', name: 'Pertanyaan Umum & Layanan BIL', subtitle: 'Layanan Sekretariat & Informasi Warga' },
    { id: 'KKN & Kerjasama Desa', name: 'KKN & Kerjasama Desa', subtitle: 'Kemitraan Perguruan Tinggi & Instansi' }
];

function openConfirmModal() {
    validationError.value = '';

    if (!form.name.trim()) {
        validationError.value = 'Nama pengelola / instansi wajib diisi.';
        return;
    }
    if (!form.phone.trim()) {
        validationError.value = 'Nomor WhatsApp / telepon wajib diisi.';
        return;
    }

    showConfirmModal.value = true;
}

function submitForm() {
    isSubmitting.value = true;

    router.put(`/admin/kontak/${form.id}`, {
        name: form.name,
        phone: form.phone,
        role: form.role,
        email: form.email,
        address: form.address,
        is_primary: form.is_primary,
        is_active: form.is_active
    }, {
        onFinish: () => {
            isSubmitting.value = false;
            showConfirmModal.value = false;
        }
    });
}
</script>

<template>
    <Head :title="`Edit Kontak: ${form.name} — Admin BIL`" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 sm:p-6 bg-[#f6f1e2]/30 rounded-2xl w-full">
        
        <!-- Top Back Link -->
        <div class="flex items-center justify-between">
            <Link
                href="/admin/kontak"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-2xs"
            >
                <ArrowLeft class="w-4 h-4 text-[#c1852c]" />
                <span>Kembali ke Kelola Kontak</span>
            </Link>
        </div>

        <!-- Header Banner -->
        <div class="bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 sm:p-8 shadow-sm border border-[#2b2417]/16">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-semibold mb-2">
                <PhoneCall class="w-3.5 h-3.5" />
                <span>Edit Kontak</span>
            </div>
            <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white">Edit Kontak Pengelola</h1>
            <p class="text-xs sm:text-sm text-[#f6f1e2]/85 mt-1">Perbarui nomor telepon, peruntukan, dan informasi pengelola yang terhubung pada katalog produk.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-[#fbf8ef] rounded-2xl p-6 sm:p-8 border border-[#2b2417]/16 shadow-xs w-full">
            <form @submit.prevent="openConfirmModal" class="space-y-6">
                
                <!-- Error Alert -->
                <div v-if="validationError" class="p-4 bg-red-100 border border-red-300 rounded-xl text-red-800 text-xs font-semibold flex items-center gap-2">
                    <AlertCircle class="w-4 h-4 shrink-0 text-red-600" />
                    <span>{{ validationError }}</span>
                </div>

                <!-- Nama Pengelola -->
                <div>
                    <label class="block font-fraunces font-semibold text-sm text-[#2c3821] mb-1.5">
                        Nama Pengelola / Instansi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <User class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            placeholder="Contoh: Ibu Siti Khadijah (PIC Sabun Jelantah)"
                            class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none shadow-2xs font-semibold"
                        />
                    </div>
                </div>

                <!-- Grid Telepon & Peruntukan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">
                            Nomor WhatsApp / Telepon <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <Phone class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.phone"
                                type="text"
                                required
                                placeholder="Contoh: 6281234567890"
                                class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none shadow-2xs font-semibold"
                            />
                        </div>
                        <span class="text-[11px] text-slate-500 mt-1 block">Gunakan format internasional tanpa spasi (misal: 6281234567890)</span>
                    </div>

                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">Peruntukan / Tipe Kontak</label>
                        <Select2Input
                            v-model="form.role"
                            :options="roleSelectOptions"
                            placeholder="Pilih Peruntukan Kontak..."
                            search-placeholder="Cari peruntukan..."
                        />
                    </div>
                </div>

                <!-- Grid Email & Alamat -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">Email Pengelola (Opsional)</label>
                        <div class="relative">
                            <Mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.email"
                                type="email"
                                placeholder="Contoh: sitikhadijah@gmail.com"
                                class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none shadow-2xs font-medium"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-xs text-[#2c3821] mb-1.5">Alamat / Lokasi Operasional (Opsional)</label>
                        <div class="relative">
                            <MapPin class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="form.address"
                                type="text"
                                placeholder="Contoh: Desa Karangampel RT 04 / RW 02"
                                class="w-full pl-10 pr-4 py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none shadow-2xs font-medium"
                            />
                        </div>
                    </div>
                </div>

                <!-- Status Switches -->
                <div class="p-4 bg-white rounded-xl border border-[#2b2417]/16 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            v-model="form.is_primary"
                            type="checkbox"
                            class="w-4 h-4 rounded text-[#c1852c] focus:ring-[#c1852c] border-slate-300"
                        />
                        <span class="text-xs font-semibold text-slate-800">Set sebagai Kontak Utama Publik (Primary Contact)</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="w-4 h-4 rounded text-[#2c3821] focus:ring-[#2c3821] border-slate-300"
                        />
                        <span class="text-xs font-semibold text-slate-800">Status Aktif (Tampil di Opsi Pemesanan)</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#2b2417]/10">
                    <Link
                        href="/admin/kontak"
                        class="px-5 py-2.5 rounded-full border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-colors"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-semibold shadow-md flex items-center gap-2 transition-colors cursor-pointer"
                    >
                        <Save class="w-4 h-4 text-[#c1852c]" />
                        <span>Update Kontak</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- FORM ENTRY SUMMARY CONFIRMATION MODAL -->
        <div
            v-if="showConfirmModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/80 backdrop-blur-xs"
            @click.self="showConfirmModal = false"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-[#2b2417]/16">
                <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 rounded-lg bg-[#c1852c]/10 text-[#c1852c]">
                            <ClipboardCheck class="w-5 h-5" />
                        </div>
                        <h3 class="font-fraunces font-bold text-lg text-[#2c3821]">Konfirmasi Perubahan Kontak</h3>
                    </div>
                    <button @click="showConfirmModal = false" class="text-slate-400 hover:text-slate-600">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <div class="space-y-3 text-xs text-slate-700 bg-white p-4 rounded-xl border border-[#2b2417]/16 mb-6">
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Nama Pengelola:</span>
                        <span class="font-bold text-slate-900">{{ form.name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Nomor Telepon / WA:</span>
                        <span class="font-bold text-emerald-700">+{{ form.phone }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Peruntukan:</span>
                        <span class="font-semibold text-[#c1852c]">{{ form.role }}</span>
                    </div>
                    <div v-if="form.email" class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Email:</span>
                        <span class="font-medium text-slate-800">{{ form.email }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">Status Aktif:</span>
                        <span class="font-bold" :class="form.is_active ? 'text-emerald-600' : 'text-slate-400'">
                            {{ form.is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button
                        type="button"
                        @click="showConfirmModal = false"
                        class="px-4 py-2.5 rounded-full border border-slate-300 text-slate-700 bg-white hover:bg-slate-100 text-xs font-semibold transition-colors"
                    >
                        Periksa Kembali
                    </button>
                    <button
                        type="button"
                        @click="submitForm"
                        :disabled="isSubmitting"
                        class="px-5 py-2.5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-semibold shadow-md flex items-center gap-1.5 transition-colors cursor-pointer"
                    >
                        <Check class="w-4 h-4 text-emerald-400" />
                        <span>Ya, Update Sekarang</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>
