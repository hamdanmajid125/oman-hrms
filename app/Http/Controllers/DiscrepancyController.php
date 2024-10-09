<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Discrepancy, Attendance, User};
use DateTime;
use Auth;
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'desc' => 'required',
            'timein_forget' => 'required',
            'timeout_forget' => 'required' 
        ]);
        
        $input = $request->all();
        $timein = strtotime(date('Y-m-d', $input['date']). ' ' .$input['timein_forget']);
        $timeout = strtotime(date('Y-m-d', $input['date']). ' ' .$input['timeout_forget']);

        if ($timein > $timeout) {
            $date = new DateTime(date('Y-m-d h:i:s A', $timeout));
            $date->modify('+1 day');
            $timeout = strtotime($date->format('Y-m-d h:i:s A'));
        } 
        
        $discrepancy =  new Discrepancy;
        $discrepancy->desc = $input['desc'];
        $discrepancy->timein = $timein;
        $discrepancy->timeout = $timeout;
        $discrepancy->user_id = Auth::user()->id;
        $discrepancy->date = $input['date'];
        $discrepancy->save();
        
        // $hrdepart = User::whereHas(
        //         'roles',
        //         function ($q) {
        //             $q->where('name', 'human_resource_manager');
        //             $q->orWhere('name', 'human_resource_executive');
        //         }
        //     )->where('company_id',Auth::user()->company_id)->get();
        // $notifyusers = array();
        // foreach($hrdepart as $thishr)
        // {
        //     array_push($notifyusers,$thishr->id);
        // }
        $user = User::find(Auth::user()->id);
        // array_push($notifyusers,$user->reporting_authority);
        // foreach($notifyusers as $thisnotifyuser)
        // {   
        //     $notificationfor = $thisnotifyuser;
        //     $url = env('APP_URL').'discrepancy';
        //     $discrepancy->notifyalert()->create(['for' => $notificationfor, 'message' => Auth::user()->name.' filled the discrepancy for ('.date('d-M-Y',$input['date']).')!','url'=>$url, 'data' => serialize(['url'=>$url,'userid' => Auth::user()->id,'month'=>date('m'),'year'=>date('Y'), 'filled_at' => time()])]);
        //     $notify = Notify::where('for', $notificationfor)->where('notifiable_type', Discrepancy::class)->latest()->first();
        //     event(new LeavesNotify($notify, $notificationfor,$url));
        // }
        $successmessage = "Discrepancy saved successfully!";
        return redirect()->back()->with('success',$successmessage);
    }
}