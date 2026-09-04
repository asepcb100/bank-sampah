@extends('layouts.auth')

@section('title', 'Daftar Akun')
@section('eyebrow', 'Selamat Bergabung!')
@section('page-title', 'Daftar Akun Baru')
@section('description', 'Buat akun Anda untuk mengelola konten Bank Sampah')

@section('form')
    @if ($errors->any())
        <div class="mb-3 text-center text-xs font-semibold text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
        @csrf

        <div class="grid gap-4">
            <div class="grid gap-1.5">
                <label for="name" class="text-xs font-semibold text-slate-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Anda"
                    class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
                @error('name')<span class="text-[11px] text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="grid gap-1.5">
                <label for="email" class="text-xs font-semibold text-slate-700">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@contoh.com"
                    class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
                @error('email')<span class="text-[11px] text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="grid gap-1.5">
                <label for="password" class="text-xs font-semibold text-slate-700">Kata Sandi</label>
                <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Buat kata sandi"
                    class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
                @error('password')<span class="text-[11px] text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="grid gap-1.5">
                <label for="password_confirmation" class="text-xs font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi"
                    class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
            </div>

            <button type="submit" class="mt-2 w-full bg-[#527838] hover:bg-[#42622d] text-white font-bold text-xs py-3 px-6 rounded-full shadow-md hover:shadow-lg transition-all cursor-pointer border-0">
                Daftar
            </button>

            <p class="text-center text-xs text-slate-500 mt-2">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-[#527838] hover:text-[#3d5a2a]">Masuk</a>
            </p>
        </div>
    </form>
@endsection
