<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        return view('admin.kontak.index', [
            'contacts' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('admin.kontak.create');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'is_primary' => 'nullable',
            'is_active' => 'nullable',
        ]);

        Contact::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'role' => $validated['role'] ?? 'Pengelola BIL',
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_primary' => filter_var($request->is_primary ?? false, FILTER_VALIDATE_BOOLEAN),
            'is_active' => filter_var($request->is_active ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        return redirect()->route('admin.kontak')->with('success', 'Kontak pengelola berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('admin.kontak.edit', [
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'is_primary' => 'nullable',
            'is_active' => 'nullable',
        ]);

        $contact->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'role' => $validated['role'] ?? $contact->role,
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_primary' => filter_var($request->is_primary ?? false, FILTER_VALIDATE_BOOLEAN),
            'is_active' => filter_var($request->is_active ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);

        return redirect()->route('admin.kontak')->with('success', 'Kontak pengelola berhasil diperbarui!');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.kontak')->with('success', 'Kontak pengelola berhasil dihapus!');
    }
}
