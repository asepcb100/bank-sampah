@extends('layouts.admin')

@section('title', 'Profil Pengguna — Bank Sampah Bumi Indramayu Lestari')

@section('page-heading', 'Profil & Pengaturan Akun')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- TAB BUTTONS BAR (3 TABS) -->
    <div class="flex items-center gap-2 p-1.5 bg-[#f6f1e2] rounded-2xl border border-[#2b2417]/14 overflow-x-auto">
        <button type="button" 
                onclick="switchProfileTab('info')" 
                id="btn-tab-info" 
                class="profile-tab-btn px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2 bg-[#2c3821] text-[#fbf8ef] shadow-xs cursor-pointer whitespace-nowrap">
            <svg class="w-4 h-4 text-[#c1852c]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Informasi Pengguna</span>
        </button>

        <button type="button" 
                onclick="switchProfileTab('sandi')" 
                id="btn-tab-sandi" 
                class="profile-tab-btn px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2 text-[#5a5040] hover:bg-white/60 cursor-pointer whitespace-nowrap">
            <svg class="w-4 h-4 text-[#c1852c]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <span>Ubah Sandi</span>
        </button>

        <button type="button" 
                onclick="switchProfileTab('hapus')" 
                id="btn-tab-hapus" 
                class="profile-tab-btn px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2 text-rose-700 hover:bg-rose-50/60 cursor-pointer whitespace-nowrap">
            <svg class="w-4 h-4 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18"/>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                <line x1="10" y1="11" x2="10" y2="17"/>
                <line x1="14" y1="11" x2="14" y2="17"/>
            </svg>
            <span>Hapus Akun</span>
        </button>
    </div>

    <!-- TAB 1: INFORMASI PENGGUNA -->
    <div id="content-tab-info" class="profile-tab-content block">
        <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-6">
            <div>
                <h2 class="font-fraunces font-bold text-xl text-[#2c3821]">Informasi Profil</h2>
                <p class="text-xs text-[#6b6150] mt-1">Perbarui nama lengkap dan alamat email akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div class="grid gap-1.5">
                    <label class="text-xs font-bold text-[#2c3821]">Nama Lengkap</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', auth()->user()->name) }}" 
                           required 
                           class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                    @error('name')
                        <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-1.5">
                    <label class="text-xs font-bold text-[#2c3821]">Alamat Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', auth()->user()->email) }}" 
                           required 
                           class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                    @error('email')
                        <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                        <div class="mt-2 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 flex items-center justify-between">
                            <span>Email Anda belum diverifikasi.</span>
                            <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="font-bold underline text-amber-900 hover:text-amber-700">Kirim Verifikasi</button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-[#2b2417]/10">
                    <button type="submit" class="px-6 py-3 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-xs cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 2: UBAH SANDI -->
    <div id="content-tab-sandi" class="profile-tab-content hidden">
        <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-6">
            <div>
                <h2 class="font-fraunces font-bold text-xl text-[#2c3821]">Ubah Kata Sandi</h2>
                <p class="text-xs text-[#6b6150] mt-1">Pastikan akun Anda menggunakan kata sandi yang aman dan tidak mudah ditebak.</p>
            </div>

            <form method="POST" action="{{ route('user-password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-1.5">
                    <label class="text-xs font-bold text-[#2c3821]">Kata Sandi Saat Ini</label>
                    <input type="password" 
                           name="current_password" 
                           required 
                           autocomplete="current-password" 
                           class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                    @error('current_password')
                        <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-1.5">
                    <label class="text-xs font-bold text-[#2c3821]">Kata Sandi Baru</label>
                    <input type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password" 
                           class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                    @error('password')
                        <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-1.5">
                    <label class="text-xs font-bold text-[#2c3821]">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password" 
                           class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-[#2b2417]/10">
                    <button type="submit" class="px-6 py-3 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-xs cursor-pointer">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 3: HAPUS AKUN -->
    <div id="content-tab-hapus" class="profile-tab-content hidden">
        <div class="bg-rose-50/60 rounded-3xl border border-rose-200 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 border border-rose-200">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-fraunces font-bold text-xl text-rose-900">Hapus Akun Admin</h2>
                    <p class="text-xs text-rose-700/80 mt-1 leading-relaxed">
                        Tindakan ini bersifat permanen. Setelah akun dihapus, seluruh data profil dan hak akses Anda akan dihapus secara permanen dan tidak dapat dipulihkan.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?')" class="pt-3 border-t border-rose-200/80 space-y-4">
                @csrf
                @method('DELETE')

                <div class="grid gap-1.5 max-w-md">
                    <label class="text-xs font-bold text-rose-900">Konfirmasi Kata Sandi Anda</label>
                    <input type="password" 
                           name="password" 
                           placeholder="Masukkan kata sandi saat ini"
                           required 
                           class="w-full px-4 py-3 bg-white border border-rose-300 rounded-2xl text-xs sm:text-sm font-semibold text-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all shadow-2xs" />
                    @error('password')
                        <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="px-6 py-3 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all shadow-xs cursor-pointer">
                    Ya, Hapus Akun Ini
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function switchProfileTab(tabKey) {
    document.querySelectorAll('.profile-tab-content').forEach(el => {
        el.classList.add('hidden');
        el.classList.remove('block');
    });
    document.querySelectorAll('.profile-tab-btn').forEach(btn => {
        btn.classList.remove('bg-[#2c3821]', 'text-[#fbf8ef]', 'shadow-xs');
        btn.classList.add('text-[#5a5040]');
    });

    const targetContent = document.getElementById('content-tab-' + tabKey);
    const targetBtn = document.getElementById('btn-tab-' + tabKey);

    if (targetContent) {
        targetContent.classList.remove('hidden');
        targetContent.classList.add('block');
    }
    if (targetBtn) {
        targetBtn.classList.add('bg-[#2c3821]', 'text-[#fbf8ef]', 'shadow-xs');
        targetBtn.classList.remove('text-[#5a5040]');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if ($errors->has('current_password') || $errors->has('password'))
        switchProfileTab('sandi');
    @endif
});
</script>
@endsection
