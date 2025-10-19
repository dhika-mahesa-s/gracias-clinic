<?php
// app/Http/Controllers/Admin/FeedbackController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        // Filter by rating
        if ($request->has('rating') && $request->rating != 'all') {
            $query->withRating($request->rating);
        }
        
        $feedbacks = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function toggleVisibility($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update(['is_hidden' => !$feedback->is_hidden]);
        
        return response()->json([
            'success' => true,
            'is_hidden' => $feedback->is_hidden
        ]);
    }
}