<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // ✅ Menampilkan semua feedback
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('feedback.index', compact('feedbacks'));
    }

    // ✅ Menampilkan form tambah feedback
    public function create()
    {
        return view('feedback.create');
    }

    // ✅ Menyimpan feedback baru (dengan popup terima kasih)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'service_type' => 'nullable|string|max:100',
            'staff_rating' => 'required|integer|min:1|max:5',
            'professional_rating' => 'required|integer|min:1|max:5',
            'result_rating' => 'required|integer|min:1|max:5',
            'return_rating' => 'required|integer|min:1|max:5',
            'overall_rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:1000',
        ]);

        Feedback::create($validated);

        // ✅ Kembali ke halaman form dengan pesan sukses (tidak redirect ke index)
        return back()->with('success', 'Terima kasih sudah bersuara!');
    }

    // ✅ Menampilkan detail feedback
    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }

    // ✅ Menampilkan form edit
    public function edit(Feedback $feedback)
    {
        return view('feedback.edit', compact('feedback'));
    }

    // ✅ Update data feedback
    public function update(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'service_type' => 'nullable|string|max:100',
            'staff_rating' => 'required|integer|min:1|max:5',
            'professional_rating' => 'required|integer|min:1|max:5',
            'result_rating' => 'required|integer|min:1|max:5',
            'return_rating' => 'required|integer|min:1|max:5',
            'overall_rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:1000',
        ]);

        $feedback->update($validated);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil diperbarui!');
    }

    // ✅ Menghapus feedback
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dihapus!');
    }
}
