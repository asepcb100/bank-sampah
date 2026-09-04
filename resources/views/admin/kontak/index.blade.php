@extends('layouts.admin')

@section('title', 'Kelola Kontak — Admin')

@section('page-heading', 'Kelola Kontak')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2b2417]/10 pb-4">
        <div>
            <h1 class="font-fraunces font-bold text-2xl text-[#2c3821]">Kontak Pengelola & PIC</h1>
            <p class="text-xs text-[#6b6150] mt-0.5">Kelola daftar penanggung jawab (PIC) kontak layanan Bank Sampah Bumi Indramayu Lestari.</p>
        </div>
        <a href="{{ route('admin.kontak.create') }}" class="inline-flex items-center justify-center bg-[#2c3821] text-[#fbf8ef] px-5 py-2.5 rounded-full text-xs font-bold hover:bg-[#4c5c31] transition-all shadow-xs shrink-0 cursor-pointer">
            + Tambah Kontak PIC
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <form method="GET" action="{{ route('admin.kontak') }}" class="bg-[#fbf8ef] border border-[#2b2417]/16 rounded-2xl p-4 flex flex-col sm:flex-row items-center gap-3 shadow-xs">
        <div class="relative flex-1 w-full">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#6b6150]">
                🔍
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, role/jabatan, telepon, email..." class="w-full pl-9 pr-4 py-2 bg-white border border-[#2b2417]/14 rounded-xl text-xs text-[#2c3821] focus:outline-none focus:border-[#2c3821] focus:ring-1 focus:ring-[#2c3821]">
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <button type="submit" class="px-4 py-2 bg-[#2c3821] text-[#fbf8ef] rounded-xl text-xs font-bold hover:bg-[#4c5c31] transition-colors cursor-pointer shrink-0">
                Filter
            </button>
            @if(request('search'))
                <a href="{{ route('admin.kontak') }}" class="px-4 py-2 bg-[#f6f1e2] border border-[#2b2417]/14 text-[#2c3821] rounded-xl text-xs font-bold hover:bg-[#e9c688]/40 transition-colors shrink-0">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Table Section -->
    <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 overflow-hidden shadow-sm">
        @if ($contacts->isEmpty())
            <div class="p-12 text-center text-xs text-[#6b6150]">
                @if(request('search'))
                    Data kontak PIC tidak ditemukan untuk pencarian ini.
                @else
                    Belum ada data kontak PIC.
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-[#2c3821] text-[#fbf8ef] uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Nama PIC</th>
                            <th class="px-5 py-3.5">Jabatan / Role</th>
                            <th class="px-5 py-3.5">No. Telepon / WA</th>
                            <th class="px-5 py-3.5">Email</th>
                            <th class="px-5 py-3.5">Status & Tipe</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2b2417]/10 font-semibold">
                        @foreach ($contacts as $contact)
                            <tr class="odd:bg-white even:bg-[#f6f1e2]/40 hover:bg-[#e9c688]/20 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-[#2c3821] text-[#fbf8ef] flex items-center justify-center font-bold text-xs shrink-0 font-fraunces">
                                            {{ collect(explode(' ', $contact->name))->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->join('') }}
                                        </div>
                                        <div class="font-bold text-[#2c3821] text-sm">{{ $contact->name }}</div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-[#c1852c]">
                                    {{ $contact->role ?: 'Pengelola BIL' }}
                                </td>
                                <td class="px-5 py-3.5 text-[#2c3821]">
                                    @if($contact->phone)
                                        <span class="inline-flex items-center gap-1 font-mono">
                                            <span>📞</span> {{ $contact->phone }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-normal">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-[#5a5040]">
                                    {{ $contact->email ?: '-' }}
                                </td>
                                <td class="px-5 py-3.5 space-x-1">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $contact->is_primary ? 'bg-amber-100 text-amber-900 border border-amber-300/60' : 'bg-slate-200 text-slate-700' }}">
                                        {{ $contact->is_primary ? 'Utama' : 'Pendukung' }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $contact->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-300/60' : 'bg-rose-100 text-rose-800 border border-rose-300/60' }}">
                                        {{ $contact->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.kontak.edit', $contact->id) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#e9c688]/40 text-[#2c3821] hover:bg-[#e9c688] transition-colors">
                                            Edit
                                        </a>
                                        <button type="button" 
                                                onclick="openDeleteModal('{{ route('admin.kontak.destroy', $contact->id) }}', '{{ addslashes($contact->name) }}')" 
                                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors cursor-pointer">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Server-Side Pagination Footer -->
            {{ $contacts->links() }}
        @endif
    </div>

</div>

@endsection
