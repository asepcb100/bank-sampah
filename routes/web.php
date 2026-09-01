<?php

use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Landing', [
        'galleries' => Gallery::with(['category', 'images'])->where('is_published', true)->latest()->take(6)->get(),
        'products' => Product::with(['category', 'contact', 'images'])->where('is_available', true)->latest()->take(6)->get(),
        'contacts' => Contact::where('is_active', true)->get(),
    ]);
})->name('home');

Route::get('/galeri', function () {
    return Inertia::render('Galeri', [
        'galleries' => Gallery::with(['category', 'images'])->where('is_published', true)->latest()->get(),
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

    return Inertia::render('galeri/Show', [
        'gallery' => $gallery,
        'related' => $related,
    ]);
})->name('galeri.show');

Route::get('/katalog', function () {
    return Inertia::render('Katalog', [
        'products' => Product::with(['category', 'contact', 'images'])->where('is_available', true)->latest()->get(),
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

    return Inertia::render('katalog/Show', [
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
        return Inertia::render('Dashboard', [
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
});

require __DIR__.'/settings.php';
