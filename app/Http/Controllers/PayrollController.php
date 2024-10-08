<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Attendance,User, Discrepancy, LeaveTypes, Leaves, Holiday};
use Carbon\Carbon;

class PayrollController extends Controller
{

    public function payroll()
    {
        if(request()->has('month')){
            $month = request()->month;
        }else{
            $month = date('m');
        }
        if(request()->has('year')){
            $year = request()->year;
        }else{
            $year = date('Y');
        }
        $date = '01-'.$month.'-'.$year;
        $firstday = strtotime(date('Y-m-01', strtotime($date)));
        $lastday = strtotime(date('Y-m-t', strtotime($date)));

        $users = User::withoutRole('admin')->get();
        $attendance = array();

        foreach ($users as $thisuser) {
            $userdata = User::where('id', $thisuser->id)->first();
            $date = "01-" . $month . "-" . $year;
            $firstday = strtotime(date('Y-m-01', strtotime($date)));
            $lastday = strtotime(date('Y-m-t', strtotime($date)));

            $totalannualleaves = LeaveTypes::where('name', 'Annual Leaves')->pluck('days')->first();
            $totalcasualleaves = LeaveTypes::where('name', 'Casual Leaves')->pluck('days')->first();
            $totalsickleaves = LeaveTypes::where('name', 'Sick Leaves')->pluck('days')->first();
            $takenannualleaves = Leaves::where(['type' => 1, 'user_id' => $thisuser->id, 'year' => date('Y')])->count();
            $takencasualleaves = Leaves::where(['type' => 2, 'user_id' => $thisuser->id, 'year' => date('Y')])->count();
            $takensickleaves = Leaves::where(['type' => 3, 'user_id' => $thisuser->id, 'year' => date('Y')])->count();
            $annualleaves = $totalannualleaves - $takenannualleaves;
            $casualleaves = $totalcasualleaves - $takencasualleaves;
            $sickleaves = $totalsickleaves - $takensickleaves;
            $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

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
                        $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'discrepencry', 'timein' => date('h:i:s A', $disrepencyofday->timein), 'timeout' => date('h:i:s A', $disrepencyofday->timeout), 'totalhours' => gmdate('H:i:s', $disrepencyofday->timeout - $disrepencyofday->timein), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' =>  'Discrepencry is in (Status: '.$disrepencyofday->status.')','reason' => $disrepencyofday->desc];
                    }
                    elseif($leaves){
                        $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Leave Availed from ' . $leaves->leavetype->name.' (Status: '.$leaves->final_status.')','reason' => $leaves->reason];
                        $absent++;

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
                                } else {
                                    $data = ['username' => $userdata->name, 'department' => $userdata->department->name, 'designation' => $userdata->getMeta('designation'), 'status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Absent', 'reason' => '--'];
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
            dump($annualleaves);
            dump($casualleaves);
            dump($sickleaves);
            dump($takencasualleaves);
            dump($takensickleaves);
            dump($totalsickleaves);
            dump('================');
            dump('Absent: ',$absent);
            dump('Late: ',$late);
            dump('Early: ',$early);
            dump('Halfday: ',$halfday);
//             $totalAbsents = floor($late / 3) + floor($halfday / 3) + $absent;
// $perDayDeduction = floatval($userdata->getMeta('after_tax_salary')) -(floatval($userdata->getMeta('after_tax_salary'))/cal_days_in_month(CAL_GREGORIAN, $month, $year)) *
//             dd($perDayDeduction);
        }

    }
}
