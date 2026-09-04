@extends('layouts.auth')

@section('title', 'Verifikasi Email')
@section('eyebrow', 'Verifikasi Email')
@section('page-title', 'Verifikasi Alamat Email Anda')
@section('description', "Sebelum melanjutkan, periksa email Anda untuk tautan verifikasi.")

@section('form')
    @if (session('status') == 'verification-link-sent')
        <div class="mb-3 text-center text-xs font-semibold text-[#527838] bg-[#f0f4eb] p-2.5 rounded-xl border border-[#527838]/20">
            Tautan verifikasi baru telah dikirim ke email Anda.
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-3 text-center text-xs font-semibold text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-200">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="flex flex-col gap-4">
        @csrf
        <p class="text-center text-xs text-slate-500">Jika Anda tidak menerima email, klik tombol di bawah untuk mengirim ulang tautan verifikasi.</p>
        <button type="submit" class="mt-2 w-full bg-[#527838] hover:bg-[#42622d] text-white font-bold text-xs py-3 px-6 rounded-full shadow-md hover:shadow-lg transition-all cursor-pointer border-0">
            Kirim Ulang Email Verifikasi
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="w-full text-xs font-semibold text-slate-500 hover:text-slate-700">Keluar</button>
    </form>
@endsection
