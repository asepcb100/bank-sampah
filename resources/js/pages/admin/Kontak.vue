<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Phone,
    Plus,
    Search,
    Mail,
    UserCheck,
    MessageSquare,
    Edit3,
    Trash2,
    CheckCircle2,
    Clock,
    MapPin,
    AlertTriangle
} from '@lucide/vue';
import { ref, computed } from 'vue';

interface ContactItem {
    id: number;
    name: string;
    phone: string;
    role: string;
    email?: string;
    address?: string;
    is_primary: boolean;
    is_active: boolean;
}

interface MessageItem {
    id: number;
    name: string;
    email: string;
    phone?: string;
    subject?: string;
    message: string;
    status: 'unread' | 'read' | 'replied';
    created_at: string;
}

const props = defineProps<{
    contacts?: ContactItem[];
    messages?: MessageItem[];
}>();

const activeTab = ref<'contacts' | 'messages'>('contacts');
const searchQuery = ref('');

// Delete Confirmation Modal State
const showDeleteModal = ref(false);
const selectedContact = ref<ContactItem | null>(null);

const defaultContacts: ContactItem[] = [
    {
        id: 1,
        name: 'Layanan Utama BIL',
        phone: '628112442322',
        role: 'Customer Service & Admin Utama',
        email: 'admin@bumi-indramayu.id',
        address: 'Jl. Raya Indramayu No. 45',
        is_primary: true,
        is_active: true
    },
    {
        id: 2,
        name: 'Ibu Siti Khadijah',
        phone: '6281234567890',
        role: 'PIC Produk Sabun & Olahan Jelantah',
        email: 'siti@bumi-indramayu.id',
        address: 'Kelompok Perempuan Karangampel',
        is_primary: false,
        is_active: true
    },
    {
        id: 3,
        name: 'Pak Budi Santoso',
        phone: '6281987654321',
        role: 'PIC Pupuk Kompos & Eco-Enzyme Organik',
        email: 'budi@bumi-indramayu.id',
        address: 'Unit Pengolahan Organik Desa',
        is_primary: false,
        is_active: true
    },
    {
        id: 4,
        name: 'Mbak Rina Wati',
        phone: '6285712345678',
        role: 'PIC Kerajinan Ecobrick & Perca',
        email: 'rina@bumi-indramayu.id',
        address: 'Sanggar Daur Ulang Pemuda',
        is_primary: false,
        is_active: true
    }
];

const contactsList = ref<ContactItem[]>(
    props.contacts && props.contacts.length > 0 ? [...props.contacts] : defaultContacts
);

const listContacts = computed(() => {
    return contactsList.value.filter(c => 
        c.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
        c.role.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const listMessages = computed(() => {
    const data = props.messages && props.messages.length > 0 ? props.messages : [
        {
            id: 1,
            name: 'Ahmad Fauzi',
            email: 'ahmad.fauzi@gmail.com',
            phone: '081234567891',
            subject: 'Pertanyaan Pemesanan Sabun Jelantah Skala Grosir',
            message: 'Halo Admin BIL, kami dari warung makan lokal tertarik memesan sabun jelantah jumlah 50 pcs untuk pembersih noda dapur. Mohon informasi harga grosirnya.',
            status: 'unread' as const,
            created_at: '01 Sep 2026'
        },
        {
            id: 2,
            name: 'Dewi Anggraini',
            email: 'dewi.anggraini@yahoo.com',
            phone: '085712348899',
            subject: 'Permohonan Edukasi Pemilahan Sampah Sekolah',
            message: 'Selamat siang, kami ingin mengundang tim Bank Sampah BIL untuk menjadi narasumber edukasi lingkungan di sekolah kami pada bulan depan.',
            status: 'read' as const,
            created_at: '28 Agu 2026'
        }
    ];

    return data.filter(m => m.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || m.message.toLowerCase().includes(searchQuery.value.toLowerCase()));
});

function confirmDeleteContact(contact: ContactItem) {
    selectedContact.value = contact;
    showDeleteModal.value = true;
}

function deleteContactItem() {
    if (selectedContact.value) {
        const deletedName = selectedContact.value.name;
        contactsList.value = contactsList.value.filter(c => c.id !== selectedContact.value?.id);
        
        window.dispatchEvent(new CustomEvent('show-theme-toast', {
            detail: { message: `Kontak "${deletedName}" berhasil dihapus!`, type: 'success', title: 'Berhasil Dihapus!' }
        }));
    }
    showDeleteModal.value = false;
    selectedContact.value = null;
}
</script>

<template>
    <Head title="Kelola Kontak & Pesan Warga — Admin BIL" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 sm:p-6 bg-[#f6f1e2]/30 rounded-2xl w-full">
        
        <!-- Header Banner -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-[#2c3821] text-[#f6f1e2] rounded-2xl p-6 shadow-sm border border-[#2b2417]/16">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-semibold mb-2">
                    <Phone class="w-3.5 h-3.5" />
                    <span>Layanan Kontak & Pesan</span>
                </div>
                <h1 class="font-fraunces font-bold text-2xl text-white">Kelola Kontak PIC & Pesan Warga</h1>
                <p class="text-xs text-[#f6f1e2]/85 mt-1">Atur master data kontak penanggung jawab WA dan tanggapi pesan masuk dari pengunjung web.</p>
            </div>

            <div class="flex items-center gap-2">
                <Link
                    v-if="activeTab === 'contacts'"
                    href="/admin/kontak/create"
                    class="px-4 py-2.5 bg-[#c1852c] hover:bg-[#a67022] text-[#fbf8ef] rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs cursor-pointer"
                >
                    <Plus class="w-4 h-4" />
                    <span>Tambah Kontak PIC</span>
                </Link>
            </div>
        </div>

        <!-- Navigation Tabs + Search Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2 p-1 bg-white rounded-full border border-slate-200 w-fit">
                <button
                    @click="activeTab = 'contacts'"
                    type="button"
                    class="px-5 py-2 rounded-full text-xs font-semibold transition-all cursor-pointer flex items-center gap-2"
                    :class="[
                        activeTab === 'contacts'
                            ? 'bg-[#2c3821] text-[#fbf8ef] shadow-xs'
                            : 'text-slate-600 hover:text-slate-900'
                    ]"
                >
                    <UserCheck class="w-4 h-4" />
                    <span>Daftar Kontak PIC WA</span>
                </button>
                <button
                    @click="activeTab = 'messages'"
                    type="button"
                    class="px-5 py-2 rounded-full text-xs font-semibold transition-all cursor-pointer flex items-center gap-2"
                    :class="[
                        activeTab === 'messages'
                            ? 'bg-[#2c3821] text-[#fbf8ef] shadow-xs'
                            : 'text-slate-600 hover:text-slate-900'
                    ]"
                >
                    <MessageSquare class="w-4 h-4" />
                    <span>Pesan Masuk Warga</span>
                </button>
            </div>

            <div class="relative sm:w-72">
                <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Cari kontak atau isi pesan..."
                    class="w-full pl-10 pr-4 py-2 bg-white rounded-full text-xs text-slate-800 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#c1852c] shadow-2xs"
                />
            </div>
        </div>

        <!-- TAB 1: Daftar Kontak PIC WA -->
        <div v-if="activeTab === 'contacts'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            <div
                v-for="contact in listContacts"
                :key="contact.id"
                class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between"
            >
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-[#c1852c] uppercase tracking-wider">{{ contact.role }}</span>
                        <span v-if="contact.is_primary" class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                            Utama
                        </span>
                    </div>

                    <h3 class="font-fraunces font-bold text-base text-[#2c3821] mb-2">{{ contact.name }}</h3>

                    <div class="space-y-1.5 text-xs text-slate-600 mb-4">
                        <div class="flex items-center gap-2 text-slate-800 font-semibold">
                            <Phone class="w-4 h-4 text-emerald-600" />
                            <span>+{{ contact.phone }}</span>
                        </div>
                        <div v-if="contact.email" class="flex items-center gap-2 text-slate-500">
                            <Mail class="w-3.5 h-3.5" />
                            <span>{{ contact.email }}</span>
                        </div>
                        <div v-if="contact.address" class="flex items-center gap-2 text-slate-500">
                            <MapPin class="w-3.5 h-3.5" />
                            <span>{{ contact.address }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                    <a
                        :href="`https://wa.me/${contact.phone}`"
                        target="_blank"
                        class="text-xs font-semibold text-emerald-600 hover:underline flex items-center gap-1"
                    >
                        <Phone class="w-3.5 h-3.5" />
                        <span>Tes Chat WA</span>
                    </a>

                    <div class="flex items-center gap-1.5">
                        <Link
                            :href="`/admin/kontak/${contact.id}/edit`"
                            class="p-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-[#2c3821] hover:text-white transition-colors cursor-pointer"
                            title="Edit Kontak"
                        >
                            <Edit3 class="w-3.5 h-3.5" />
                        </Link>
                        <button
                            @click="confirmDeleteContact(contact)"
                            class="p-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-600 hover:text-white transition-colors cursor-pointer"
                            title="Hapus Kontak"
                        >
                            <Trash2 class="w-3.5 h-3.5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: Pesan Masuk Warga -->
        <div v-else class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-[#f8f9fa] border-b border-slate-200 text-slate-600 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3.5 px-4 font-semibold">Pengirim</th>
                            <th class="py-3.5 px-4 font-semibold">Subjek & Isi Pesan</th>
                            <th class="py-3.5 px-4 font-semibold">Tanggal</th>
                            <th class="py-3.5 px-4 font-semibold">Status</th>
                            <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="msg in listMessages" :key="msg.id" class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ msg.name }}</div>
                                <div class="text-[11px] text-slate-500">{{ msg.email }}</div>
                                <div v-if="msg.phone" class="text-[11px] text-emerald-600 font-medium">+{{ msg.phone }}</div>
                            </td>
                            <td class="py-3.5 px-4 max-w-sm">
                                <div class="font-semibold text-[#2c3821] mb-0.5">{{ msg.subject }}</div>
                                <div class="text-xs text-slate-600 leading-relaxed line-clamp-2">{{ msg.message }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                {{ msg.created_at }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                    :class="[
                                        msg.status === 'unread'
                                            ? 'bg-amber-100 text-amber-800'
                                            : 'bg-emerald-100 text-emerald-800'
                                    ]"
                                >
                                    <Clock v-if="msg.status === 'unread'" class="w-3 h-3" />
                                    <CheckCircle2 v-else class="w-3 h-3" />
                                    <span>{{ msg.status === 'unread' ? 'Belum Dibaca' : 'Sudah Dibaca' }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a
                                        v-if="msg.phone"
                                        :href="`https://wa.me/${msg.phone}?text=Halo%20${encodeURIComponent(msg.name)}`"
                                        target="_blank"
                                        class="px-3 py-1.5 bg-[#2c3821] text-[#fbf8ef] hover:bg-[#4c5c31] rounded-full text-[11px] font-semibold transition-colors flex items-center gap-1"
                                    >
                                        <Phone class="w-3 h-3" />
                                        <span>Balas WA</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DELETE CONFIRMATION MODAL -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#141008]/80 backdrop-blur-xs"
            @click.self="showDeleteModal = false"
        >
            <div class="relative bg-[#fbf8ef] rounded-2xl max-w-md w-full p-6 shadow-2xl border border-[#2b2417]/16 text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 mx-auto flex items-center justify-center mb-4">
                    <AlertTriangle class="w-6 h-6" />
                </div>

                <h3 class="font-fraunces font-bold text-lg text-[#2c3821] mb-2">Konfirmasi Hapus Kontak</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-6">
                    Apakah Anda yakin ingin menghapus kontak pengelola <span class="font-semibold text-slate-900">"{{ selectedContact?.name }}"</span>? Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex items-center justify-center gap-3">
                    <button
                        @click="showDeleteModal = false"
                        class="flex-1 py-2.5 rounded-full border border-slate-200 text-slate-700 bg-white hover:bg-slate-100 text-xs font-semibold transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        @click="deleteContactItem"
                        class="flex-1 py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-md transition-colors"
                    >
                        Ya, Hapus Kontak
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>
