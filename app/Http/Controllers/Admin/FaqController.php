<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    // Tampilkan semua FAQ
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq.index', compact('faqs'));
    }

    // Tampilkan form tambah FAQ
    public function create()
    {
        return view('admin.faq.create');
    }

    // Simpan FAQ baru ke database
    public function store(Request $request)
    {
        Faq::create($request->all());
        return redirect('/admin/faq');
    }

    // Tampilkan form edit FAQ
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    // Update FAQ di database
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($request->all());
        return redirect('/admin/faq');
    }

    // Hapus FAQ
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect('/admin/faq');
    }
}
