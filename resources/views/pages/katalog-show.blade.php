@extends('layouts.public')

@section('title', $product->title . ' — Katalog Produk')

@section('content')
<div class="bg-[#f6f1e2] py-10 sm:py-14">
    <div class="max-w-[1180px] mx-auto px-6 sm:px-8">
        
        <!-- Back Navigation Button -->
        <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#2c3821] hover:text-[#c1852c] transition-colors mb-8 bg-white px-4 py-2 rounded-full border border-[#2b2417]/14 shadow-2xs">
            ← Kembali ke Katalog Produk
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Product Image Column -->
            <div class="lg:col-span-6 space-y-4">
                <div class="rounded-3xl overflow-hidden border border-[#2b2417]/16 bg-white shadow-lg aspect-[4/3]">
                    <img id="mainProductImage" 
                         src="{{ $product->image_url ?: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop' }}" 
                         alt="{{ $product->title }}" 
                         class="w-full h-full object-cover transition-all duration-300" />
                </div>

                @if ($product->images->count() > 1)
                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                        @foreach ($product->images as $idx => $img)
                            <button type="button" 
                                    onclick="changeProductImage('{{ $img->image_url }}', this)" 
                                    class="product-thumb-btn rounded-xl overflow-hidden border-2 border-transparent hover:border-[#c1852c] focus:border-[#c1852c] aspect-square transition-all focus:outline-none bg-white p-0.5 cursor-pointer shadow-2xs {{ $idx === 0 ? 'border-[#c1852c]' : '' }}">
                                <img src="{{ $img->image_url }}" alt="Foto Produk" class="w-full h-full object-cover rounded-lg" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Details & Order Column -->
            <div class="lg:col-span-6 space-y-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#2b2417]/16 shadow-lg space-y-5">
                    
                    <div class="flex items-center justify-between gap-2">
                        @if($product->category)
                            <span class="inline-block px-3 py-1 rounded-full bg-[#c1852c] text-white text-[10px] font-bold uppercase tracking-wider">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $product->stock > 0 ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-rose-100 text-rose-800 border border-rose-300' }}">
                            {{ $product->stock > 0 ? 'Stok: ' . $product->stock . ' unit' : 'Stok Habis' }}
                        </span>
                    </div>

                    <h1 class="font-fraunces font-bold text-2xl sm:text-3xl text-[#2c3821] leading-tight">
                        {{ $product->title }}
                    </h1>

                    <div class="p-4 rounded-2xl bg-[#f6f1e2] border border-[#2b2417]/12 flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] text-slate-500 font-bold uppercase tracking-wider">Harga / Patungan Donasi</span>
                            <span class="text-xl sm:text-2xl font-bold text-[#c1852c]">{{ $product->price_text ?: 'Hubungi kami' }}</span>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="pt-2 space-y-2">
                            <span class="block text-xs font-bold uppercase tracking-wider text-[#2c3821]">Deskripsi & Keunggulan Produk</span>
                            <p class="text-xs sm:text-sm text-[#4a4234] leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>
                    @endif

                    <!-- PIC & Order Button -->
                    @php
                        $contactPhone = preg_replace('/[^0-9]/', '', $product->contact->phone ?? '628112442322');
                        $contactName = $product->contact->name ?? 'Admin BIL';
                        $waLink = "https://wa.me/{$contactPhone}?text=" . urlencode("Halo {$contactName}, saya ingin memesan produk {$product->title}. Apakah stok masih tersedia?");
                    @endphp

                    <div class="pt-4 border-t border-[#2b2417]/10 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#dce6c8] text-[#2c3821] flex items-center justify-center font-bold text-sm shrink-0">👤</div>
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Penanggung Jawab (PIC)</span>
                                <span class="font-bold text-xs sm:text-sm text-[#2c3821]">{{ $contactName }}</span>
                            </div>
                        </div>

                        <a href="{{ $waLink }}" target="_blank" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-full transition-all shadow-md hover:shadow-lg">
                            💬 <span>Pesan via WhatsApp Langsung</span>
                        </a>
                    </div>

                </div>

                <!-- Related Products Section -->
                @if ($related->isNotEmpty())
                    <div class="bg-[#fbf8ef] rounded-3xl p-6 border border-[#2b2417]/14 space-y-4">
                        <h3 class="font-fraunces font-bold text-base text-[#2c3821]">Produk Olahan Terkait</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($related as $rel)
                                <a href="{{ route('katalog.show', $rel->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-[#2b2417]/12 hover:shadow-md transition-all flex flex-col justify-between p-2.5">
                                    <div class="aspect-square overflow-hidden rounded-xl bg-slate-100">
                                        <img src="{{ $rel->image_url ?: 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                                    </div>
                                    <div class="pt-2">
                                        <h4 class="text-xs font-bold text-[#2c3821] group-hover:text-[#c1852c] transition-colors truncate">{{ $rel->title }}</h4>
                                        <span class="text-[11px] font-semibold text-[#c1852c] block mt-0.5">{{ $rel->price_text }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function changeProductImage(imgUrl, clickedBtn) {
    const mainImg = document.getElementById('mainProductImage');
    if (mainImg) {
        mainImg.src = imgUrl;
    }
    document.querySelectorAll('.product-thumb-btn').forEach(btn => {
        btn.classList.remove('border-[#c1852c]');
        btn.classList.add('border-transparent');
    });
    if (clickedBtn) {
        clickedBtn.classList.remove('border-transparent');
        clickedBtn.classList.add('border-[#c1852c]');
    }
}
</script>
@endpush
