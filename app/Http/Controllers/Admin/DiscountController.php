<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiscountController extends Controller
{
    /**
     * Display a listing of discounts
     */
    public function index()
    {
        $discounts = Discount::with('treatments')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new discount
     */
    public function create()
    {
        $treatments = Treatment::orderBy('name')->get();
        return view('admin.discounts.create', compact('treatments'));
    }

    /**
     * Store a newly created discount
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'treatments' => 'required|array|min:1',
            'treatments.*' => 'exists:treatments,id',
        ]);

        // Validasi value berdasarkan type
        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withErrors(['value' => 'Persentase diskon tidak boleh lebih dari 100%'])->withInput();
        }

        $discount = Discount::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Attach treatments
        $discount->treatments()->attach($validated['treatments']);

        return redirect()->route('admin.discounts.index')
                        ->with('success', 'Diskon berhasil ditambahkan!');
    }

    /**
     * Show the form for editing discount
     */
    public function edit(Discount $discount)
    {
        $treatments = Treatment::orderBy('name')->get();
        $selectedTreatments = $discount->treatments->pluck('id')->toArray();
        
        return view('admin.discounts.edit', compact('discount', 'treatments', 'selectedTreatments'));
    }

    /**
     * Update the specified discount
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'treatments' => 'required|array|min:1',
            'treatments.*' => 'exists:treatments,id',
        ]);

        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withErrors(['value' => 'Persentase diskon tidak boleh lebih dari 100%'])->withInput();
        }

        $discount->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Sync treatments
        $discount->treatments()->sync($validated['treatments']);

        return redirect()->route('admin.discounts.index')
                        ->with('success', 'Diskon berhasil diupdate!');
    }

    /**
     * Remove the specified discount
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        
        return redirect()->route('admin.discounts.index')
                        ->with('success', 'Diskon berhasil dihapus!');
    }

    /**
     * Toggle discount active status
     */
    public function toggleStatus(Discount $discount)
    {
        $discount->update(['is_active' => !$discount->is_active]);
        
        return back()->with('success', 'Status diskon berhasil diubah!');
    }
}
