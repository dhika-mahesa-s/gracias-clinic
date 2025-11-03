<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TreatmentController extends Controller
{
    /**
     * Menampilkan semua treatment (3 card view)
     */
    public function index()
    {
        $treatments = Treatment::all();
        return view('treatments.index', compact('treatments'));
    }

    /**
     * Menampilkan 1 card detail treatment
     */
    public function show(Treatment $treatment)
    {
        
        return view('treatments.show', compact('treatment'));
    }

    /**
     * Halaman daftar untuk admin (tabel)
     */
    public function manage()
    {
        $treatments = Treatment::all();
        return view('treatments.manage', compact('treatments'));
    }

    /**
     * Form tambah treatment
     */
    public function create()
    {
        return view('treatments.create');
    }

    /**
     * Simpan treatment baru ke database
     */
     public function store(Request $request)
    {
        // Semua kolom wajib diisi (image juga wajib saat create)
        $validated = $request->validate([
            'name'        => ['required','string','max:150'],
            'description' => ['required','string'],
            'price'       => ['required','numeric','min:0'],
            'duration'    => ['required','integer','min:1'],
            'image'       => ['required','image','mimes:jpeg,png,jpg','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('treatments', 'public');
        }

        Treatment::create($validated);

        return redirect()->route('treatments.manage')->with('success', 'Treatment berhasil ditambahkan.');
    }


     // NEW: edit
    public function edit(Treatment $treatment)
    {
        return view('treatments.edit', compact('treatment'));
    }

    // NEW: update
    public function update(Request $request, Treatment $treatment)
    {
        // Semua kolom wajib diisi.
        // Gambar: harus ada salah satu—either upload baru, atau pertahankan yang lama.
        $validated = $request->validate([
            'name'        => ['required','string','max:150'],
            'description' => ['required','string'],
            'price'       => ['required','numeric','min:0'],
            'duration'    => ['required','integer','min:1'],
            'image'       => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($treatment->image) {
                Storage::disk('public')->delete($treatment->image);
            }
            $validated['image'] = $request->file('image')->store('treatments', 'public');
        } else {
            // pastikan tetap ada nilai image lama
            $validated['image'] = $treatment->image ?? null;
        }

        // pastikan tidak kosong
        if (empty($validated['image'])) {
            return back()
                ->withErrors(['image' => 'Gambar wajib diisi.'])
                ->withInput();
        }

        $treatment->update($validated);

        return redirect()->route('treatments.manage')->with('success', 'Treatment berhasil diperbarui.');
    }


    /**
     * Hapus treatment
     */
    public function destroy(Treatment $treatment)
    {
        if ($treatment->image) {
            Storage::disk('public')->delete($treatment->image);
        }

        $treatment->delete();
        return back()->with('success', 'Treatment dihapus.');
    }
}
