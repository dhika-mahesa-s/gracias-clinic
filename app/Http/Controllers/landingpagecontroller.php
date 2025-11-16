<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Treatment;

class LandingPageController extends Controller
{
    /**
     * Menampilkan landing page dengan optimized eager loading
     */
    public function index()
    {
        // ✅ Optimized: Eager load discounts, limit to 4, select only needed columns
        $treatments = Treatment::select('treatments.id', 'name', 'description', 'price', 'image', 'duration')
                               ->with(['discounts' => function($query) {
                                   $query->select('discounts.id', 'name', 'type', 'value', 'start_date', 'end_date', 'is_active')
                                         ->active();
                               }])
                               ->latest()
                               ->take(4)
                               ->get();
        
        // ✅ Optimized: Select only needed columns, no unnecessary relations
        $featuredFeedbacks = Feedback::select('id', 'name', 'message', 'overall_rating', 'created_at')
            ->where('is_visible', true)
            ->latest()
            ->take(5)
            ->get();
            
        return view('landingpage', compact('featuredFeedbacks', 'treatments'));
    }
}