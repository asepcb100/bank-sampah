<script setup lang="ts">
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import { ChevronDown, Search, Check, X } from '@lucide/vue';

interface SelectOption {
    id: number | string;
    name: string;
    subtitle?: string;
    badge?: string;
}

const props = withDefaults(defineProps<{
    modelValue?: number | string;
    options: SelectOption[];
    placeholder?: string;
    searchPlaceholder?: string;
}>(), {
    placeholder: 'Pilih opsi...',
    searchPlaceholder: 'Cari opsi...'
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const searchQuery = ref('');
const containerRef = ref<HTMLElement | null>(null);

const selectedOption = computed(() => {
    return props.options.find(opt => String(opt.id) === String(props.modelValue)) || null;
});

const filteredOptions = computed(() => {
    if (!searchQuery.value.trim()) return props.options;
    const q = searchQuery.value.toLowerCase();
    return props.options.filter(opt =>
        opt.name.toLowerCase().includes(q) || (opt.subtitle && opt.subtitle.toLowerCase().includes(q))
    );
});

function selectOption(opt: SelectOption) {
    emit('update:modelValue', opt.id);
    isOpen.value = false;
    searchQuery.value = '';
}

function handleClickOutside(event: MouseEvent) {
    if (containerRef.value && !containerRef.value.contains(event.target as Node)) {
        isOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div ref="containerRef" class="relative w-full">
        <!-- Trigger Button -->
        <button
            type="button"
            @click="isOpen = !isOpen"
            class="w-full px-4 py-2.5 sm:py-3 bg-white border border-[#2b2417]/20 rounded-xl text-xs sm:text-sm text-slate-800 focus:ring-2 focus:ring-[#c1852c] focus:outline-none flex items-center justify-between shadow-2xs transition-all text-left font-semibold cursor-pointer hover:border-[#c1852c]/50"
            :class="{ 'ring-2 ring-[#c1852c] border-[#c1852c]': isOpen }"
        >
            <div class="flex items-center gap-2 truncate pr-2">
                <span v-if="selectedOption" class="truncate text-slate-900 font-semibold">
                    {{ selectedOption.name }}
                </span>
                <span v-if="selectedOption?.subtitle" class="text-[11px] text-slate-400 font-normal truncate">
                    ({{ selectedOption.subtitle }})
                </span>
                <span v-if="!selectedOption" class="text-slate-400 font-normal">
                    {{ placeholder }}
                </span>
            </div>
            <ChevronDown class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200" :class="{ 'rotate-180 text-[#c1852c]': isOpen }" />
        </button>

        <!-- Dropdown Popover -->
        <Transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="transform scale-95 opacity-0 -translate-y-1"
            enter-to-class="transform scale-100 opacity-100 translate-y-0"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="transform scale-100 opacity-100 translate-y-0"
            leave-to-class="transform scale-95 opacity-0 -translate-y-1"
        >
            <div
                v-if="isOpen"
                class="absolute left-0 right-0 top-full mt-1.5 z-50 bg-white rounded-xl shadow-xl border border-[#2b2417]/16 p-2 overflow-hidden"
            >
                <!-- Search Box -->
                <div class="relative mb-2">
                    <Search class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="searchQuery"
                        type="text"
                        :placeholder="searchPlaceholder"
                        class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-[#c1852c] focus:outline-none font-medium text-slate-800"
                        @click.stop
                    />
                </div>

                <!-- Options List -->
                <div class="max-h-48 overflow-y-auto divide-y divide-slate-50 pr-0.5">
                    <button
                        v-for="opt in filteredOptions"
                        :key="opt.id"
                        type="button"
                        @click="selectOption(opt)"
                        class="w-full text-left px-3 py-2 rounded-lg text-xs transition-colors flex items-center justify-between gap-2 cursor-pointer"
                        :class="[
                            String(opt.id) === String(modelValue) ? 'bg-[#2c3821]/10 font-bold text-[#2c3821]' : 'hover:bg-slate-50 text-slate-700 font-medium'
                        ]"
                    >
                        <div class="truncate">
                            <span class="block truncate">{{ opt.name }}</span>
                            <span v-if="opt.subtitle" class="block text-[10px] text-slate-400 font-normal truncate">
                                {{ opt.subtitle }}
                            </span>
                        </div>
                        <Check v-if="String(opt.id) === String(modelValue)" class="w-4 h-4 text-[#2c3821] shrink-0" />
                    </button>

                    <div v-if="filteredOptions.length === 0" class="py-3 text-center text-slate-400 text-xs italic">
                        Tidak ada pilihan sesuai pencarian
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>
