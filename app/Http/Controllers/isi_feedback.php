<?php
// app/Http/Controllers/FeedbackController.php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'service_type' => 'nullable|string|max:255',
            'staff_rating' => 'required|integer|between:1,5',
            'professional_rating' => 'required|integer|between:1,5',
            'result_rating' => 'required|integer|between:1,5',
            'return_rating' => 'required|integer|between:1,5',
            'overall_rating' => 'required|integer|between:1,5',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Feedback::create($validator->validated());

        return redirect()->route('feedback.thankyou')
            ->with('success', 'Terima kasih atas feedback Anda! Feedback membantu kami meningkatkan kualitas layanan.');
    }

    public function thankyou()
    {
        return view('feedback.thankyou');
    }
}