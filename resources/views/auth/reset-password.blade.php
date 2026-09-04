@extends('layouts.auth')

@section('title', 'Reset Kata Sandi')
@section('eyebrow', 'Buat Kata Sandi Baru')
@section('page-title', 'Atur Ulang Kata Sandi')
@section('description', 'Buat kata sandi baru untuk akun Anda')

@section('form')
    @if ($errors->any())
        <div class="mb-3 text-center text-xs font-semibold text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="grid gap-4">
            <div class="grid gap-1.5">
                <label for="email" class="text-xs font-semibold text-slate-700">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus autocomplete="email"
                    class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
            </div>

            <div class="grid gap-1.5">
                <label for="password" class="text-xs font-semibold text-slate-700">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Kata sandi baru"
                    class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
            </div>

            <div class="grid gap-1.5">
                <label for="password_confirmation" class="text-xs font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi"
                    class="w-full px-4 py-2.5 bg-slate-50/60 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#527838] focus:border-[#527838] focus:bg-white transition-all placeholder:text-slate-400" />
            </div>

            <button type="submit" class="mt-2 w-full bg-[#527838] hover:bg-[#42622d] text-white font-bold text-xs py-3 px-6 rounded-full shadow-md hover:shadow-lg transition-all cursor-pointer border-0">
                Reset Kata Sandi
            </button>
        </div>
    </form>
@endsection
