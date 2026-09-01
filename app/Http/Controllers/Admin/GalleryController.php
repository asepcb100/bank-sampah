<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     */
    public function index()
    {
        return Inertia::render('admin/Galeri', [
            'galleries' => Gallery::with(['category', 'images'])->latest()->get(),
            'categories' => Category::where('type', 'galeri')->orWhere('type', 'semua')->get(),
        ]);
    }

    /**
     * Show the form for creating a new gallery.
     */
    public function create()
    {
        return Inertia::render('admin/galeri/Create', [
            'categories' => Category::where('type', 'galeri')->orWhere('type', 'semua')->get(),
        ]);
    }

    /**
     * Store a newly created gallery in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'description' => 'nullable|string',
            'is_published' => 'nullable',
            'image_url' => 'nullable|string',
            'photos' => 'nullable|array',
        ]);

        // Generate Unique Slug
        $baseSlug = Str::slug($validated['title']) ?: 'kegiatan-' . time();
        $slug = $baseSlug;
        $count = 1;
        while (Gallery::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $defaultImage = 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800&auto=format&fit=crop';
        $primaryImageUrl = $validated['image_url'] ?? $defaultImage;

        if (str_starts_with($primaryImageUrl, 'blob:')) {
            $primaryImageUrl = $defaultImage;
        }

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : 1,
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'description' => $validated['description'] ?? null,
            'image_url' => $primaryImageUrl,
            'is_published' => filter_var($request->is_published ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Handle Photos & File Uploads
        if ($request->has('photos') && is_array($request->photos)) {
            foreach ($request->photos as $idx => $photoData) {
                $photoUrl = $photoData['url'] ?? null;
                $isPrimary = filter_var($photoData['is_primary'] ?? false, FILTER_VALIDATE_BOOLEAN) || ($idx === 0);

                if (isset($photoData['file']) && $request->hasFile("photos.{$idx}.file")) {
                    $path = $request->file("photos.{$idx}.file")->store('galleries', 'public');
                    $photoUrl = '/storage/' . $path;
                } elseif (!$photoUrl || str_starts_with($photoUrl, 'blob:')) {
                    $photoUrl = $defaultImage;
                }

                if ($isPrimary) {
                    $gallery->update(['image_url' => $photoUrl]);
                }

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_url' => $photoUrl,
                    'is_primary' => $isPrimary,
                ]);
            }
        } else {
            // Default primary image record
            GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image_url' => $gallery->image_url,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('admin.galeri')->with('success', 'Kegiatan galeri berhasil ditambahkan!');
    }

    /**
     * Display the specified gallery details.
     */
    public function show($id)
    {
        $gallery = Gallery::with(['category', 'images'])->findOrFail($id);

        return Inertia::render('admin/galeri/Show', [
            'gallery' => $gallery,
        ]);
    }

    /**
     * Show the form for editing the specified gallery.
     */
    public function edit($id)
    {
        $gallery = Gallery::with(['category', 'images'])->findOrFail($id);

        return Inertia::render('admin/galeri/Edit', [
            'gallery' => $gallery,
            'categories' => Category::where('type', 'galeri')->orWhere('type', 'semua')->get(),
        ]);
    }

    /**
     * Update the specified gallery in storage.
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'description' => 'nullable|string',
            'is_published' => 'nullable',
            'image_url' => 'nullable|string',
            'photos' => 'nullable|array',
        ]);

        // Slug Update
        $slug = $gallery->slug;
        if ($gallery->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']) ?: 'kegiatan-' . time();
            $slug = $baseSlug;
            $count = 1;
            while (Gallery::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }
        }

        $defaultImage = $gallery->image_url;
        $primaryImageUrl = $validated['image_url'] ?? $defaultImage;
        if (str_starts_with($primaryImageUrl, 'blob:')) {
            $primaryImageUrl = $defaultImage;
        }

        $gallery->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : $gallery->category_id,
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'description' => $validated['description'] ?? null,
            'image_url' => $primaryImageUrl,
            'is_published' => filter_var($request->is_published ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Update gallery images if photos are provided
        if ($request->has('photos') && is_array($request->photos)) {
            // Remove old images
            $gallery->images()->delete();

            foreach ($request->photos as $idx => $photoData) {
                $photoUrl = $photoData['url'] ?? null;
                $isPrimary = filter_var($photoData['is_primary'] ?? false, FILTER_VALIDATE_BOOLEAN) || ($idx === 0);

                if (isset($photoData['file']) && $request->hasFile("photos.{$idx}.file")) {
                    $path = $request->file("photos.{$idx}.file")->store('galleries', 'public');
                    $photoUrl = '/storage/' . $path;
                } elseif (!$photoUrl || str_starts_with($photoUrl, 'blob:')) {
                    $photoUrl = $defaultImage;
                }

                if ($isPrimary) {
                    $gallery->update(['image_url' => $photoUrl]);
                }

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_url' => $photoUrl,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        return redirect()->route('admin.galeri')->with('success', 'Kegiatan galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified gallery from storage.
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->images()->delete();
        $gallery->delete();

        return redirect()->route('admin.galeri')->with('success', 'Kegiatan galeri berhasil dihapus!');
    }
}
