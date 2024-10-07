<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Discrepancy, Attendance};
class DiscrepancyController extends Controller
{
    public function index()
    {
        $discrepancy = Discrepancy::all();
        return view('discrepancy.index',compact('discrepancy'));
    }

    public function approveDiscrepancy(Request $request)
    {
        $discrepancy = Discrepancy::find($request->id);
        $discrepancy->update(['status' => 'approved']);
        $attendance = Attendance::where(['user_id'=>$discrepancy->user_id,'date'=>$discrepancy->date])->first();
        $attendance->update(['timeout' => ($attendance->timein+32400),'totalhours'=>32400]);
        $notifyusers = array();
        $user = User::find($discrepancy->user_id);
        array_push($notifyusers,$user->getMeta('authority'));
        array_push($notifyusers,$discrepancy->user_id);
        foreach($notifyusers as $thisnotifyuser)
        {
            $notificationfor = $thisnotifyuser;
            $url = env('APP_URL').'discrepancy';
        }
        return 'success';
    }

    public function rejectDiscrepancy(Request $request)
    {
        $discrepancy = Discrepancy::find($request->id);
        $discrepancy->update(['status' => 'rejected']);
        $notifyusers = array();
        $user = User::find($discrepancy->user_id);
        array_push($notifyusers,$user->getMeta('authority'));
        array_push($notifyusers,$discrepancy->user_id);
        foreach($notifyusers as $thisnotifyuser)
        {
            $notificationfor = $thisnotifyuser;
            $url = env('APP_URL').'discrepancy';
        }
        return 'success';
    }
}
