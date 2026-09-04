<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     */
    public function index(Request $request)
    {
        $query = Gallery::with(['category', 'images']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        return view('admin.galeri.index', [
            'galleries' => $query->latest()->paginate(10)->withQueryString(),
            'categories' => Category::where('type', 'galeri')->orWhere('type', 'semua')->get(),
        ]);
    }

    /**
     * Show the form for creating a new gallery.
     */
    public function create()
    {
        return view('admin.galeri.create', [
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
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|file|image|max:5120',
        ]);

        // Generate Unique Slug
        $baseSlug = Str::slug($validated['title']) ?: 'kegiatan-' . time();
        $slug = $baseSlug;
        $count = 1;
        while (Gallery::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : 1,
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'description' => $validated['description'] ?? null,
            'is_published' => filter_var($request->is_published ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Handle Photos & File Uploads into GalleryImage table
        $photos = $request->file('photos', []);
        $primaryIndex = (int) $request->input('primary_upload_index', 0);
        if ($primaryIndex < 0) $primaryIndex = 0;

        if (is_array($photos) && count($photos) > 0) {
            foreach ($photos as $idx => $file) {
                if (!$file || !is_object($file) || method_exists($file, 'isValid') && !$file->isValid()) {
                    continue;
                }

                $path = $file->store('galleries', 'public');
                $photoUrl = '/storage/' . $path;
                $isPrimary = ($idx === $primaryIndex);

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_url' => $photoUrl,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        return redirect()->route('admin.galeri')->with('success', 'Kegiatan galeri berhasil ditambahkan!');
    }

    /**
     * Display the specified gallery details.
     */
    public function show($id)
    {
        $gallery = Gallery::with(['category', 'images'])->findOrFail($id);

        return view('admin.galeri.show', [
            'gallery' => $gallery,
        ]);
    }

    /**
     * Show the form for editing the specified gallery.
     */
    public function edit($id)
    {
        $gallery = Gallery::with(['category', 'images'])->findOrFail($id);

        return view('admin.galeri.edit', [
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
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|file|image|max:5120',
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

        $gallery->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => is_numeric($validated['category_id']) ? $validated['category_id'] : $gallery->category_id,
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'description' => $validated['description'] ?? null,
            'is_published' => filter_var($request->is_published ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Handle removing specific existing images requested by user
        if ($request->has('remove_images') && is_array($request->remove_images)) {
            GalleryImage::whereIn('id', $request->remove_images)->where('gallery_id', $gallery->id)->delete();
        }

        // Handle setting specific existing image as primary
        if ($request->filled('set_primary_image_id')) {
            $primaryImg = GalleryImage::where('gallery_id', $gallery->id)->where('id', $request->set_primary_image_id)->first();
            if ($primaryImg) {
                GalleryImage::where('gallery_id', $gallery->id)->update(['is_primary' => false]);
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

                $path = $file->store('galleries', 'public');
                $photoUrl = '/storage/' . $path;
                $isPrimary = ($idx === $primaryUploadIndex);

                if ($isPrimary) {
                    GalleryImage::where('gallery_id', $gallery->id)->update(['is_primary' => false]);
                }

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_url' => $photoUrl,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        // Ensure at least 1 image is primary if images exist
        if ($gallery->images()->count() > 0 && !$gallery->images()->where('is_primary', true)->exists()) {
            $firstImg = $gallery->images()->first();
            if ($firstImg) {
                $firstImg->update(['is_primary' => true]);
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
