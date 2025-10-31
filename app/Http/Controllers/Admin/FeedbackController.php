<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query();

        // 🔍 Filter pencarian nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // ⭐ Filter berdasarkan rata-rata rating
        if ($request->filled('rating_filter')) {
            $minRating = (int) $request->rating_filter;
            $query->whereRaw('(staff_rating + professional_rating + result_rating + return_rating + overall_rating) / 5 >= ?', [$minRating]);
        }

        // 👁️ Filter visibilitas (tampil di homepage / tidak)
        if ($request->filled('visibility')) {
            $isVisible = $request->visibility === '1';
            $query->where('is_visible', $isVisible);
        }

        // 🔄 Urutkan dari terbaru dan paginate
        $feedbacks = $query->latest()->paginate(10);

        return view('feedback.index', compact('feedbacks'));
    }

    // 🔘 Toggle tampil/sembunyi dari homepage
    public function toggleVisibility($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->is_visible = !$feedback->is_visible;
        $feedback->save();

        return response()->json([
            'success' => true,
            'is_visible' => $feedback->is_visible,
            'message' => $feedback->is_visible
                ? 'Feedback berhasil ditampilkan di homepage.'
                : 'Feedback disembunyikan dari homepage.'
        ]);
    }

    // 📄 Detail feedback
   // 📄 Detail feedback
public function show($id)
{
    $feedback = Feedback::findOrFail($id);
    // ubah baris di bawah ini ⬇️
    return view('feedback.show', compact('feedback'));
}
}
