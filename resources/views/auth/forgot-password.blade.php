@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')
@section('eyebrow', 'Atur Ulang Kata Sandi')
@section('page-title', 'Lupa Kata Sandi?')
@section('description', 'Masukkan email terdaftar, kami akan kirim tautan reset')

@section('form')
    @if (session('status'))
        <div class="mb-3 text-center text-xs font-semibold text-[#527838] bg-[#f0f4eb] p-2.5 rounded-xl border border-[#527838]/20">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-3 text-center text-xs font-semibold text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
        @csrf

        <div class="grid gap-1.5">
            <label for="email" class="text-xs font-semibold text-slate-700">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@contoh.com"
                class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
        </div>

        <button type="submit" class="mt-2 w-full bg-[#527838] hover:bg-[#42622d] text-white font-bold text-xs py-3 px-6 rounded-full shadow-md hover:shadow-lg transition-all cursor-pointer border-0">
            Kirim Tautan Reset
        </button>

        <p class="text-center text-xs text-slate-500 mt-2">
            <a href="{{ route('login') }}" class="font-semibold text-[#527838] hover:text-[#3d5a2a]">← Kembali ke Login</a>
        </p>
    </form>
@endsection
