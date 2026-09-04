<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        
        $query = Category::withCount(['galleries', 'products']);
        if ($type) {
            $query->where('type', $type)->orWhere('type', 'semua');
        }

        return view('admin.kategori.index', [
            'categories' => $query->latest()->get(),
            'currentType' => $type ?? 'semua',
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:galeri,katalog,semua',
            'description' => 'nullable|string',
        ]);

        $baseSlug = Str::slug($validated['name']) ?: 'kategori-' . time();
        $slug = $baseSlug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:galeri,katalog,semua',
            'description' => 'nullable|string',
        ]);

        $slug = $category->slug;
        if ($category->name !== $validated['name']) {
            $baseSlug = Str::slug($validated['name']) ?: 'kategori-' . time();
            $slug = $baseSlug;
            $count = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->galleries()->count() > 0 || $category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh galeri atau produk.');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
