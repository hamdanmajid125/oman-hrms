<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Leaves,LeaveTypes};
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveAppliedMail;
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

    public function leave()
    {
        $leaves = Leaves::where('user_id', Auth::user()->id)->with('leavetype')->get();
        return view('leaves.index',compact('leaves'));
    }

    public function leaveRequest()
    {
        $leaveType = LeaveTypes::all();
        return view('leaves.create',compact('leaveType'));
    }

    public function appliedLeave(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'reason' => 'required'
        ]);
        $LeaveStore = Leaves::all();
        $year = date('Y', strtotime($request->start_date));
        $typedays = LeaveTypes::where('id', $request->type)->pluck('days')->first();
        $typename = LeaveTypes::where('id', $request->type)->pluck('name')->first();
        $takendays = Leaves::where(['type' => $request->type, 'user_id' => auth()->user()->id, 'year' => date('Y')])->count();
        $halfday = $request->half_day;
        if ($request->end_date == NULL) {
            if ($takendays >= $typedays) {
                $message = $typename . " are completely availed by you!";
                $msgstatus = 'error';
            } else {
                Leaves::updateOrCreate(
                    ['date' =>  strtotime($request->start_date), 'year' => $year, 'user_id' => auth()->user()->id],
                    ['type' => $request->type, 'reason' => $request->reason,'half_day' => $halfday]
                );
                $message = "Leave applied successfully!";
                $msgstatus = 'success';
            }
        } else {
            $startdate = strtotime($request->start_date);
            $enddate = strtotime($request->end_date);
            for ($i = $startdate; $i <= $enddate; $i += 86400) {
                if ($takendays == $typedays) {
                    $message = $typename . " are completely availed by you!";
                    $msgstatus = 'error';;
                } else {
                    Leaves::updateOrCreate(
                        ['date' =>  $i, 'year' => $year, 'user_id' => auth()->user()->id],
                        ['type' => $request->type, 'reason' => $request->reason, 'half_day' => $halfday]
                    );
                    $message = "Leave applied successfully!";
                    $msgstatus = 'success';
                }
            }
        }

        if ($msgstatus == 'success') {
            $leaveDetails = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'type' => $typename,
            ];
    
            $user = auth()->user();
            Mail::to('omanhr@mailinator.com')->send(new LeaveAppliedMail($user, $leaveDetails));
        }

        return redirect()->route('leaves.leave')->with($msgstatus,$message);
    }

    public function leaverequestajax(Request $request)
    {
        $date = $request->date;
        $year = date('Y', $request->date);
        if($request->halfday == NULL){$halfday = 0;}else{$halfday = 1;}
        $typedays = LeaveTypes::where('id', $request->type)->pluck('days')->first();
        $typename = LeaveTypes::where('id', $request->type)->pluck('name')->first();
        $takendays = Leaves::where(['type' => $request->type, 'userid' => auth()->user()->id, 'year' => date('Y')])->count();
        if($typedays == $takendays || $takendays > $typedays)
        {
            $message = $typename.' are completely availed by you';
            $msgstatus = 'error';
        }
        else{
            $leave = new Leaves;
            $leave->date = $date;
            $leave->year = $year;
            $leave->userid = Auth::user()->id;
            $leave->type = $request->type;
            $leave->reason = $request->desc;
            $leave->half_day = $halfday;
            $leave->unit_id = Auth::user()->unit_id;
            $leave->company_id = Auth::user()->company_id;
            $leave->save();
            $message = "Leave applied successfully!";
            $msgstatus = 'success';
        }
        return $responce = [$message,$msgstatus];
    }
}