<script setup lang="ts">
import { ref } from 'vue';
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';
import { User, Lock, Eye, EyeOff, LogIn } from '@lucide/vue';

defineOptions({
    layout: {
        title: 'Masuk ke Akun Admin',
        description: 'Masukkan alamat email dan kata sandi Anda untuk masuk ke sistem',
    },
});

defineProps<{
    status?: string;
}>();

const showPassword = ref(false);
</script>

<template>
    <Head title="Masuk ke Akun Admin — Bank Sampah Bumi Indramayu Lestari" />

    <div
        v-if="status"
        class="mb-3 text-center text-xs font-semibold text-[#527838] bg-[#f0f4eb] p-2.5 rounded-xl border border-[#527838]/20"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-4"
    >
        <div class="grid gap-4">
            
            <!-- Email Field with User Icon -->
            <div class="grid gap-1.5">
                <Label for="email" class="text-xs font-semibold text-slate-700">Alamat Email</Label>
                <div class="relative flex items-center">
                    <User class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" />
                    <input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        tabindex="1"
                        autocomplete="email"
                        placeholder="nama@contoh.com"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400"
                    />
                </div>
                <InputError :message="errors.email" />
            </div>

            <!-- Password Field with Lock & Eye Toggle Icons -->
            <div class="grid gap-1.5">
                <Label for="password" class="text-xs font-semibold text-slate-700">Kata Sandi</Label>
                <div class="relative flex items-center">
                    <Lock class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" />
                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        required
                        tabindex="2"
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi"
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-3.5 text-slate-400 hover:text-slate-600 focus:outline-none"
                        tabindex="-1"
                    >
                        <EyeOff v-if="showPassword" class="w-4 h-4" />
                        <Eye v-else class="w-4 h-4" />
                    </button>
                </div>
                <InputError :message="errors.password" />
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center justify-between pt-1">
                <Label for="remember" class="flex items-center space-x-2.5 cursor-pointer text-xs font-medium text-slate-600">
                    <Checkbox id="remember" name="remember" tabindex="3" class="border-slate-300 data-[state=checked]:bg-[#527838] data-[state=checked]:border-[#527838]" />
                    <span>Ingat saya</span>
                </Label>
            </div>

            <!-- Submit Button with LogIn Icon -->
            <button
                type="submit"
                class="mt-2 w-full bg-[#527838] hover:bg-[#42622d] active:bg-[#355024] text-white font-bold text-xs py-3 px-6 rounded-full shadow-md hover:shadow-lg transition-all duration-150 flex items-center justify-center gap-2 cursor-pointer border-0"
                tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" class="h-4 w-4 text-white" />
                <LogIn v-else class="w-4 h-4" />
                <span>Masuk</span>
            </button>
        </div>
    </Form>
</template>
