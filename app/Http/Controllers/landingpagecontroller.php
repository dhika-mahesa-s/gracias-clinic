<?php
// app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Treatment;

class LandingPageController extends Controller
{
    /**
     * Menampilkan landing page dengan data feedback yang dipilih admin
     */
    public function index()
    {
        try {
            // 1. AMBIL FEEDBACK YANG DIPILIH ADMIN UNTUK HOMEPAGE
            $featuredFeedbacks = Feedback::where('is_visible', true)
                ->where('is_hidden', false)
                ->whereNotNull('message') // Pastikan ada konten
                ->where('message', '!=', '') // Pastikan message tidak kosong
                ->with('user') // Eager loading untuk optimasi
                ->latest()
                ->take(3) // Sesuai dengan design 3 kolom
                ->get();

            // 2. AMBIL DATA TREATMENTS UNTUK SECTION LAYANAN
            $treatments = Treatment::where('is_active', true)
                ->select('id', 'name', 'description', 'image', 'price')
                ->latest()
                ->take(4) // Sesuai dengan design 4 kolom
                ->get();

            // 3. LOGGING UNTUK DEBUG (Optional)
            \Log::info('LandingPage loaded', [
                'feedbacks_count' => $featuredFeedbacks->count(),
                'treatments_count' => $treatments->count()
            ]);

            return view('landingpage', compact('featuredFeedbacks', 'treatments'));

        } catch (\Exception $e) {
            // 4. ERROR HANDLING - Fallback jika ada masalah
            \Log::error('LandingPageController error: ' . $e->getMessage());
            
            // Return view dengan data kosong (graceful degradation)
            return view('landingpage', [
                'featuredFeedbacks' => collect(),
                'treatments' => collect()
            ]);
        }
    }

    /**
     * API Endpoint untuk mendapatkan feedback (Optional - untuk AJAX)
     */
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