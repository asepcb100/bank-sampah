@extends('layouts.auth')

@section('title', 'Masuk ke Akun Admin')
@section('eyebrow', 'Selamat Datang Kembali!')
@section('page-title', 'Masuk ke Akun Admin')
@section('description', 'Masukkan alamat email dan kata sandi Anda untuk masuk ke sistem')

@section('form')
    @if (session('status'))
        <div class="mb-3 text-center text-xs font-semibold text-[#527838] bg-[#f0f4eb] p-2.5 rounded-xl border border-[#527838]/20">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-3 text-center text-xs font-semibold text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        <div class="grid gap-4">
            <div class="grid gap-1.5">
                <label for="email" class="text-xs font-semibold text-slate-700">Alamat Email</label>
                <div class="relative flex items-center">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@contoh.com"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
                </div>
            </div>

            <div class="grid gap-1.5">
                <label for="password" class="text-xs font-semibold text-slate-700">Kata Sandi</label>
                <div class="relative flex items-center">
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi"
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
                </div>
                @error('password')
                    <span class="text-[11px] text-red-500 mt-0.5">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-1">
                <label for="remember" class="flex items-center space-x-2.5 cursor-pointer text-xs font-medium text-slate-600">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300 text-[#527838] focus:ring-[#527838]">
                    <span>Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#527838] hover:text-[#3d5a2a]">Lupa kata sandi?</a>
                @endif
            </div>

            <button type="submit" class="mt-2 w-full bg-[#527838] hover:bg-[#42622d] active:bg-[#355024] text-white font-bold text-xs py-3 px-6 rounded-full shadow-md hover:shadow-lg transition-all duration-150 flex items-center justify-center gap-2 cursor-pointer border-0">
                <span>Masuk</span>
            </button>

            @if (Route::has('register'))
                <p class="text-center text-xs text-slate-500 mt-2">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-[#527838] hover:text-[#3d5a2a]">Daftar Sekarang</a>
                </p>
            @endif
        </div>
    </form>
@endsection
