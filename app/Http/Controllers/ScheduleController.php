<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('doctor')->orderBy('created_at', 'asc')->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $doctors = Doctor::where('status', 'active')->get();
        return view('schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'quota' => 'required|integer|min:1',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Hapus data jadwal
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus!');
    }
    public function edit(Schedule $schedule)
{
    $doctors = Doctor::where('status', 'active')->get();
    return view('schedules.edit', compact('schedule', 'doctors'));
}

public function update(Request $request, Schedule $schedule)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'day_of_week' => 'required',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'quota' => 'required|integer|min:1',
    ]);

    $schedule->update($request->all());

    return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui!');
}
}
