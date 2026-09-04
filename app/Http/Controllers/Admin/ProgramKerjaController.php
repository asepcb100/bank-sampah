<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of program kerja.
     */
    public function index(Request $request)
    {
        $query = ProgramKerja::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        return view('admin.program.index', [
            'items' => $query->orderBy('kategori')->orderBy('sort_order')->orderBy('id')->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new program item.
     */
    public function create()
    {
        return view('admin.program.create');
    }

    /**
     * Store a newly created program item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pendidikan,ekonomi,humas',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        ProgramKerja::create([
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.program')->with('success', 'Program kerja berhasil ditambahkan!');
    }

    /**
     * Show the specified program item.
     */
    public function show($id)
    {
        $item = ProgramKerja::findOrFail($id);

        return view('admin.program.show', compact('item'));
    }

    /**
     * Show the form for editing the specified program item.
     */
    public function edit($id)
    {
        $item = ProgramKerja::findOrFail($id);

        return view('admin.program.edit', compact('item'));
    }

    /**
     * Update the specified program item.
     */
    public function update(Request $request, $id)
    {
        $item = ProgramKerja::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pendidikan,ekonomi,humas',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $item->update([
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.program')->with('success', 'Program kerja berhasil diperbarui!');
    }

    /**
     * Remove the specified program item.
     */
    public function destroy($id)
    {
        ProgramKerja::findOrFail($id)->delete();

        return redirect()->route('admin.program')->with('success', 'Program kerja berhasil dihapus!');
    }
}
