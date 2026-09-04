@extends('layouts.admin')

@section('title', 'Tampilan')

@section('page-heading', 'Tampilan')

@section('content')
<div class="max-w-2xl">
    <div class="bg-[#fbf8ef] rounded-xl border border-[#2b2417]/16 p-6">
        <h2 class="font-fraunces font-semibold text-lg text-[#2c3821] mb-1">Tema Tampilan</h2>
        <p class="text-xs text-[#6b6150] mb-5">Pilih tampilan yang Anda sukai. Saat ini aplikasi menggunakan tema terang "Bumi" yang menyesuaikan identitas Bank Sampah Bumi Indramayu Lestari.</p>

        <div class="grid grid-cols-2 gap-4">
            <div class="rounded-xl border-2 border-[#527838] p-4 bg-[#f6f1e2]">
                <div class="h-24 rounded-lg bg-[#2c3821] mb-3 flex items-center justify-center text-[#fbf8ef] text-xs font-bold">Tanah Mataram</div>
                <p class="text-sm font-semibold text-[#2c3821]">Terang</p>
                <p class="text-xs text-[#6b6150]">Default · identitas Bumi</p>
            </div>
            <div class="rounded-xl border border-[#2b2417]/16 p-4 bg-slate-100 opacity-60">
                <div class="h-24 rounded-lg bg-slate-900 mb-3 flex items-center justify-center text-white text-xs font-bold">Gelap</div>
                <p class="text-sm font-semibold text-[#2c3821]">Gelap</p>
                <p class="text-xs text-[#6b6150]">Segera hadir</p>
            </div>
        </div>
    </div>
</div>
@endsection
