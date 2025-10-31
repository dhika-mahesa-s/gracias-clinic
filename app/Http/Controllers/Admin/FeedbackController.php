<?php
// app/Http/Controllers/Admin/FeedbackController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query();
        
        // Filter pencarian nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter rating berdasarkan rata-rata
        if ($request->has('rating_filter') && $request->rating_filter != '') {
            $minRating = (int)$request->rating_filter;
            $query->whereRaw('(staff_rating + professional_rating + result_rating + return_rating + overall_rating) / 5 >= ?', [$minRating]);
        }
        
        // Gunakan paginate() agar mendukung currentPage() & perPage()
        $feedbacks = $query->latest()->paginate(10);
        
        // Tetap menggunakan view tanpa admin prefix
        return view('feedback.index', compact('feedbacks'));
    }

    public function toggleVisibility($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->is_visible = !$feedback->is_visible;
        $feedback->save();

        return response()->json([
            'success' => true,
            'is_visible' => $feedback->is_visible,
            'message' => $feedback->is_visible ? 'Feedback ditampilkan di homepage' : 'Feedback disembunyikan dari homepage'
        ]);
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        // Tetap menggunakan view tanpa admin prefix
        return view('feedback.show', compact('feedback'));
    }
}