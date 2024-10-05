<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaves;
class LeaveController extends Controller
{
    public function allLeaves()
    {
        $leaves = Leaves::all();
        return view('leaves.companyleaves',compact('leaves'));
    }

    public function approve(Request $request)
    {
        $leave = Leaves::find($request->id);
        $leave->update(['final_status' => 'approved', 'hr_status' => 'approved']);
        return 'success';
    }

    public function reject(Request $request)
    {
        $leave = Leaves::find($request->id);
        $leave->update(['final_status' => 'rejected', 'hr_status' => 'rejected']);
        return 'success';
    }
}
