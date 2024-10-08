<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Attendance,User, Discrepancy, LeaveTypes, Leaves, Holiday};
use Carbon\Carbon;

class PayrollController extends Controller
{

    public function payroll(Request $request)
    {
        if(request()->has('start_date')){
            $start_date = $request->start_date;
        }
        else{
            $start_date = date('Y-m-01');
            $request->request->add(['start_date' => $start_date]); 
        }
        if(request()->has('end_date')){
            $end_date = $request->end_date;
        }
        else{
            $end_date = date('Y-m-t');
      
            $request->request->add(['end_date' => $end_date]); 
        }
        $firstday = strtotime(date('Y-m-01', strtotime($start_date)));
        $lastday = strtotime(date('Y-m-t', strtotime($end_date)));

        $users = User::withoutRole('admin')->get();
        $attendance = array();
        $final_data = [];
        foreach ($users as $thisuser) {
            $userdata = User::where('id', $thisuser->id)->first();

            $totalannualleaves = LeaveTypes::where('name', 'Annual Leaves')->pluck('days')->first();
            $totalcasualleaves = LeaveTypes::where('name', 'Casual Leaves')->pluck('days')->first();
            $totalsickleaves = LeaveTypes::where('name', 'Sick Leaves')->pluck('days')->first();
            $takenannualleaves = Leaves::where(['type' => 1, 'user_id' => $thisuser->id, 'year' => date('Y')])->count();
            $takencasualleaves = Leaves::where(['type' => 2, 'user_id' => $thisuser->id, 'year' => date('Y')])->count();
            $takensickleaves = Leaves::where(['type' => 3, 'user_id' => $thisuser->id, 'year' => date('Y')])->count();
            $annualleaves = $totalannualleaves - $takenannualleaves;
            $casualleaves = $totalcasualleaves - $takencasualleaves;
            $sickleaves = $totalsickleaves - $takensickleaves;

            $absent = 0;
            $late = 0;
            $early = 0;
            $halfday = 0;

            for ($i = $firstday; $i <= $lastday; $i += 86400) {
                    $perdayattendance = Attendance::where([['user_id', '=', $thisuser->id], ['date', '=', $i]])->first();
                    $day = date('l', $i);

                    $disrepencyofday = Discrepancy::where('user_id',$thisuser->id)->where('date',$i)->first();
                    $leaves = Leaves::where('user_id',$thisuser->id)->where('date',$i)->first();
                    if ($disrepencyofday) {
                        if ($disrepencyofday->status !== 'approved') {
                           $late++;
                        }
                       
                    }
                    elseif($leaves){
                        if ($disrepencyofday->final_status !== 'approved') {
                            $absent++;
                         }
                       
                        

                    }
                    elseif ($perdayattendance == NULL) {
                        if ($i > strtotime(date('d-M-Y'))) {
                            $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'future', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => '', 'reason' => '--'];
                        } elseif (strtotime($userdata->getMeta('joining')) > $i) {
                            $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'beforejoining', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Not Joined Yet','reason' => '--'];
                        } else {
                            if (date('D', $i) == 'Sat' || date('D', $i) == 'Sun') {
                                $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'weekend', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Weekend','reason' => '--'];
                            } else {
                                if (Holiday::where('date', $i)->count() > 0) {
                                    $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'holiday', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Holiday (' . Holiday::where('date', $i)->pluck('name')->first() . ')', 'reason' => '--'];
                                } elseif (Leaves::where(['date' => $i, 'user_id' => $thisuser->id, 'final_status' => 'approved'])->count() > 0) {
                                    $leavedata = Leaves::where(['date' => $i, 'user_id' => $thisuser->id, 'final_status' => 'approved'])->first();
                                    $data = ['username' => $userdata->name, 'department' => $userdata->gdepartmentetDepart->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Leave Availed from ' . $leavedata->leavetype->name, 'reason' => '--'];
                                
                                } 
                                else if(date('d-M-Y',$i)!= date('d-M-Y')) {
                                    $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Absent', 'reason' => '--'];

                                    $absent++;
                                }
                            }
                        }
                    } elseif ($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == NULL) {
                        $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'today', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Today', 'reason' => '--'];
                    } elseif ($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600) {
                        $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'halfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Half Day', 'reason' => '--'];
                        $halfday++;
                    } elseif ($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != NULL) {
                        $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'nohalfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Less then Half Day (Absent)', 'reason' => '--'];
                        $absent++;
                    } elseif ($perdayattendance->timeout == NULL && $perdayattendance->timein != NULL) {

                        $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'forgettotimeout', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Forgot to Timeout', 'reason' => '--'];
                    } else {
                        $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'present', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Present', 'reason' => '--'];
                        if ($data['timein'] != null) {

                            $timeIn = Carbon::createFromTimestamp($perdayattendance->timein);
                            $shiftStartTime = Carbon::parse($userdata->shift->starting_hours);

                            $shiftStartTimeWithGrace = $shiftStartTime->addMinutes($userdata->shift->grace_time);

                            if ($timeIn->format('H:i:s') > $shiftStartTimeWithGrace->format('H:i:s')) {
                                $data['status'] = 'late';
                                $data['name'] = 'Late Check In';
                                $late++;
                            } else if ($perdayattendance->totalhours < ($userdata->shift->shift_hours * 3600)) {
                                $data['status'] = 'early';
                                $data['name'] = 'Early Check Out';
                                $early++;
                            }
                        }

                    }

                        array_push($attendance, $data);

            }
           
            $totalAbsents = floor($early / 3) + floor($late / 3) + floor($halfday / 3) + $absent;
         
            $totalSalaryDeduction = floatval($userdata->getMeta('after_tax_salary')) - (floatval($userdata->getMeta('after_tax_salary'))/30 * $totalAbsents);
            array_push($final_data,[
                'id' =>$userdata->id,
                'currency' =>$userdata->getMeta('currency'),
                'name' => $userdata->name,
                'image' => $userdata->image ? $userdata->image : 'images/no-user.png',
                'salary' => $userdata->getMeta('after_tax_salary'),
                'deduction' => $totalSalaryDeduction
            ]);
        }
        return view('payrolls.index',compact('final_data'));

    }
}
