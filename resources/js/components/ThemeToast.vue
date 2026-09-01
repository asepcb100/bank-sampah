<script setup lang="ts">
import { usePage, router } from '@inertiajs/vue3';
import { CheckCircle2, AlertTriangle, X, Info } from '@lucide/vue';
import { ref, computed, watch, onMounted } from 'vue';

const page = usePage();
const visible = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error' | 'info'>('success');
const toastTitle = ref('Berhasil!');
let timer: ReturnType<typeof setTimeout> | null = null;

function showToast(message: string, type: 'success' | 'error' | 'info' = 'success', title?: string) {
    if (!message) return;
    toastMessage.value = message;
    toastType.value = type;
    toastTitle.value = title || (type === 'success' ? 'Berhasil!' : type === 'error' ? 'Gagal!' : 'Informasi');
    visible.value = true;

    if (timer) clearTimeout(timer);
    timer = setTimeout(() => {
        visible.value = false;
    }, 4000);
}

function hideToast() {
    visible.value = false;
}

// Flash computed accessor
const flashProp = computed(() => (page.props as any).flash);

watch(
    flashProp,
    (flash: any) => {
        if (flash?.success) {
            showToast(flash.success, 'success', 'Berhasil Disimpan!');
        } else if (flash?.error) {
            showToast(flash.error, 'error', 'Terjadi Kesalahan');
        } else if (flash?.message) {
            showToast(flash.message, 'info', 'Pemberitahuan');
        }
    },
    { immediate: true, deep: true }
);

// Listen to Inertia router finish event for flash messages
router.on('finish', () => {
    const flash = (page.props as any).flash;
    if (flash?.success) {
        showToast(flash.success, 'success', 'Berhasil!');
    } else if (flash?.error) {
        showToast(flash.error, 'error', 'Gagal!');
    }
});

// Listen to custom window events for instant local client actions (e.g. delete item, inline update)
onMounted(() => {
    window.addEventListener('show-theme-toast', (e: any) => {
        if (e.detail?.message) {
            showToast(e.detail.message, e.detail.type || 'success', e.detail.title);
        }
    });
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="transform translate-y-[-20px] opacity-0 scale-95"
            enter-to-class="transform translate-y-0 opacity-100 scale-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="transform translate-y-0 opacity-100 scale-100"
            leave-to-class="transform translate-y-[-20px] opacity-0 scale-95"
        >
            <div
                v-if="visible"
                class="fixed top-5 right-5 z-50 max-w-sm w-full p-4 rounded-2xl shadow-2xl border flex items-start gap-3.5 backdrop-blur-md"
                :class="[
                    toastType === 'success' ? 'bg-[#2c3821] text-[#fbf8ef] border-[#4c5c31]' :
                    toastType === 'error' ? 'bg-red-900 text-white border-red-700' : 'bg-[#fbf8ef] text-[#2c3821] border-[#c1852c]/40'
                ]"
            >
                <!-- Icon -->
                <div class="p-1 rounded-full shrink-0" :class="[
                    toastType === 'success' ? 'bg-emerald-500/20 text-emerald-400' :
                    toastType === 'error' ? 'bg-red-500/20 text-red-400' : 'bg-[#c1852c]/20 text-[#c1852c]'
                ]">
                    <CheckCircle2 v-if="toastType === 'success'" class="w-6 h-6" />
                    <AlertTriangle v-else-if="toastType === 'error'" class="w-6 h-6" />
                    <Info v-else class="w-6 h-6" />
                </div>

                <!-- Text Content -->
                <div class="flex-1 min-w-0 pr-2">
                    <h4 class="font-fraunces font-bold text-sm tracking-wide" :class="[
                        toastType === 'success' ? 'text-white' : toastType === 'error' ? 'text-white' : 'text-[#2c3821]'
                    ]">
                        {{ toastTitle }}
                    </h4>
                    <p class="text-xs mt-0.5 opacity-90 leading-relaxed font-medium">
                        {{ toastMessage }}
                    </p>
                </div>

                <!-- Close Button -->
                <button
                    @click="hideToast"
                    class="p-1 rounded-lg hover:bg-white/10 transition-colors text-white/70 hover:text-white shrink-0 cursor-pointer"
                >
                    <X class="w-4 h-4" />
                </button>
            </div>
        </Transition>
    </Teleport>
</template>
