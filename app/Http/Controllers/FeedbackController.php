<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // masih wajib login
    }

    public function index()
    {
        // tampilkan semua feedback (karena tidak ada user_id)
        $feedbacks = Feedback::latest()->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'customer') {
            abort(403, 'Hanya customer yang dapat mengisi feedback.');
        }

        return view('feedback.create', compact('user'));
    }

  public function store(Request $request)
{
    $user = Auth::user();
    if ($user->role !== 'customer') {
        abort(403, 'Hanya customer yang dapat mengirim feedback.');
    }

    $validated = $request->validate([
        'staff_rating' => 'required|integer|min:1|max:5',
        'professional_rating' => 'required|integer|min:1|max:5',
        'result_rating' => 'required|integer|min:1|max:5',
        'return_rating' => 'required|integer|min:1|max:5',
        'overall_rating' => 'required|integer|min:1|max:5',
        'message' => 'nullable|string|max:1000',
        // tambahkan validasi untuk user info
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
    ]);

    // Tambahkan data user dari Auth
    $validated['name'] = $user->name;
    $validated['email'] = $user->email;
    $validated['phone'] = $user->phone;

    // Hitung rata-rata rating
    $validated['rating'] = round((
        $validated['staff_rating'] +
        $validated['professional_rating'] +
        $validated['result_rating'] +
        $validated['return_rating'] +
        $validated['overall_rating']
    ) / 5, 1);

    Feedback::create($validated);

    return redirect()->route('feedback.create')->with('success', 'Terima kasih atas feedback Anda!');
}


    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }
}
