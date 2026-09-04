<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of struktur organisasi.
     */
    public function index(Request $request)
    {
        $query = StrukturOrganisasi::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->input('tipe'));
        }

        return view('admin.struktur.index', [
            'items' => $query->orderBy('sort_order')->orderBy('id')->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new struktur item.
     */
    public function create()
    {
        return view('admin.struktur.create');
    }

    /**
     * Store a newly created struktur item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:inti,divisi',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'anggota' => 'nullable|string|max:255',
            'badge' => 'nullable|in:moss,ochre',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        StrukturOrganisasi::create([
            'tipe' => $validated['tipe'],
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'anggota' => $validated['anggota'] ?? null,
            'badge' => $validated['badge'] ?? 'moss',
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.struktur')->with('success', 'Data struktur organisasi berhasil ditambahkan!');
    }

    /**
     * Show the specified struktur item.
     */
    public function show($id)
    {
        $item = StrukturOrganisasi::findOrFail($id);

        return view('admin.struktur.show', compact('item'));
    }

    /**
     * Show the form for editing the specified struktur item.
     */
    public function edit($id)
    {
        $item = StrukturOrganisasi::findOrFail($id);

        return view('admin.struktur.edit', compact('item'));
    }

    /**
     * Update the specified struktur item.
     */
    public function update(Request $request, $id)
    {
        $item = StrukturOrganisasi::findOrFail($id);

        $validated = $request->validate([
            'tipe' => 'required|in:inti,divisi',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'anggota' => 'nullable|string|max:255',
            'badge' => 'nullable|in:moss,ochre',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $item->update([
            'tipe' => $validated['tipe'],
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'anggota' => $validated['anggota'] ?? null,
            'badge' => $validated['badge'] ?? 'moss',
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.struktur')->with('success', 'Data struktur organisasi berhasil diperbarui!');
    }

    /**
     * Remove the specified struktur item.
     */
    public function destroy($id)
    {
        StrukturOrganisasi::findOrFail($id)->delete();

        return redirect()->route('admin.struktur')->with('success', 'Data struktur organisasi berhasil dihapus!');
    }
}
