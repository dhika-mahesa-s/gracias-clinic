<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Treatment;

class LandingPageController extends Controller
{
    /**
     * Menampilkan landing page dengan optimized eager loading
     * Prioritas: Treatment dengan diskon aktif ditampilkan terlebih dahulu
     */
    public function index()
    {
        // ✅ Prioritas 1: Ambil treatment yang memiliki diskon aktif
        $treatmentsWithDiscount = Treatment::select('treatments.id', 'name', 'description', 'price', 'image', 'duration')
                                           ->with(['discounts' => function($query) {
                                               $query->select('discounts.id', 'name', 'type', 'value', 'start_date', 'end_date', 'is_active')
                                                     ->active();
                                           }])
                                           ->whereHas('discounts', function($query) {
                                               $query->active();
                                           })
                                           ->latest()
                                           ->take(4)
                                           ->get();

        // ✅ Prioritas 2: Jika treatment dengan diskon < 4, ambil treatment tanpa diskon untuk melengkapi
        $remaining = 4 - $treatmentsWithDiscount->count();
        
        if ($remaining > 0) {
            $treatmentsWithoutDiscount = Treatment::select('treatments.id', 'name', 'description', 'price', 'image', 'duration')
                                                  ->with(['discounts' => function($query) {
                                                      $query->select('discounts.id', 'name', 'type', 'value', 'start_date', 'end_date', 'is_active')
                                                            ->active();
                                                  }])
                                                  ->whereDoesntHave('discounts', function($query) {
                                                      $query->active();
                                                  })
                                                  ->latest()
                                                  ->take($remaining)
                                                  ->get();
            
            // Merge: Treatment dengan diskon + treatment tanpa diskon
            $treatments = $treatmentsWithDiscount->merge($treatmentsWithoutDiscount);
        } else {
            $treatments = $treatmentsWithDiscount;
        }
        
        // ✅ Optimized: Select only needed columns, no unnecessary relations
        $featuredFeedbacks = Feedback::select('id', 'name', 'message', 'overall_rating', 'created_at')
            ->where('is_visible', true)
            ->latest()
            ->take(5)
            ->get();
            
        return view('landingpage', compact('featuredFeedbacks', 'treatments'));
    }
}