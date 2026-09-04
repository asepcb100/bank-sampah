<?php

use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing', [
        'galleries' => Gallery::with(['category', 'images'])->where('is_published', true)->latest()->take(6)->get(),
        'products' => Product::with(['category', 'contact', 'images'])->where('is_available', true)->latest()->take(6)->get(),
        'contacts' => Contact::where('is_active', true)->get(),
        'visi' => \App\Models\VisiMisi::visi()->orderBy('sort_order')->get(),
        'misi' => \App\Models\VisiMisi::misi()->orderBy('sort_order')->get(),
        'pengurusInti' => \App\Models\StrukturOrganisasi::inti()->orderBy('sort_order')->get(),
        'pengurusDivisi' => \App\Models\StrukturOrganisasi::divisi()->orderBy('sort_order')->get(),
        'programPendidikan' => \App\Models\ProgramKerja::kategori('pendidikan')->orderBy('sort_order')->get(),
        'programEkonomi' => \App\Models\ProgramKerja::kategori('ekonomi')->orderBy('sort_order')->get(),
        'programHumas' => \App\Models\ProgramKerja::kategori('humas')->orderBy('sort_order')->get(),
        'binaans' => \App\Models\Binaan::with(['pengurusan', 'kontak'])->orderBy('nama')->get(),
    ]);
})->name('home');

Route::get('/galeri', function (\Illuminate\Http\Request $request) {
    $galleries = Gallery::with(['category', 'images'])
        ->where('is_published', true);

    if ($kategori = $request->query('kategori')) {
        $galleries->whereHas('category', fn ($q) => $q->where('slug', $kategori));
    }

    return view('pages.galeri', [
        'galleries' => $galleries->latest()->get(),
        'categories' => Category::where('type', 'galeri')->orWhere('type', 'semua')->get(),
    ]);
})->name('galeri');

Route::get('/galeri/{slug}', function ($slug) {
    $gallery = Gallery::with(['category', 'images'])
        ->where('is_published', true)
        ->where(function ($q) use ($slug) {
            $q->where('slug', $slug)->orWhere('id', $slug);
        })
        ->firstOrFail();

    $related = Gallery::with(['category', 'images'])
        ->where('is_published', true)
        ->where('id', '!=', $gallery->id)
        ->latest()
        ->take(3)
        ->get();

    return view('pages.galeri-show', [
        'gallery' => $gallery,
        'related' => $related,
    ]);
})->name('galeri.show');

Route::get('/katalog', function (\Illuminate\Http\Request $request) {
    $products = Product::with(['category', 'contact', 'images'])
        ->where('is_available', true);

    if ($kategori = $request->query('kategori')) {
        $products->whereHas('category', fn ($q) => $q->where('slug', $kategori));
    }

    return view('pages.katalog', [
        'products' => $products->latest()->get(),
        'categories' => Category::where('type', 'katalog')->orWhere('type', 'semua')->get(),
    ]);
})->name('katalog');

Route::get('/katalog/{slug}', function ($slug) {
    $product = Product::with(['category', 'contact', 'images'])
        ->where('is_available', true)
        ->where(function ($q) use ($slug) {
            $q->where('slug', $slug)->orWhere('id', $slug);
        })
        ->firstOrFail();

    $related = Product::with(['category', 'contact', 'images'])
        ->where('is_available', true)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(3)
        ->get();

    return view('pages.katalog-show', [
        'product' => $product,
        'related' => $related,
    ]);
})->name('katalog.show');

Route::get('/produk', fn () => redirect()->route('katalog'));

/*
|--------------------------------------------------------------------------
| Admin Management Routes (Protected Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'stats' => [
                'total_galleries' => Gallery::count(),
                'total_products' => Product::count(),
                'total_contacts' => Contact::count(),
                'unread_messages' => Message::where('status', 'unread')->count(),
            ],
            'recent_galleries' => Gallery::with('category')->latest()->take(3)->get(),
            'recent_products' => Product::with(['category', 'contact'])->latest()->take(3)->get(),
            'recent_messages' => Message::latest()->take(3)->get(),
        ]);
    })->name('dashboard');

    // Admin Kelola Galeri
    Route::get('/admin/galeri', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('admin.galeri');
    Route::get('/admin/galeri/create', [\App\Http\Controllers\Admin\GalleryController::class, 'create'])->name('admin.galeri.create');
    Route::post('/admin/galeri', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('admin.galeri.store');
    Route::get('/admin/galeri/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('admin.galeri.show');
    Route::get('/admin/galeri/{id}/edit', [\App\Http\Controllers\Admin\GalleryController::class, 'edit'])->name('admin.galeri.edit');
    Route::put('/admin/galeri/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('admin.galeri.update');
    Route::delete('/admin/galeri/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('admin.galeri.destroy');

    // Admin Kelola Katalog
    Route::get('/admin/katalog', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.katalog');
    Route::get('/admin/katalog/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.katalog.create');
    Route::post('/admin/katalog', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.katalog.store');
    Route::get('/admin/katalog/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])->name('admin.katalog.show');
    Route::get('/admin/katalog/{id}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.katalog.edit');
    Route::put('/admin/katalog/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.katalog.update');
    Route::delete('/admin/katalog/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.katalog.destroy');

    // Admin Kelola Kontak & Pesan Warga
    Route::get('/admin/kontak', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.kontak');
    Route::get('/admin/kontak/create', [\App\Http\Controllers\Admin\ContactController::class, 'create'])->name('admin.kontak.create');
    Route::post('/admin/kontak', [\App\Http\Controllers\Admin\ContactController::class, 'store'])->name('admin.kontak.store');
    Route::get('/admin/kontak/{id}/edit', [\App\Http\Controllers\Admin\ContactController::class, 'edit'])->name('admin.kontak.edit');
    Route::put('/admin/kontak/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'update'])->name('admin.kontak.update');
    Route::delete('/admin/kontak/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('admin.kontak.destroy');

    // Admin Kelola Binaan
    Route::get('/admin/binaan', [\App\Http\Controllers\Admin\BinaanController::class, 'index'])->name('admin.binaan');
    Route::get('/admin/binaan/create', [\App\Http\Controllers\Admin\BinaanController::class, 'create'])->name('admin.binaan.create');
    Route::post('/admin/binaan', [\App\Http\Controllers\Admin\BinaanController::class, 'store'])->name('admin.binaan.store');
    Route::get('/admin/binaan/{id}', [\App\Http\Controllers\Admin\BinaanController::class, 'show'])->name('admin.binaan.show');
    Route::get('/admin/binaan/{id}/edit', [\App\Http\Controllers\Admin\BinaanController::class, 'edit'])->name('admin.binaan.edit');
    Route::put('/admin/binaan/{id}', [\App\Http\Controllers\Admin\BinaanController::class, 'update'])->name('admin.binaan.update');
    Route::delete('/admin/binaan/{id}', [\App\Http\Controllers\Admin\BinaanController::class, 'destroy'])->name('admin.binaan.destroy');

    // Admin Kelola Visi & Misi (Landing)
    Route::get('/admin/visi-misi', [\App\Http\Controllers\Admin\VisiMisiController::class, 'index'])->name('admin.visi-misi');
    Route::get('/admin/visi-misi/create', [\App\Http\Controllers\Admin\VisiMisiController::class, 'create'])->name('admin.visi-misi.create');
    Route::post('/admin/visi-misi', [\App\Http\Controllers\Admin\VisiMisiController::class, 'store'])->name('admin.visi-misi.store');
    Route::get('/admin/visi-misi/{id}', [\App\Http\Controllers\Admin\VisiMisiController::class, 'show'])->name('admin.visi-misi.show');
    Route::get('/admin/visi-misi/{id}/edit', [\App\Http\Controllers\Admin\VisiMisiController::class, 'edit'])->name('admin.visi-misi.edit');
    Route::put('/admin/visi-misi/{id}', [\App\Http\Controllers\Admin\VisiMisiController::class, 'update'])->name('admin.visi-misi.update');
    Route::delete('/admin/visi-misi/{id}', [\App\Http\Controllers\Admin\VisiMisiController::class, 'destroy'])->name('admin.visi-misi.destroy');

    // Admin Kelola Struktur Organisasi (Landing)
    Route::get('/admin/struktur', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'index'])->name('admin.struktur');
    Route::get('/admin/struktur/create', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'create'])->name('admin.struktur.create');
    Route::post('/admin/struktur', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'store'])->name('admin.struktur.store');
    Route::get('/admin/struktur/{id}', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'show'])->name('admin.struktur.show');
    Route::get('/admin/struktur/{id}/edit', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'edit'])->name('admin.struktur.edit');
    Route::put('/admin/struktur/{id}', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'update'])->name('admin.struktur.update');
    Route::delete('/admin/struktur/{id}', [\App\Http\Controllers\Admin\StrukturOrganisasiController::class, 'destroy'])->name('admin.struktur.destroy');

    // Admin Kelola Program Kerja (Landing)
    Route::get('/admin/program-kerja', [\App\Http\Controllers\Admin\ProgramKerjaController::class, 'index'])->name('admin.program');
    Route::get('/admin/program-kerja/create', [\App\Http\Controllers\Admin\ProgramKerjaController::class, 'create'])->name('admin.program.create');
    Route::post('/admin/program-kerja', [\App\Http\Controllers\Admin\ProgramKerjaController::class, 'store'])->name('admin.program.store');
    Route::get('/admin/program-kerja/{id}', [\App\Http\Controllers\Admin\ProgramKerjaController::class, 'show'])->name('admin.program.show');
    Route::get('/admin/program-kerja/{id}/edit', [\App\Http\Controllers\Admin\ProgramKerjaController::class, 'edit'])->name('admin.program.edit');
    Route::put('/admin/program-kerja/{id}', [\App\Http\Controllers\Admin\ProgramKerjaController::class, 'update'])->name('admin.program.update');
    Route::delete('/admin/program-kerja/{id}', [\App\Http\Controllers\Admin\ProgramKerjaController::class, 'destroy'])->name('admin.program.destroy');

    // Admin Kelola Kategori (Galeri & Katalog)
    Route::get('/admin/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.kategori');
    Route::post('/admin/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
});

require __DIR__.'/settings.php';
