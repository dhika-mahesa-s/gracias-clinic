<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    // Tampilkan semua FAQ ke customer (read-only)
    public function index()
    {
        $faqs = Faq::all();
        return view('customer.faq.index', compact('faqs'));
    }
}
