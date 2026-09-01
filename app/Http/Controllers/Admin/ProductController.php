<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/Katalog', [
            'products' => Product::with(['category', 'contact', 'images'])->latest()->get(),
            'categories' => Category::where('type', 'katalog')->orWhere('type', 'semua')->get(),
            'contacts' => Contact::where('is_active', true)->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/katalog/Create', [
            'categories' => Category::where('type', 'katalog')->orWhere('type', 'semua')->get(),
            'contacts' => Contact::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'contact_id' => 'required',
            'price_text' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_available' => 'nullable',
            'image_url' => 'nullable|string',
            'photos' => 'nullable|array',
        ]);

        $baseSlug = Str::slug($validated['title']) ?: 'produk-' . time();
        $slug = $baseSlug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $defaultImage = 'https://images.unsplash.com/photo-1607006482602-765180037159?q=80&w=800&auto=format&fit=crop';
        $primaryImageUrl = $validated['image_url'] ?? $defaultImage;
        if (str_starts_with($primaryImageUrl, 'blob:')) {
            $primaryImageUrl = $defaultImage;
        }

        $product = Product::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : 1,
            'contact_id' => is_numeric($validated['contact_id']) ? $validated['contact_id'] : 1,
            'price_text' => $validated['price_text'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'image_url' => $primaryImageUrl,
            'is_available' => filter_var($request->is_available ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        if ($request->has('photos') && is_array($request->photos)) {
            foreach ($request->photos as $idx => $photoData) {
                $photoUrl = $photoData['url'] ?? null;
                $isPrimary = filter_var($photoData['is_primary'] ?? false, FILTER_VALIDATE_BOOLEAN) || ($idx === 0);

                if (isset($photoData['file']) && $request->hasFile("photos.{$idx}.file")) {
                    $path = $request->file("photos.{$idx}.file")->store('products', 'public');
                    $photoUrl = '/storage/' . $path;
                } elseif (!$photoUrl || str_starts_with($photoUrl, 'blob:')) {
                    $photoUrl = $defaultImage;
                }

                if ($isPrimary) {
                    $product->update(['image_url' => $photoUrl]);
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $photoUrl,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        return redirect()->route('admin.katalog')->with('success', 'Produk katalog berhasil ditambahkan!');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'contact', 'images'])->findOrFail($id);

        return Inertia::render('admin/katalog/Show', [
            'product' => $product,
        ]);
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'contact', 'images'])->findOrFail($id);

        return Inertia::render('admin/katalog/Edit', [
            'product' => $product,
            'categories' => Category::where('type', 'katalog')->orWhere('type', 'semua')->get(),
            'contacts' => Contact::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'contact_id' => 'required',
            'price_text' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_available' => 'nullable',
            'image_url' => 'nullable|string',
            'photos' => 'nullable|array',
        ]);

        $slug = $product->slug;
        if ($product->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']) ?: 'produk-' . time();
            $slug = $baseSlug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }
        }

        $defaultImage = $product->image_url;
        $primaryImageUrl = $validated['image_url'] ?? $defaultImage;
        if (str_starts_with($primaryImageUrl, 'blob:')) {
            $primaryImageUrl = $defaultImage;
        }

        $product->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : $product->category_id,
            'contact_id' => is_numeric($validated['contact_id']) ? $validated['contact_id'] : $product->contact_id,
            'price_text' => $validated['price_text'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'image_url' => $primaryImageUrl,
            'is_available' => filter_var($request->is_available ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        if ($request->has('photos') && is_array($request->photos)) {
            $product->images()->delete();

            foreach ($request->photos as $idx => $photoData) {
                $photoUrl = $photoData['url'] ?? null;
                $isPrimary = filter_var($photoData['is_primary'] ?? false, FILTER_VALIDATE_BOOLEAN) || ($idx === 0);

                if (isset($photoData['file']) && $request->hasFile("photos.{$idx}.file")) {
                    $path = $request->file("photos.{$idx}.file")->store('products', 'public');
                    $photoUrl = '/storage/' . $path;
                } elseif (!$photoUrl || str_starts_with($photoUrl, 'blob:')) {
                    $photoUrl = $defaultImage;
                }

                if ($isPrimary) {
                    $product->update(['image_url' => $photoUrl]);
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $photoUrl,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        return redirect()->route('admin.katalog')->with('success', 'Produk katalog berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->images()->delete();
        $product->delete();

        return redirect()->route('admin.katalog')->with('success', 'Produk katalog berhasil dihapus!');
    }
}
