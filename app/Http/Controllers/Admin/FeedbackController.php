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

        // 🔍 Filter pencarian nama - SECURED
        if ($request->filled('search')) {
            // Sanitasi input untuk prevent SQL injection & XSS
            $search = strip_tags($request->search); // Remove HTML tags
            $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); // Escape special chars
            $search = trim($search); // Remove whitespace
            
            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }
        }

        // ⭐ Filter berdasarkan rata-rata rating - SECURED
        if ($request->filled('rating_filter')) {
            $minRating = (int) $request->rating_filter;
            // Validasi range untuk prevent invalid input
            if ($minRating >= 1 && $minRating <= 5) {
                $query->whereRaw('(staff_rating + professional_rating + result_rating + return_rating + overall_rating) / 5 >= ?', [$minRating]);
            }
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
