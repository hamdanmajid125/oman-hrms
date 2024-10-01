<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::where('user_id', auth()->id())->first();
        return view('attendance.index', compact('attendance'));
    }

    public function timeIn(Request $request)
    {
        $attendance = Attendance::create([
            'user_id' => auth()->id(),
            'timein' => now()->timestamp,
            'date' => now()->startOfDay()->timestamp,
        ]);
        return redirect()->back()->with('success', 'Checked in successfully');
    }
    public function timeOut(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->timeout = now()->timestamp;
        $attendance->totalhours = $attendance->timeout - $attendance->timein;
        $attendance->save();
        return redirect()->back()->with('success', 'Checked out successfully');
    }
}