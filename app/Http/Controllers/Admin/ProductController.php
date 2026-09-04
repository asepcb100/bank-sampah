<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'contact', 'images']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('price_text', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        return view('admin.katalog.index', [
            'products' => $query->latest()->paginate(10)->withQueryString(),
            'categories' => Category::where('type', 'katalog')->orWhere('type', 'semua')->get(),
            'contacts' => Contact::where('is_active', true)->get(),
        ]);
    }

    public function create()
    {
        return view('admin.katalog.create', [
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
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|file|image|max:5120',
        ]);

        $baseSlug = Str::slug($validated['title']) ?: 'produk-' . time();
        $slug = $baseSlug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $product = Product::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : 1,
            'contact_id' => is_numeric($validated['contact_id']) ? $validated['contact_id'] : 1,
            'price_text' => $validated['price_text'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'is_available' => filter_var($request->is_available ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        $photos = $request->file('photos', []);
        $primaryIndex = (int) $request->input('primary_upload_index', 0);
        if ($primaryIndex < 0) $primaryIndex = 0;

        if (is_array($photos) && count($photos) > 0) {
            foreach ($photos as $idx => $file) {
                if (!$file || !is_object($file) || method_exists($file, 'isValid') && !$file->isValid()) {
                    continue;
                }

                $path = $file->store('products', 'public');
                $photoUrl = '/storage/' . $path;
                $isPrimary = ($idx === $primaryIndex);

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

        return view('admin.katalog.show', [
            'product' => $product,
        ]);
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'contact', 'images'])->findOrFail($id);

        return view('admin.katalog.edit', [
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
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|file|image|max:5120',
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

        $product->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : $product->category_id,
            'contact_id' => is_numeric($validated['contact_id']) ? $validated['contact_id'] : $product->contact_id,
            'price_text' => $validated['price_text'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'is_available' => filter_var($request->is_available ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Handle removing specific existing images requested by user
        if ($request->has('remove_images') && is_array($request->remove_images)) {
            ProductImage::whereIn('id', $request->remove_images)->where('product_id', $product->id)->delete();
        }

        // Handle setting specific existing image as primary
        if ($request->filled('set_primary_image_id')) {
            $primaryImg = ProductImage::where('product_id', $product->id)->where('id', $request->set_primary_image_id)->first();
            if ($primaryImg) {
                ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                $primaryImg->update(['is_primary' => true]);
            }
        }

        // Append new uploaded photos
        $photos = $request->file('photos', []);
        $primaryUploadIndex = $request->has('primary_upload_index') ? (int) $request->input('primary_upload_index') : -1;

        if (is_array($photos) && count($photos) > 0) {
            foreach ($photos as $idx => $file) {
                if (!$file || !is_object($file) || method_exists($file, 'isValid') && !$file->isValid()) {
                    continue;
                }

                $path = $file->store('products', 'public');
                $photoUrl = '/storage/' . $path;
                $isPrimary = ($idx === $primaryUploadIndex);

                if ($isPrimary) {
                    ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $photoUrl,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        // Ensure at least 1 image is primary if images exist
        if ($product->images()->count() > 0 && !$product->images()->where('is_primary', true)->exists()) {
            $firstImg = $product->images()->first();
            if ($firstImg) {
                $firstImg->update(['is_primary' => true]);
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
