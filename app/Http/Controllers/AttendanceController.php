<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Attendance,User};
use Auth;
use Carbon\Carbon;
class AttendanceController extends Controller
{
    public function index(Request $request, $id)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $user = User::find($id);
        $attendance = Attendance::where('user_id', $id)->get();
        return view('attendance.index',compact('user','attendance','month','year'));
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
