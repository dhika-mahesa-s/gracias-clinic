<?php
// app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Treatment;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    /**
     * Menampilkan landing page dengan data feedback yang dipilih admin
     */
    public function index()
    {
        // Ambil feedback dari database
        $featuredFeedbacks = Feedback::query()
            ->where('is_visible', true)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        return view('landingpage', compact('featuredFeedbacks'));
    }

    public function getFeaturedFeedbacks()
    {
        $feedbacks = Feedback::where('is_visible', true)
            ->where('is_hidden', false)
            ->with('user')
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($feedback) {
                return [
                    'id' => $feedback->id,
                    'name' => $feedback->name ?: ($feedback->user->name ?? 'Anonymous'),
                    'message' => $feedback->message,
                    'rating' => $feedback->overall_rating,
                    'service_type' => $feedback->service_type,
                    'date' => $feedback->created_at->format('M Y'),
                    'avatar' => null // Bisa ditambahkan jika ada field avatar
                ];
            });

        return response()->json($feedbacks);
    }
}