<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Attendance,User, Discrepancy, LeaveTypes, Leaves, Holiday};
use Auth;
use Carbon\Carbon;
class AttendanceController extends Controller
{
    public function attendance($id, $month, $year)
    {
        // $userdata = User::find($id);
        // $numofdesc = Discrepancy::whereBetween('date', [\Carbon\Carbon::now()->startOfMonth()->timestamp, \Carbon\Carbon::now()->endOfMonth()->timestamp])->where('user_id', $id)->count();
        // if (Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'human_resource_executive' || Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'superadmin' || $id == Auth::user()->id) {
        // } else {
        //     if (Auth::user()->roles->pluck('name')[0] == 'sales_head' && (User::where('id', $id)->pluck('depart_id')->first() == 1)) {
        //     } else {
        //         if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
        //             if ((Units::where('unithead', Auth::user()->id)->count() > 0) && (User::where('id', $id)->pluck('unit_id')->first() == Units::where('unithead', Auth::user()->id)->pluck('id')->first())) {
        //             } else {
        //                 return abort(403, "You cannot view other's attendance");
        //             }
        //         } else {
        //             if ($userdata->reporting_authority == Auth::user()->id) {
        //             } else {
        //                 return abort(403, "You cannot view other's attendance");
        //             }
        //         }
        //     }
        // }
        $numofdesc = Discrepancy::whereBetween('date', [\Carbon\Carbon::now()->startOfMonth()->timestamp, \Carbon\Carbon::now()->endOfMonth()->timestamp])->where('user_id', $id)->count();
        $userdata = User::find($id);
        $date = '01-'.$month.'-'.$year;
        $firstday = strtotime(date('Y-m-01', strtotime($date)));
        $lastday = strtotime(date('Y-m-t', strtotime($date)));
        $attendance = [];
        $totalannualleaves = LeaveTypes::where('name', 'Annual Leaves')->pluck('days')->first();
        $totalcasualleaves = LeaveTypes::where('name', 'Casual Leaves')->pluck('days')->first();
        $totalsickleaves = LeaveTypes::where('name', 'Sick Leaves')->pluck('days')->first();
        $takenannualleaves = Leaves::where(['type' => 1, 'user_id' => $id, 'year' => date('Y')])->count();
        $takencasualleaves = Leaves::where(['type' => 2, 'user_id' => $id, 'year' => date('Y')])->count();
        $takensickleaves = Leaves::where(['type' => 3, 'user_id' => $id, 'year' => date('Y')])->count();
        $annualleaves = $totalannualleaves - $takenannualleaves;
        $casualleaves = $totalcasualleaves - $takencasualleaves;
        $sickleaves = $totalsickleaves - $takensickleaves;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $usersalary = $userdata->getMeta('salary');
        // $totalhours = Attendance::where('user_id',$id)->first();
        // dd($totalhours);
        $perdaysalary = $usersalary / $totalDays;
        $earned = 0;
        $deduction = 0;
        $halfdays = 0;
        for ($i = $firstday; $i <= $lastday; $i += 86400) {
            $perdayattendance = Attendance::where([['user_id', '=', $id], ['date', '=', $i]])->first();
            $disrepency = Discrepancy::where('user_id', $id)->where('date', $i)->count();
                        $disrepencystatus = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('status')->first();
                        $forgettimeout = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('timeout')->first();
                        $forgettimein = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('timein')->first();
                        if ($numofdesc >= 5) {
                            $disc_allowed = 0;
                        } else {
                            $disc_allowed = 1;
                        }
            $day = date('l', $i);
            if ($perdayattendance == null) {
                if ($i > strtotime(date('d-M-Y'))) {
                    $data = ['status' => 'future', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => ''];
                } elseif (strtotime($userdata->getMeta('joining')) > $i) {
                    $data = ['status' => 'beforejoining', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Not Joined Yet'];
                } else {
                    if (date('D', $i) == 'Sat' || date('D', $i) == 'Sun') {
                        $data = ['status' => 'weekend', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Weekend'];
                        $earned += 1;
                    } elseif (Holiday::where('date', $i)->count() > 0) {
                        $data = ['status' => 'holiday', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Holiday ('.Holiday::where('date', $i)->pluck('name')->first().')'];
                        $earned += 1;
                    } elseif ($i == strtotime(date('d-M-Y'))) {
                        $data = ['status' => 'today', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Today'];
                    } else {
                        $noofleaves = Leaves::where(['date' => $i, 'user_id' => $id])->count();
                        $leavestatus = Leaves::where(['date' => $i, 'user_id' => $id])->pluck('final_status')->first();




                        if ($disrepencystatus == 'approved') {
                            $name = 'Present';
                        }else{
                            $name = 'Absent';
                        }

                    $data = ['status' => 'absent', 'timein' =>$forgettimein ? $forgettimein : '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => $name, 'no_of_leaves' => $noofleaves, 'leave_status' => $leavestatus,'num_of_descrepancy' => $disrepency, 'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed ,'forget_time_out' => $forgettimeout ? $forgettimeout : '-'];

                        if ($leavestatus == 'approved') {
                            $earned += 1;
                        } else {
                            $deduction += 1;
                        }
                    }
                }
            } elseif ($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == null) {
                $data = ['status' => 'today', 'timein' => $perdayattendance->timein, 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Today'];
            } elseif ($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600) {
                $data = ['status' => 'halfday', 'timein' => $perdayattendance->timein, 'timeout' => $perdayattendance->timeout, 'totalhours' => $perdayattendance->totalhours, 'date' => $i, 'day' => $day, 'name' => 'Half Day'];
                $halfdays += 1;
            } elseif ($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != null) {

                $noofleaves = Leaves::where(['date' => $i, 'user_id' => $id])->count();
                $leavestatus = Leaves::where(['date' => $i, 'user_id' => $id])->pluck('final_status')->first();
                $data = ['status' => 'nohalfday', 'timein' => $perdayattendance->timein, 'timeout' => $perdayattendance->timeout, 'totalhours' => $perdayattendance->totalhours, 'date' => $i, 'day' => $day, 'name' => 'Less then Half Day (Absent)', 'no_of_leaves' => $noofleaves, 'leave_status' => $leavestatus,  'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed ,'forget_time' => $forgettimeout ? $forgettimeout : '-', 'num_of_descrepancy' => $disrepency, 'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed ];

                if ($leavestatus == 'approved') {
                    $earned += 1;
                } else {
                    $deduction += 1;
                }
            } elseif ($perdayattendance->timeout == null && $perdayattendance->timein != null) {
                $disrepency = Discrepancy::where('user_id', $id)->where('date', $i)->count();
                $disrepencystatus = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('status')->first();
                $forgettimeout = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('timeout')->first();
                if ($numofdesc >= 5) {
                    $disc_allowed = 0;
                } else {
                    $disc_allowed = 1;
                }
                $data = ['status' => 'forgettotimeout', 'timein' => $perdayattendance->timein, 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Forgot to Timeout', 'num_of_descrepancy' => $disrepency, 'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed ,'forget_time' => $forgettimeout ? $forgettimeout : '-'];
                if ($disrepencystatus == 'approved') {
                    $earned += 1;
                } else {
                    $deduction += 1;
                }
            } else {
                $data = ['status' => 'present', 'timein' => $perdayattendance->timein, 'timeout' => $perdayattendance->timeout, 'totalhours' => $perdayattendance->totalhours, 'date' => $i, 'day' => $day, 'name' => 'Present'];
                $earned += 1;

                if ($data['timein'] != null) {

                    $timeIn = Carbon::createFromTimestamp($perdayattendance->timein);
                    $shiftStartTime = Carbon::parse($userdata->shift->starting_hours);

                    $shiftStartTimeWithGrace = $shiftStartTime->addMinutes($userdata->shift->grace_time);

                    if ($timeIn->format('H:i:s') > $shiftStartTimeWithGrace->format('H:i:s')) {
                        $data['status'] = 'late';
                    } elseif ($perdayattendance->totalhours < ($userdata->shift()->shift_hours * 3600)) {
                        $data['status'] = 'early';
                    }
                }
            }
            if ($halfdays < 3) {
                $earned += $halfdays;
            } else {
                if ($halfdays % 3 == 0) {
                    $halddayded = $halfdays / 3;
                    $deduction += $halddayded;
                } else {
                    $remainder = $halfdays % 3;
                    $halfdayded = ($halfdays - $remainder) / 3;
                    $deduction += $halfdayded;
                    $earned += $remainder;
                }
            }
            $expecteddeduction = number_format($deduction * $perdaysalary, 2, '.', ',');
            array_push($attendance, $data);
        }


        // dd($total_shift_hours);
        // dd($totalShiftingHoursInHours);
        $totalhours = array_sum(array_column($attendance, 'totalhours'));
        // dd($totalhours);

        return view('attendance.index', compact(['userdata', 'attendance', 'firstday', 'lastday', 'month', 'year', 'annualleaves', 'casualleaves', 'sickleaves', 'earned', 'deduction', 'expecteddeduction',  'takenannualleaves', 'takencasualleaves', 'takensickleaves','totalhours']));
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
