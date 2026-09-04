<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Binaan;
use Illuminate\Http\Request;

class BinaanController extends Controller
{
    /**
     * Display a listing of the binaan.
     */
    public function index(Request $request)
    {
        $query = Binaan::withCount(['pengurusan', 'kontak']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        return view('admin.binaan.index', [
            'binaan' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new binaan.
     */
    public function create()
    {
        return view('admin.binaan.create');
    }

    /**
     * Store a newly created binaan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'berdiri_sejak' => 'nullable|date',
            'pengurusan' => 'nullable|array',
            'pengurusan.*.nama' => 'nullable|string|max:255',
            'pengurusan.*.jabatan' => 'nullable|string|max:255',
            'kontak' => 'nullable|array',
            'kontak.*.nama' => 'nullable|string|max:255',
            'kontak.*.whatsapp' => 'nullable|string|max:255',
        ]);

        $binaan = Binaan::create([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'] ?? null,
            'berdiri_sejak' => $validated['berdiri_sejak'] ?? null,
        ]);

        $this->syncPengurusan($binaan, $request->input('pengurusan', []));
        $this->syncKontak($binaan, $request->input('kontak', []));

        return redirect()->route('admin.binaan')->with('success', 'Data binaan berhasil ditambahkan!');
    }

    /**
     * Show the specified binaan.
     */
    public function show($id)
    {
        $binaan = Binaan::with(['pengurusan', 'kontak'])->findOrFail($id);

        return view('admin.binaan.show', [
            'binaan' => $binaan,
        ]);
    }

    /**
     * Show the form for editing the specified binaan.
     */
    public function edit($id)
    {
        $binaan = Binaan::with(['pengurusan', 'kontak'])->findOrFail($id);

        return view('admin.binaan.edit', [
            'binaan' => $binaan,
        ]);
    }

    /**
     * Update the specified binaan in storage.
     */
    public function update(Request $request, $id)
    {
        $binaan = Binaan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'berdiri_sejak' => 'nullable|date',
            'pengurusan' => 'nullable|array',
            'pengurusan.*.nama' => 'nullable|string|max:255',
            'pengurusan.*.jabatan' => 'nullable|string|max:255',
            'kontak' => 'nullable|array',
            'kontak.*.nama' => 'nullable|string|max:255',
            'kontak.*.whatsapp' => 'nullable|string|max:255',
        ]);

        $binaan->update([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'] ?? null,
            'berdiri_sejak' => $validated['berdiri_sejak'] ?? null,
        ]);

        $this->syncPengurusan($binaan, $request->input('pengurusan', []));
        $this->syncKontak($binaan, $request->input('kontak', []));

        return redirect()->route('admin.binaan')->with('success', 'Data binaan berhasil diperbarui!');
    }

    /**
     * Remove the specified binaan from storage.
     */
    public function destroy($id)
    {
        $binaan = Binaan::findOrFail($id);
        $binaan->delete();

        return redirect()->route('admin.binaan')->with('success', 'Data binaan berhasil dihapus!');
    }

    /**
     * Sync pengurusan binaan (delete + recreate).
     */
    private function syncPengurusan(Binaan $binaan, array $items): void
    {
        $binaan->pengurusan()->delete();

        foreach ($items as $item) {
            if (empty($item['nama'])) {
                continue;
            }

            $binaan->pengurusan()->create([
                'nama' => $item['nama'],
                'jabatan' => $item['jabatan'] ?? null,
            ]);
        }
    }

    /**
     * Sync kontak binaan (delete + recreate).
     */
    private function syncKontak(Binaan $binaan, array $items): void
    {
        $binaan->kontak()->delete();

        foreach ($items as $item) {
            if (empty($item['nama'])) {
                continue;
            }

            $binaan->kontak()->create([
                'nama' => $item['nama'],
                'whatsapp' => $item['whatsapp'] ?? null,
            ]);
        }
    }
}
