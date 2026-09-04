@extends('layouts.admin')

@section('title', 'Edit Galeri — Admin')

@section('page-heading', 'Edit Galeri Kegiatan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Top Action Bar (Back Button only) -->
    <div class="flex items-center justify-between border-b border-[#2b2417]/10 pb-4">
        <p class="text-xs text-[#6b6150]">Perbarui informasi kegiatan, lokasi, tanggal, dan galeri media.</p>
        <a href="{{ route('admin.galeri') }}" class="px-4 py-2 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors shrink-0">
            ← Kembali ke Galeri
        </a>
    </div>

    @if ($errors->any())
        <div class="px-4 py-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-800 flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.galeri.update', $gallery->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="set_primary_image_id" id="set_primary_image_id" value="" />
        <input type="hidden" name="primary_upload_index" id="primary_upload_index" value="-1" />
        <div id="removedImagesInputs"></div>

        <!-- 2-COLUMN LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT COLUMN: Main Form & Media Gallery (lg:col-span-8) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Main Form Card -->
                <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-5">
                    <h3 class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3">Informasi Utama Kegiatan</h3>

                    <!-- Judul Kegiatan -->
                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Judul Kegiatan <span class="text-rose-600">*</span></label>
                        <input type="text" 
                               name="title" 
                               value="{{ old('title', $gallery->title) }}" 
                               required 
                               placeholder="misal: Program Penimbangan & Sedekah Sampah Bulanan"
                               class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kategori -->
                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Kategori Kegiatan <span class="text-rose-600">*</span></label>
                            <select name="category_id" required class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $gallery->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Kegiatan -->
                        <div class="grid gap-1.5">
                            <label class="text-xs font-bold text-[#2c3821]">Tanggal Kegiatan <span class="text-rose-600">*</span></label>
                            <input type="date" 
                                   name="event_date" 
                                   value="{{ old('event_date', $gallery->event_date ? \Carbon\Carbon::parse($gallery->event_date)->format('Y-m-d') : '') }}" 
                                   required 
                                   class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Deskripsi Rincian Kegiatan</label>
                        <textarea name="description" 
                                  rows="4" 
                                  placeholder="Tuliskan cerita singkat atau dokumentasi jalannya kegiatan..."
                                  class="w-full px-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs">{{ old('description', $gallery->description) }}</textarea>
                    </div>
                </div>

                <!-- GALERI MEDIA COMPONENT CARD -->
                <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <div class="w-36 shrink-0 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0 font-bold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">GALERI MEDIA</span>
                        </div>

                        <!-- Thumbnails Flex Row -->
                        <div class="flex-1 flex items-center gap-3 overflow-x-auto py-2 scrollbar-none" id="mediaThumbnailsRow">
                            @foreach ($gallery->images as $image)
                                <div class="relative group w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border-2 {{ $image->is_primary ? 'border-emerald-500' : 'border-slate-200 hover:border-slate-300' }} overflow-hidden bg-white shrink-0 p-0.5 transition-all shadow-2xs media-card-item" 
                                     id="gallery-img-card-{{ $image->id }}">
                                    
                                    @if($image->is_primary)
                                        <div class="absolute top-1.5 left-1.5 z-10 bg-[#059669] text-white text-[9px] font-extrabold px-2 py-0.5 rounded-md flex items-center gap-1 shadow-xs primary-badge">
                                            <svg class="w-3 h-3 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            <span>UTAMA</span>
                                        </div>
                                    @endif

                                    <img src="{{ $image->image_url }}" alt="Media" class="w-full h-full object-contain rounded-xl bg-slate-50" />

                                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-2xs opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2 z-20">
                                        <!-- Star Button: Set Primary -->
                                        <button type="button" 
                                                onclick="setPrimaryImage({{ $image->id }})" 
                                                title="Jadikan Foto Utama"
                                                class="w-8 h-8 rounded-lg bg-white border border-emerald-500 text-emerald-600 flex items-center justify-center hover:bg-emerald-50 shadow-sm cursor-pointer transition-transform hover:scale-105">
                                            <svg class="w-4 h-4 fill-emerald-500/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                            </svg>
                                        </button>

                                        <!-- Red Delete Button -->
                                        <button type="button" 
                                                onclick="removeExistingImage({{ $image->id }})" 
                                                title="Hapus Foto"
                                                class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center hover:bg-rose-600 shadow-sm cursor-pointer transition-transform hover:scale-105">
                                            <svg class="w-4 h-4 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <line x1="18" y1="6" x2="6" y2="18"/>
                                                <line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <div id="newUploadsPreviewRow" class="flex items-center gap-3"></div>

                            <!-- Plus Upload Box -->
                            <div class="relative w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-500 bg-slate-50/60 hover:bg-emerald-50/30 flex items-center justify-center text-slate-400 hover:text-emerald-600 transition-all cursor-pointer shrink-0 group">
                                <input type="file" 
                                       name="photos[]" 
                                       multiple 
                                       accept="image/*" 
                                       onchange="handleNewPhotosSelected(event)"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" />
                                
                                <svg class="w-8 h-8 text-slate-300 group-hover:text-emerald-600 transition-colors stroke-[1.5]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="6" y1="12" x2="18" y2="12"/>
                                </svg>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Side Settings & Actions (lg:col-span-4) -->
            <div class="lg:col-span-4 space-y-6">

                <div class="bg-[#fbf8ef] rounded-3xl border border-[#2b2417]/16 p-6 shadow-sm space-y-5">
                    <h3 class="font-fraunces font-bold text-lg text-[#2c3821] border-b border-[#2b2417]/10 pb-3">Pengaturan & Lokasi</h3>

                    <!-- Status Tampilan (Toggle Switch) -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#2c3821] block">Status Tampilan</label>
                        
                        <div class="flex items-center justify-between p-3.5 bg-white rounded-2xl border border-[#2b2417]/14 shadow-2xs">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-[#2c3821] block">Publikasikan</span>
                                <span class="text-[10px] text-[#6b6150] block">Tampilkan di website</span>
                            </div>

                            <!-- Modern Toggle Switch -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_published" 
                                       value="1" 
                                       id="is_published_toggle" 
                                       {{ $gallery->is_published ? 'checked' : '' }} 
                                       class="sr-only peer" />
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#059669]"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Lokasi Kegiatan -->
                    <div class="grid gap-1.5">
                        <label class="text-xs font-bold text-[#2c3821]">Lokasi Kegiatan <span class="text-rose-600">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   name="location" 
                                   value="{{ old('location', $gallery->location) }}" 
                                   required 
                                   placeholder="misal: Pamijahan Plumbon"
                                   class="w-full pl-9 pr-4 py-3 bg-white border border-[#2b2417]/16 rounded-2xl text-xs sm:text-sm font-semibold text-[#2c3821] focus:outline-none focus:ring-2 focus:ring-[#c1852c] focus:border-[#c1852c] transition-all shadow-2xs" />
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#c1852c]">📍</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 border-t border-[#2b2417]/10 space-y-2.5">
                        <button type="submit" class="w-full py-3.5 px-5 rounded-full bg-[#2c3821] hover:bg-[#4c5c31] text-[#fbf8ef] text-xs font-bold transition-all shadow-md cursor-pointer flex items-center justify-center gap-2">
                            <span>💾</span>
                            <span>Simpan Perubahan</span>
                        </button>
                        <a href="{{ route('admin.galeri') }}" class="w-full py-3 px-5 rounded-full border border-[#2b2417]/16 text-xs font-bold text-[#2b2417] hover:bg-[#f6f1e2] transition-colors text-center block">
                            Batal
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </form>
</div>

<script>
// Reset all UTAMA badges & borders
function clearAllPrimaryBadges() {
    document.querySelectorAll('.media-card-item').forEach(card => {
        card.classList.remove('border-2', 'border-emerald-500');
        card.classList.add('border', 'border-slate-200');
        const badge = card.querySelector('.primary-badge');
        if (badge) badge.remove();
    });
}

// Set Existing Image as UTAMA (Primary)
function setPrimaryImage(imageId) {
    document.getElementById('set_primary_image_id').value = imageId;
    document.getElementById('primary_upload_index').value = -1;

    clearAllPrimaryBadges();

    const targetCard = document.getElementById('gallery-img-card-' + imageId);
    if (targetCard) {
        targetCard.classList.remove('border', 'border-slate-200');
        targetCard.classList.add('border-2', 'border-emerald-500');

        const newBadge = document.createElement('div');
        newBadge.className = 'absolute top-1.5 left-1.5 z-10 bg-[#059669] text-white text-[9px] font-extrabold px-2 py-0.5 rounded-md flex items-center gap-1 shadow-xs primary-badge';
        newBadge.innerHTML = `
            <svg class="w-3 h-3 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>UTAMA</span>
        `;
        targetCard.appendChild(newBadge);
    }
}

// Set Newly Uploaded Photo as UTAMA
function setNewUploadPrimary(uploadIndex) {
    document.getElementById('primary_upload_index').value = uploadIndex;
    document.getElementById('set_primary_image_id').value = '';

    clearAllPrimaryBadges();

    const targetCard = document.getElementById('new-preview-card-' + uploadIndex);
    if (targetCard) {
        targetCard.classList.remove('border', 'border-slate-200');
        targetCard.classList.add('border-2', 'border-emerald-500');

        const newBadge = document.createElement('div');
        newBadge.className = 'absolute top-1.5 left-1.5 z-10 bg-[#059669] text-white text-[9px] font-extrabold px-2 py-0.5 rounded-md flex items-center gap-1 shadow-xs primary-badge';
        newBadge.innerHTML = `
            <svg class="w-3 h-3 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>UTAMA</span>
        `;
        targetCard.appendChild(newBadge);
    }
}

// Remove Existing Image
function removeExistingImage(imageId) {
    const card = document.getElementById('gallery-img-card-' + imageId);
    const inputsContainer = document.getElementById('removedImagesInputs');
    
    if (card) {
        card.remove();
    }

    if (inputsContainer) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_images[]';
        input.value = imageId;
        inputsContainer.appendChild(input);
    }
}

// Handle Preview for Newly Added Photos via (+) Button with Both UTAMA & Delete Action Buttons
function handleNewPhotosSelected(event) {
    const previewRow = document.getElementById('newUploadsPreviewRow');
    const files = Array.from(event.target.files);

    if (files.length === 0) return;

    files.forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const card = document.createElement('div');
            card.className = 'relative group w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border border-slate-200 hover:border-slate-300 overflow-hidden bg-white shrink-0 p-0.5 transition-all shadow-2xs media-card-item';
            card.id = 'new-preview-card-' + index;

            card.innerHTML = `
                <div class="absolute top-1.5 left-1.5 z-10 bg-slate-900/80 backdrop-blur-2xs text-white text-[9px] font-extrabold px-2 py-0.5 rounded-md shadow-xs primary-badge">
                    BARU
                </div>
                <img src="${e.target.result}" alt="Media Baru" class="w-full h-full object-contain rounded-xl bg-slate-50" />
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-2xs opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-2 z-20">
                    <!-- Star Button: Set as UTAMA -->
                    <button type="button" 
                            onclick="setNewUploadPrimary(${index})" 
                            title="Jadikan Foto Utama"
                            class="w-8 h-8 rounded-lg bg-white border border-emerald-500 text-emerald-600 flex items-center justify-center hover:bg-emerald-50 shadow-sm cursor-pointer transition-transform hover:scale-105">
                        <svg class="w-4 h-4 fill-emerald-500/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </button>
                    <!-- Red Delete Button -->
                    <button type="button" 
                            onclick="this.closest('.relative').remove()" 
                            title="Batal Foto Ini"
                            class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center hover:bg-rose-600 shadow-sm cursor-pointer transition-transform hover:scale-105">
                        <svg class="w-4 h-4 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                </div>
            `;

            previewRow.appendChild(card);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
