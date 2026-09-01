<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
const name = usePage().props.name || 'Bank Sampah';
</script>

<template>
    <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-full bg-white p-0.5 border border-slate-200 shadow-xs flex items-center justify-center overflow-hidden shrink-0">
            <img src="/img/logo.png" alt="Logo" class="w-full h-full object-contain" />
        </div>
        <div class="grid flex-1 text-left leading-tight">
            <span class="font-black text-[#c1852c] text-[10px] tracking-wider uppercase">BANK SAMPAH</span>
            <span class="font-bold text-[#2c3821] text-xs truncate">Bumi Indramayu Lestari</span>
        </div>
    </div>
</template>
