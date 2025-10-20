<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all();
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function toggleVisibility($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->is_visible = !$feedback->is_visible;
        $feedback->save();

        return redirect()->back();
    }
}
