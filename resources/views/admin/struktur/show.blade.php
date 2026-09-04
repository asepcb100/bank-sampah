@extends('layouts.admin')

@section('title', $item->nama . ' — Admin')

@section('page-heading', 'Detail Struktur Organisasi')

@section('content')
    <div class="max-w-full mx-auto space-y-6">

        <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-4">
            <a href="{{ route('admin.struktur') }}" class="px-4 py-2 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors shrink-0">
                ← Kembali ke Struktur
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.struktur.edit', $item->id) }}" class="px-4 py-2 rounded-full border border-[#c1852c]/30 bg-[#c1852c]/10 text-[#2c3821] hover:bg-[#c1852c]/20 text-xs font-bold transition-all">
                    ✏️ Edit
                </a>
                <button type="button" onclick="openDeleteModal('{{ route('admin.struktur.destroy', $item->id) }}', '{{ addslashes($item->nama) }}')" class="px-4 py-2 rounded-full border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition-all cursor-pointer">
                    🗑️ Hapus
                </button>
            </div>
        </div>

        <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 overflow-hidden shadow-sm">
            <div class="p-6 sm:p-8 {{ $item->badge === 'ochre' ? 'bg-[#c1852c]' : 'bg-[#2c3821]' }} text-[#fbf8ef] space-y-2">
                <span class="px-3 py-1 rounded-full bg-white/20 text-white text-[10px] font-bold uppercase tracking-wider">
                    {{ $item->tipe === 'inti' ? 'Pengurus Inti' : 'Divisi' }}
                </span>
                <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-white">{{ $item->nama }}</h1>
                @if ($item->jabatan)
                    <p class="text-xs text-[#dce6c8] font-bold">{{ $item->jabatan }}</p>
                @endif
            </div>

            <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white border border-[#2b2417]/14 rounded-2xl p-4">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#6b6150] mb-1">Tipe</p>
                    <p class="text-sm font-bold text-[#2c3821]">{{ $item->tipe === 'inti' ? 'Pengurus Inti' : 'Divisi' }}</p>
                </div>
                <div class="bg-white border border-[#2b2417]/14 rounded-2xl p-4">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#6b6150] mb-1">Urutan</p>
                    <p class="text-sm font-bold text-[#2c3821]">{{ $item->sort_order }}</p>
                </div>
            </div>

            <div class="p-6 sm:p-8 pt-0 space-y-6">
                @if ($item->tipe === 'inti')
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6b6150] mb-1">Jabatan</p>
                        <p class="text-sm text-[#2c3821]">{{ $item->jabatan ?? '-' }}</p>
                    </div>
                @elseif ($item->anggota)
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6b6150] mb-1">Anggota</p>
                        <p class="text-sm text-[#2c3821]">{{ $item->anggota }}</p>
                    </div>
                @endif

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#6b6150] mb-1">Deskripsi</p>
                    <p class="text-sm leading-relaxed text-[#54493a]">{{ $item->deskripsi ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>

@endsection
