<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    /**
     * Display a listing of visi & misi.
     */
    public function index(Request $request)
    {
        $query = VisiMisi::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('label', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->input('tipe'));
        }

        return view('admin.visi-misi.index', [
            'items' => $query->orderBy('sort_order')->orderBy('id')->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new visi/misi item.
     */
    public function create()
    {
        return view('admin.visi-misi.create');
    }

    /**
     * Store a newly created visi/misi item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:visi,misi',
            'label' => 'nullable|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        VisiMisi::create([
            'tipe' => $validated['tipe'],
            'label' => $validated['label'] ?? null,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.visi-misi')->with('success', 'Data visi/misi berhasil ditambahkan!');
    }

    /**
     * Show the specified visi/misi item.
     */
    public function show($id)
    {
        $item = VisiMisi::findOrFail($id);

        return view('admin.visi-misi.show', compact('item'));
    }

    /**
     * Show the form for editing the specified visi/misi item.
     */
    public function edit($id)
    {
        $item = VisiMisi::findOrFail($id);

        return view('admin.visi-misi.edit', compact('item'));
    }

    /**
     * Update the specified visi/misi item.
     */
    public function update(Request $request, $id)
    {
        $item = VisiMisi::findOrFail($id);

        $validated = $request->validate([
            'tipe' => 'required|in:visi,misi',
            'label' => 'nullable|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $item->update([
            'tipe' => $validated['tipe'],
            'label' => $validated['label'] ?? null,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.visi-misi')->with('success', 'Data visi/misi berhasil diperbarui!');
    }

    /**
     * Remove the specified visi/misi item.
     */
    public function destroy($id)
    {
        VisiMisi::findOrFail($id)->delete();

        return redirect()->route('admin.visi-misi')->with('success', 'Data visi/misi berhasil dihapus!');
    }
}
