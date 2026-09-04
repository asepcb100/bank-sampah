@extends('layouts.admin')

@section('title', 'Keamanan')

@section('page-heading', 'Keamanan')

@section('content')
<div class="max-w-2xl">
    @if ($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm font-semibold text-red-600">{{ implode(' ', $errors->all()) }}</div>
    @endif

    <form method="POST" action="{{ route('user-password.update') }}" class="bg-[#fbf8ef] rounded-xl border border-[#2b2417]/16 p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <h2 class="font-fraunces font-semibold text-lg text-[#2c3821] mb-1">Ubah Kata Sandi</h2>
            <p class="text-xs text-[#6b6150] mb-4">Gunakan kata sandi yang kuat dan simpan di tempat aman.</p>
        </div>

        <div class="grid gap-1.5">
            <label class="text-xs font-semibold text-slate-700">Kata Sandi Saat Ini</label>
            <input type="password" name="current_password" required autocomplete="current-password" class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#527838]" />
        </div>

        <div class="grid gap-1.5">
            <label class="text-xs font-semibold text-slate-700">Kata Sandi Baru</label>
            <input type="password" name="password" required autocomplete="new-password" class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#527838]" />
            <p class="text-[11px] text-[#6b6150]">Minimal {{ $passwordRules }}</p>
        </div>

        <div class="grid gap-1.5">
            <label class="text-xs font-semibold text-slate-700">Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#527838]" />
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-[#2c3821] text-[#fbf8ef] px-6 py-2.5 rounded-full text-xs font-semibold hover:bg-[#4c5c31] transition-colors">Simpan</button>
            @if (session('success'))<span class="text-xs font-semibold text-[#527838]">{{ session('success') }}</span>@endif
        </div>
    </form>

    <div class="mt-4">
        <a href="{{ route('logout') }}" class="text-xs font-semibold text-[#527838] hover:text-[#3d5a2a]" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar dari akun</a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
    </div>
</div>
@endsection
