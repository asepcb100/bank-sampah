@extends('layouts.public')

@section('title', 'Bumi Indramayu Lestari — Berkontribusi memberi solusi untuk bumi lestari')

@section('content')
<!-- HERO SECTION -->
<section class="relative bg-[#f4efe4] pt-8 sm:pt-12 pb-16 sm:pb-24 overflow-hidden" id="beranda">
    
    <!-- Floating Background Leaves & Pattern Ornament -->
    <div class="absolute left-6 top-24 w-32 h-32 opacity-15 pointer-events-none hidden lg:block">
        <div class="grid grid-cols-4 gap-3 text-[#2c3821]">
            @for ($i = 0; $i < 16; $i++)
                <span class="w-1.5 h-1.5 rounded-full bg-[#2c3821]"></span>
            @endfor
        </div>
    </div>

    <!-- Foreground Bottom-Left Blurred Leaves Ornament -->
    <div class="absolute -bottom-10 -left-10 w-48 sm:w-64 h-48 sm:h-64 opacity-80 pointer-events-none z-20">
        <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-[#4c5c31]/40 filter blur-[1px]">
            <path d="M40 160C80 120 120 40 180 20C180 20 160 100 100 140C60 166.7 40 160 40 160Z" fill="#3f4f29" />
            <path d="M10 190C60 160 90 90 140 70C140 70 120 140 70 170C30 190 10 190 10 190Z" fill="#2c3821" opacity="0.6" />
        </svg>
    </div>

    <div class="max-w-[1240px] mx-auto px-6 sm:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
            
            <!-- Left Hero Content Column -->
            <div class="lg:col-span-6 space-y-6 sm:space-y-7">
                
                <!-- Top Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#dce6c8] text-[#2c3821] font-bold text-xs sm:text-sm border border-[#c6d6ab] shadow-2xs">
                    <svg class="w-4 h-4 text-[#4c5c31] fill-[#4c5c31]/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.4 19 2c1 2 2 4.1 2 9 0 4.9-4 9-9 9z"/><path d="M11 20v-5"/></svg>
                    <span>Komunitas Peduli Lingkungan · Kabupaten Indramayu</span>
                </div>

                <!-- Main Heading with Handwritten Brush Underline -->
                <h1 class="font-fraunces font-bold text-[#2c3821] text-4xl sm:text-5xl lg:text-[3.6rem] leading-[1.08] tracking-tight">
                    Berkontribusi<br />
                    memberi<br />
                    <span class="relative inline-block font-fraunces italic font-medium text-[#2c3821] px-1">
                        solusi
                        <svg class="absolute -bottom-2 left-0 w-full h-4 text-[#c1852c]" viewBox="0 0 200 20" fill="none" preserveAspectRatio="none">
                            <path d="M5 12C50 4 150 16 195 8" stroke="currentColor" stroke-width="4" stroke-linecap="round" />
                        </svg>
                    </span>
                    untuk<br />
                    bumi lestari.
                </h1>

                <!-- Paragraph Description -->
                <p class="text-[#4a4030] text-sm sm:text-base max-w-[48ch] leading-relaxed font-medium">
                    Sejak 2021, kami mengajak warga Indramayu menjalani hidup ramah lingkungan lewat langkah sederhana — dari memilah sampah di rumah sampai membangun ekonomi sirkular bersama.
                </p>

                <!-- CTA Action Buttons -->
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="#latar-belakang" class="inline-flex items-center gap-2 bg-[#4c5c31] hover:bg-[#2c3821] text-[#fbf8ef] px-7 py-3.5 rounded-full font-bold text-xs sm:text-sm transition-all shadow-md hover:shadow-lg cursor-pointer">
                        <svg class="w-4 h-4 fill-white/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.4 19 2c1 2 2 4.1 2 9 0 4.9-4 9-9 9z"/><path d="M11 20v-5"/></svg>
                        <span>Kenali Komunitas</span>
                    </a>
                    <a href="#kontak" class="inline-flex items-center gap-2 border-2 border-[#2c3821] hover:bg-[#2c3821] hover:text-[#fbf8ef] text-[#2c3821] px-7 py-3.5 rounded-full font-bold text-xs sm:text-sm transition-all">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>Hubungi Kami</span>
                    </a>
                </div>

                <!-- Bottom Floating Metrics / Stats Card -->
                <div class="pt-4 max-w-xl">
                    <div class="bg-[#fbf8ef]/95 backdrop-blur-md border border-[#2b2417]/14 rounded-2xl p-3.5 sm:p-5 shadow-sm grid grid-cols-3 divide-x divide-[#2b2417]/14 items-center">
                        <div class="flex items-center gap-2 sm:gap-3.5 pr-2 sm:pr-4">
                            <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-fraunces font-bold text-xs sm:text-base text-[#2c3821] truncate">2.150+</div>
                                <div class="text-[10px] sm:text-xs font-semibold text-slate-500 truncate">Warga Terlibat</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 sm:gap-3.5 px-2 sm:px-4">
                            <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.4 19 2c1 2 2 4.1 2 9 0 4.9-4 9-9 9z"/><path d="M11 20v-5"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-fraunces font-bold text-xs sm:text-base text-[#2c3821] truncate">48,6 Ton</div>
                                <div class="text-[10px] sm:text-xs font-semibold text-slate-500 truncate">Sampah Terkelola</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 sm:gap-3.5 pl-2 sm:pl-4">
                            <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-fraunces font-bold text-xs sm:text-base text-[#2c3821] truncate">16+</div>
                                <div class="text-[10px] sm:text-xs font-semibold text-slate-500 truncate">Program Berjalan</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Hero Visual Column -->
            <div class="lg:col-span-6 relative flex justify-center lg:justify-end lg:-mt-4">
                <div class="relative w-full max-w-lg aspect-[4/4.5] sm:aspect-[4/4] rounded-t-[140px] sm:rounded-t-[220px] rounded-b-[40px] overflow-hidden shadow-2xl border-4 border-white/80 bg-[#4c5c31] group">
                    @php
                        $heroGallery = $galleries->first();
                        $heroImg = $heroGallery ? ($heroGallery->image_url ?: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop') : 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop';
                    @endphp
                    <img src="{{ $heroImg }}" alt="Bumi Indramayu Lestari" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-90"></div>

                    <!-- Bottom Overlay Card -->
                    <div class="absolute bottom-6 left-6 right-6 bg-[#3c4a2a]/95 text-[#fbf8ef] p-4 sm:p-5 rounded-2xl shadow-2xl border border-white/20 backdrop-blur-md">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-full bg-[#f4efe4] text-[#3c4a2a] flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-[#dce6c8]">DOKUMENTASI UTAMA</span>
                                <h4 class="font-fraunces font-bold text-sm sm:text-base text-white truncate">{{ $heroGallery ? $heroGallery->title : 'Program Sedekah Sampah & Jelantah' }}</h4>
                                <a href="#galeri" class="inline-flex items-center gap-1 text-[11px] font-bold text-[#dce6c8] hover:underline mt-0.5">
                                    <span>Lihat galeri kegiatan</span> →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- LATAR BELAKANG SECTION -->
<section class="py-20 bg-[#f6f1e2]" id="latar-belakang">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="max-w-[56ch] mb-11">
            <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">Kenapa Komunitas Ini Berdiri</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <p class="text-[#2b2417] text-base leading-relaxed font-medium">
                    Kami adalah komunitas peduli lingkungan yang beraktivitas di Kabupaten Indramayu. Pendirian komunitas ini dilandasi oleh tiga hal utama:
                </p>

                <ul class="space-y-3.5 text-sm text-[#2b2417]">
                    <li class="flex items-start gap-3 bg-[#fbf8ef] p-3.5 rounded-xl border border-[#2b2417]/10">
                        <svg class="w-5 h-5 text-[#c1852c] shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span class="font-medium">Keprihatinan terhadap kualitas alam dan lingkungan akibat sampah.</span>
                    </li>
                    <li class="flex items-start gap-3 bg-[#fbf8ef] p-3.5 rounded-xl border border-[#2b2417]/10">
                        <svg class="w-5 h-5 text-[#c1852c] shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span class="font-medium">Kepedulian masyarakat yang masih rendah terhadap pemilahan sampah dari rumah.</span>
                    </li>
                    <li class="flex items-start gap-3 bg-[#fbf8ef] p-3.5 rounded-xl border border-[#2b2417]/10">
                        <svg class="w-5 h-5 text-[#c1852c] shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span class="font-medium">Mengubah pola pikir warga agar menjalani gaya hidup ramah lingkungan (*sustainable living*).</span>
                    </li>
                </ul>
            </div>

            <!-- Quote Card -->
            <div class="bg-[#2c3821] text-[#f6f1e2] p-8 sm:p-10 rounded-3xl relative shadow-xl border border-[#4c5c31]">
                <div class="text-[#93a869]/40 font-fraunces text-7xl leading-none absolute top-4 left-6 select-none">“</div>
                <p class="font-fraunces italic text-xl sm:text-2xl leading-relaxed relative z-10 pt-4 text-white">
                    Cara hidup ramah lingkungan yang dilakukan oleh banyak orang dengan cara sederhana, lebih baik daripada dilakukan oleh segelintir orang dengan cara yang sempurna.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- VISI MISI SECTION -->
<section class="py-20 bg-[#fbf8ef] border-y border-[#2b2417]/16" id="visi-misi">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="max-w-[56ch] mb-11">
            <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">Visi & Misi Kami</h2>
            <p class="text-[#5a5040] mt-3 text-base">Dua arah yang berjalan beriringan: kelestarian lingkungan dan pemberdayaan ekonomi warga.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($visi->concat($misi) as $vm)
                <div class="p-6 {{ $loop->even ? 'bg-[#f6f1e2]' : 'bg-white' }} rounded-2xl border border-[#2b2417]/16 shadow-2xs">
                    <div class="text-xs uppercase font-bold text-[#c1852c] tracking-wider mb-2">{{ $vm->label }}</div>
                    <h3 class="font-fraunces font-bold text-[#2c3821] text-lg mb-2">{{ $vm->judul }}</h3>
                    <p class="text-xs text-[#54493a] leading-relaxed">{{ $vm->deskripsi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- STRUKTUR ORGANISASI SECTION -->
<section class="py-20 bg-[#f6f1e2]" id="struktur">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="max-w-[62ch] mb-12">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#2c3821] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                <span>Pengurus & Tim Komunitas</span>
            </div>
            <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">Struktur Organisasi</h2>
            <p class="text-[#5a5040] mt-3 text-sm sm:text-base leading-relaxed">
                Pengurus dan tim penggerak komunitas Bumi Indramayu Lestari yang berdedikasi menjaga keberlanjutan dan mendampingi warga Indramayu.
            </p>
        </div>

        <!-- Jajaran Pengurus Utama Grid -->
        <div class="mb-14">
            <h3 class="text-xs uppercase font-bold text-[#c1852c] tracking-widest mb-6 flex items-center gap-2">
                <span>★ Pengurus Inti Komunitas</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($pengurusInti as $pengurus)
                @php
                    $initials = implode('', array_map(fn($w) => strtoupper($w[0] ?? ''), array_slice(explode(' ', $pengurus->nama), 0, 2)));
                    $isHighlight = $pengurus->badge === 'ochre';
                    $boxClass = $isHighlight ? 'bg-[#c1852c] text-white' : 'bg-[#dce6c8] text-[#2c3821]';
                    $badgeClass = $isHighlight ? 'bg-[#c1852c] text-white' : 'bg-[#2c3821] text-[#fbf8ef]';
                @endphp
                <div class="bg-[#fbf8ef] rounded-2xl p-5 border border-[#2b2417]/14 shadow-2xs hover:shadow-md transition-all group">
                    <div class="space-y-3">
                        <div class="w-12 h-12 rounded-2xl {{ $boxClass }} flex items-center justify-center font-bold font-fraunces text-lg">{{ $initials }}</div>
                        <div>
                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $badgeClass }} mb-1">{{ $pengurus->jabatan }}</span>
                            <h4 class="font-fraunces font-bold text-sm sm:text-base text-[#2c3821]">{{ $pengurus->nama }}</h4>
                            <p class="text-xs text-[#6b6150] mt-1">{{ $pengurus->deskripsi }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Divisi Tim Penggerak Grid -->
        <div>
            <h3 class="text-xs uppercase font-bold text-[#c1852c] tracking-widest mb-6 flex items-center gap-2">
                <span>✦ Divisi Tim Penggerak Lapangan</span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($pengurusDivisi as $divisi)
                <div class="bg-white p-6 rounded-2xl border border-[#2b2417]/14 shadow-2xs">
                    <h4 class="font-fraunces font-bold text-lg text-[#2c3821] mb-1.5">{{ $divisi->nama }}</h4>
                    <p class="text-xs text-[#6b6150] leading-relaxed mb-4">{{ $divisi->deskripsi }}</p>
                    @if($divisi->anggota)
                    <div class="text-[11px] font-semibold text-[#4c5c31] bg-[#dce6c8]/50 px-3 py-1.5 rounded-lg border border-[#c6d6ab]">{{ $divisi->anggota }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- PROGRAM KERJA UTAMA SECTION -->
<section class="py-20 bg-[#fbf8ef] border-y border-[#2b2417]/16" id="program-kerja">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-10 gap-6">
            <div class="max-w-[60ch]">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                    <span>Inisiatif & Aksi Nyata</span>
                </div>
                <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">Program Kerja Utama</h2>
                <p class="text-[#5a5040] mt-3 text-sm sm:text-base leading-relaxed">
                    Rangkaian program unggulan berkelanjutan yang mengintegrasikan edukasi, pemberdayaan ekonomi warga, dan aksi kepedulian lingkungan.
                </p>
            </div>

            <!-- Tabs buttons -->
            <div class="flex items-center gap-2 p-1.5 bg-[#f6f1e2] rounded-full border border-[#2b2417]/14 shrink-0 overflow-x-auto">
                <button type="button" onclick="switchTab('pendidikan')" id="tab-btn-pendidikan" class="tab-btn-custom px-4 py-2 rounded-full text-xs font-bold transition-all bg-[#2c3821] text-[#fbf8ef] shadow-xs">Pendidikan & Pelatihan</button>
                <button type="button" onclick="switchTab('ekonomi')" id="tab-btn-ekonomi" class="tab-btn-custom px-4 py-2 rounded-full text-xs font-bold transition-all text-[#5a5040] hover:text-[#2c3821]">Pemberdayaan Ekonomi</button>
                <button type="button" onclick="switchTab('humas')" id="tab-btn-humas" class="tab-btn-custom px-4 py-2 rounded-full text-xs font-bold transition-all text-[#5a5040] hover:text-[#2c3821]">Humas & Media</button>
            </div>
        </div>

        <!-- Tab 1: Pendidikan & Pelatihan -->
        <div id="tab-content-pendidikan" class="tab-content-custom block">
            <div class="flex flex-wrap gap-2.5">
                @foreach ($programPendidikan as $program)
                    <span class="px-4 py-2.5 rounded-full bg-white border border-[#2b2417]/14 text-xs font-semibold text-[#2c3821] shadow-2xs flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#c1852c]"></span>
                        {{ $program->nama }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Tab 2: Pemberdayaan Ekonomi -->
        <div id="tab-content-ekonomi" class="tab-content-custom hidden">
            <div class="flex flex-wrap gap-2.5">
                @foreach ($programEkonomi as $program)
                    <span class="px-4 py-2.5 rounded-full bg-white border border-[#2b2417]/14 text-xs font-semibold text-[#2c3821] shadow-2xs flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#4c5c31]"></span>
                        {{ $program->nama }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Tab 3: Humas & Media -->
        <div id="tab-content-humas" class="tab-content-custom hidden">
            <div class="flex flex-wrap gap-2.5">
                @foreach ($programHumas as $program)
                    <span class="px-4 py-2.5 rounded-full bg-white border border-[#2b2417]/14 text-xs font-semibold text-[#2c3821] shadow-2xs flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#c1852c]"></span>
                        {{ $program->nama }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- BINAAN SECTION -->
<section class="py-20 bg-[#f6f1e2]" id="binaan">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="max-w-[62ch] mb-12">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#2c3821] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                <span>Mitra Binaan Komunitas</span>
            </div>
            <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl leading-[1.08]">Daftar Binaan</h2>
            <p class="text-[#5a5040] mt-3 text-sm sm:text-base leading-relaxed">
                Kelompok binaan yang didampingi oleh Bumi Indramayu Lestari dalam pengelolaan sampah dan pemberdayaan ekonomi warga.
            </p>
        </div>

        @if ($binaans->isEmpty())
            <div class="p-8 text-center text-sm text-[#6b6150] bg-white rounded-2xl border border-[#2b2417]/14">
                Belum ada data binaan dalam database.
            </div>
        @else
            <div class="space-y-6">
                @foreach ($binaans as $binaan)
                    <div class="bg-white rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-md transition-all">
                        <!-- Binaan Header -->
                        <div class="p-6 sm:p-8 border-b border-[#2b2417]/10">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-[#dce6c8] text-[#2c3821] flex items-center justify-center font-bold font-fraunces text-xl shrink-0">
                                        {{ strtoupper(substr($binaan->nama, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-fraunces font-bold text-lg sm:text-xl text-[#2c3821]">{{ $binaan->nama }}</h3>
                                        <div class="flex flex-wrap items-center gap-3 mt-1.5 text-xs text-[#6b6150]">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-[#c1852c]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                                {{ $binaan->alamat }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-[#c1852c]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                                Berdiri sejak {{ $binaan->berdiri_sejak->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if ($binaan->kontak->isNotEmpty())
                                    @php
                                        $kontakUtama = $binaan->kontak->first();
                                        $phoneNum = preg_replace('/[^0-9]/', '', $kontakUtama->whatsapp);
                                    @endphp
                                    <a href="https://wa.me/{{ $phoneNum }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-xs font-semibold transition-colors shadow-2xs shrink-0">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        Hubungi via WA
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Pengurusan & Kontak Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-[#2b2417]/10">
                            <!-- Struktur Pengurusan -->
                            <div class="p-6">
                                <h4 class="text-xs uppercase font-bold text-[#c1852c] tracking-widest mb-4 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    <span>Struktur Pengurusan</span>
                                </h4>
                                @if ($binaan->pengurusan->isEmpty())
                                    <p class="text-xs text-[#6b6150]">Belum ada data pengurusan.</p>
                                @else
                                    <div class="space-y-2.5">
                                        @foreach ($binaan->pengurusan as $pengurus)
                                            <div class="flex items-center gap-3 p-2.5 bg-[#f6f1e2] rounded-xl">
                                                @php
                                                    $initials = implode('', array_map(fn($w) => strtoupper($w[0] ?? ''), array_slice(explode(' ', $pengurus->nama), 0, 2)));
                                                @endphp
                                                <div class="w-9 h-9 rounded-full bg-[#2c3821] text-[#fbf8ef] flex items-center justify-center text-xs font-bold font-fraunces shrink-0">{{ $initials }}</div>
                                                <div class="min-w-0">
                                                    <h5 class="font-bold text-sm text-[#2c3821] truncate">{{ $pengurus->nama }}</h5>
                                                    <span class="text-[10px] font-semibold text-[#c1852c] uppercase tracking-wider">{{ $pengurus->jabatan }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Kontak Binaan -->
                            <div class="p-6">
                                <h4 class="text-xs uppercase font-bold text-[#c1852c] tracking-widest mb-4 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>Kontak Person</span>
                                </h4>
                                @if ($binaan->kontak->isEmpty())
                                    <p class="text-xs text-[#6b6150]">Belum ada data kontak.</p>
                                @else
                                    <div class="space-y-2.5">
                                        @foreach ($binaan->kontak as $k)
                                            @php
                                                $phone = preg_replace('/[^0-9]/', '', $k->whatsapp);
                                            @endphp
                                            <div class="flex items-center justify-between p-2.5 bg-[#f6f1e2] rounded-xl">
                                                <div class="min-w-0">
                                                    <h5 class="font-bold text-sm text-[#2c3821] truncate">{{ $k->nama }}</h5>
                                                    <span class="text-[11px] text-[#6b6150]">{{ $k->whatsapp }}</span>
                                                </div>
                                                <a href="https://wa.me/{{ $phone }}" target="_blank" class="shrink-0 p-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full transition-colors" title="Hubungi via WhatsApp">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- GALERI KEGIATAN WARGA (DYNAMIC FROM DB) -->
<section class="py-20 bg-[#f6f1e2]" id="galeri">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-2">
                    <span>Dokumentasi Terkini</span>
                </div>
                <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl">Galeri Kegiatan Warga</h2>
                <p class="text-[#5a5040] text-sm mt-1">Dokumentasi asli penimbangan bank sampah, edukasi, dan aksi lingkungan bersama warga Indramayu.</p>
            </div>

            <a href="{{ route('galeri') }}" class="px-5 py-2.5 bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] rounded-full text-xs font-bold flex items-center gap-2 transition-colors shadow-2xs shrink-0">
                <span>Lihat Semua Galeri</span> →
            </a>
        </div>

        @if ($galleries->isEmpty())
            <div class="p-8 text-center text-sm text-[#6b6150] bg-white rounded-2xl border border-[#2b2417]/14">
                Belum ada dokumentasi kegiatan dalam database.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($galleries as $g)
                    <div class="group bg-white rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-slate-100">
                                <img src="{{ $g->primary_image_url }}" alt="{{ $g->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                @if ($g->category)
                                    <span class="absolute top-3 left-3 bg-[#2c3821]/90 text-[#fbf8ef] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-xs">
                                        {{ $g->category->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="p-5 space-y-2">
                                <a href="{{ route('galeri.show', $g->slug) }}">
                                    <h3 class="font-fraunces font-bold text-base text-[#2c3821] group-hover:text-[#c1852c] transition-colors line-clamp-2">{{ $g->title }}</h3>
                                </a>
                                @if ($g->description)
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">{{ $g->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                            <div class="flex items-center gap-1 font-medium">
                                <span class="text-[#c1852c]">📍</span>
                                <span class="truncate max-w-[180px]">{{ $g->location ?: 'Indramayu' }}</span>
                            </div>
                            <span class="text-[11px] text-slate-400 font-semibold">{{ \Carbon\Carbon::parse($g->event_date)->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- KATALOG PRODUK OLAHAN (DYNAMIC FROM DB) -->
<section class="py-20 bg-[#fbf8ef] border-y border-[#2b2417]/16" id="katalog">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-2">
                    <span>Ekonomi Sirkular</span>
                </div>
                <h2 class="font-fraunces font-bold text-[#2c3821] text-3xl sm:text-4xl">Katalog Produk Olahan</h2>
                <p class="text-[#5a5040] text-sm mt-1">Produk ramah lingkungan hasil olahan minyak jelantah, sampah anorganik, dan kain perca.</p>
            </div>

            <a href="{{ route('katalog') }}" class="px-5 py-2.5 bg-[#c1852c] hover:bg-[#a67022] text-[#fbf8ef] rounded-full text-xs font-bold flex items-center gap-2 transition-colors shadow-2xs shrink-0">
                <span>Buka Katalog Lengkap</span> →
            </a>
        </div>

        @if ($products->isEmpty())
            <div class="p-8 text-center text-sm text-[#6b6150] bg-white rounded-2xl border border-[#2b2417]/14">
                Belum ada produk dalam database.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $p)
                    <div class="bg-white rounded-2xl border border-[#2b2417]/16 overflow-hidden shadow-2xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-slate-100">
                                <img src="{{ $p->image_url ?: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $p->title }}" loading="lazy" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
                                @if ($p->category)
                                    <span class="absolute top-3 left-3 bg-[#c1852c] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                        {{ $p->category->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="p-5 space-y-2">
                                <a href="{{ route('katalog.show', $p->slug) }}">
                                    <h3 class="font-fraunces font-bold text-base text-[#2c3821] hover:text-[#c1852c] transition-colors line-clamp-2">{{ $p->title }}</h3>
                                </a>
                                @if ($p->description)
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $p->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Harga</span>
                                <span class="font-bold text-sm text-[#c1852c]">{{ $p->price_text ?: 'Hubungi kami' }}</span>
                            </div>

                            @php
                                $phone = preg_replace('/[^0-9]/', '', $p->contact->phone ?? '628112442322');
                                $waUrl = "https://wa.me/{$phone}?text=" . urlencode("Halo " . ($p->contact->name ?? 'Admin BIL') . ", saya tertarik untuk memesan produk {$p->title}. Apakah stok masih tersedia?");
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs">
                                💬 <span>Pesan via WA</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- KONTAK & SEKRETARIAT SECTION (DYNAMIC FROM DB) -->
<section class="py-20 bg-[#f6f1e2]" id="kontak">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 border border-[#2b2417]/16 rounded-3xl overflow-hidden shadow-xl bg-white">
            
            <!-- Left Info Column -->
            <div class="lg:col-span-5 p-8 sm:p-10 bg-[#2c3821] text-[#f6f1e2] flex flex-col justify-between space-y-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c1852c] text-[#fbf8ef] text-xs font-bold uppercase tracking-wider mb-3">
                        <span>Kontak Sekretariat</span>
                    </div>
                    <h2 class="font-fraunces font-bold text-white text-3xl sm:text-4xl leading-tight">Mari Terhubung</h2>
                    <p class="mt-2 text-[#f6f1e2]/85 text-xs sm:text-sm leading-relaxed">
                        Terbuka untuk kolaborasi edukasi lingkungan, sedekah sampah, maupun pemesanan produk olahan minyak jelantah.
                    </p>
                </div>

                <div class="space-y-4 text-xs sm:text-sm">
                    <div class="flex items-start gap-3">
                        <span class="text-[#c1852c] text-base">📍</span>
                        <div>
                            <span class="block text-[#93a869] text-[11px] font-bold uppercase tracking-wider">Alamat Kantor</span>
                            <span>Ruko Komplek Masjid Abdurrahman Basuri, Jl. MT Haryono, Sindang – Indramayu</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-emerald-400 text-base">📞</span>
                        <div>
                            <span class="block text-[#93a869] text-[11px] font-bold uppercase tracking-wider">Telepon / WhatsApp Layanan</span>
                            <span class="font-bold text-white">0811-2442-322</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Dynamic Contacts List from DB -->
            <div class="lg:col-span-7 p-6 sm:p-8 bg-[#fbf8ef] space-y-4">
                <h3 class="font-fraunces font-bold text-lg text-[#2c3821] mb-2">Daftar Penanggung Jawab (PIC) Layanan</h3>

                @if ($contacts->isEmpty())
                    <p class="text-xs text-slate-500">Belum ada data PIC kontak di database.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        @foreach ($contacts as $c)
                            <div class="p-4 bg-white rounded-xl border border-[#2b2417]/16 shadow-2xs flex flex-col justify-between space-y-3">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#c1852c] block mb-0.5">{{ $c->role ?: 'Pengelola BIL' }}</span>
                                    <h4 class="font-fraunces font-bold text-sm text-[#2c3821]">{{ $c->name }}</h4>
                                </div>

                                @php
                                    $phoneNum = preg_replace('/[^0-9]/', '', $c->phone);
                                @endphp
                                <a href="https://wa.me/{{ $phoneNum }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:underline">
                                    💬 <span>Hubungi +{{ $c->phone }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function switchTab(tabKey) {
    document.querySelectorAll('.tab-content-custom').forEach(el => {
        el.classList.add('hidden');
        el.classList.remove('block');
    });
    document.querySelectorAll('.tab-btn-custom').forEach(btn => {
        btn.classList.remove('bg-[#2c3821]', 'text-[#fbf8ef]', 'shadow-xs');
        btn.classList.add('text-[#5a5040]');
    });

    const targetContent = document.getElementById('tab-content-' + tabKey);
    const targetBtn = document.getElementById('tab-btn-' + tabKey);

    if (targetContent) {
        targetContent.classList.remove('hidden');
        targetContent.classList.add('block');
    }
    if (targetBtn) {
        targetBtn.classList.add('bg-[#2c3821]', 'text-[#fbf8ef]', 'shadow-xs');
        targetBtn.classList.remove('text-[#5a5040]');
    }
}
</script>
@endpush
