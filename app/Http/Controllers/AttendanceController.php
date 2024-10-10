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
        $usersalary = $userdata->getMeta('after_tax_salary');
        // $totalhours = Attendance::where('user_id',$id)->first();
        // dd($totalhours);
        $perdaysalary = $usersalary / $totalDays;
        $earned = 0;
        $deduction = 0;
        $halfdays = 0;


        $absent = 0;
        $late = 0;
        $early = 0;
        $halfday = 0;



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
                } elseif (strtotime($userdata->getMeta('date_join')) > $i) {
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
                            $absent++;
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
                $halfday++;
            } elseif ($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != null) {

                $noofleaves = Leaves::where(['date' => $i, 'user_id' => $id])->count();
                $leavestatus = Leaves::where(['date' => $i, 'user_id' => $id])->pluck('final_status')->first();
                $data = ['status' => 'nohalfday', 'timein' => $perdayattendance->timein, 'timeout' => $perdayattendance->timeout, 'totalhours' => $perdayattendance->totalhours, 'date' => $i, 'day' => $day, 'name' => 'Less then Half Day (Absent)', 'no_of_leaves' => $noofleaves, 'leave_status' => $leavestatus,  'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed ,'forget_time' => $forgettimeout ? $forgettimeout : '-', 'num_of_descrepancy' => $disrepency, 'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed ];

                if ($leavestatus == 'approved') {
                    $earned += 1;
                } else {
                    $deduction += 1;
                    $absent++;
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
                    $shiftStartTime = Carbon::parse($userdata->shift->starting_time);

                    $shiftStartTimeWithGrace = $shiftStartTime->addMinutes($userdata->shift->grace_time);

                    if ($timeIn->format('H:i:s') > $shiftStartTimeWithGrace->format('H:i:s')) {
                        $data['status'] = 'late';
                        $late++;
                    } elseif ($perdayattendance->totalhours < ($userdata->shift->shift_hours * 3600)) {
                        $data['status'] = 'early';
                        $early++;
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
        $totalAbsents = floor($early / 3) + floor($late / 3) + floor($halfday / 3) + $absent;
            $totalSalaryDeduction = floatval($userdata->getMeta('after_tax_salary')) - (floatval($userdata->getMeta('after_tax_salary'))/30 * $totalAbsents);
        $totalhours = array_sum(array_column($attendance, 'totalhours'));

        return view('attendance.index', compact(['userdata', 'attendance', 'firstday', 'lastday', 'month', 'year', 'annualleaves', 'casualleaves', 'sickleaves', 'earned', 'deduction', 'totalSalaryDeduction',  'takenannualleaves', 'takencasualleaves', 'takensickleaves','totalhours']));
    }
    public function timeIn()
    {
        $userid = Auth::user()->id;
        // $shift = Auth::user()->getMeta('shift_timings');
        $timein = time();
        if (date('H:i', $timein) >= '00:00' && date('H:i', $timein) <= '06:00') {
            $date = strtotime(date('d-M-Y')) - 86400;
        } else {
            $date = strtotime(date('d-M-Y'));
        }
        $timein = Attendance::updateOrCreate([
            'user_id' => $userid,
            'date' => $date,
        ], [
            'timein' => $timein,
        ]);
        $hrdepart = User::where('id', Auth::user()->id)->get();
        $successmessage = 'Timed In Successfuly!';

        return redirect()->back()->with('success', $successmessage);
    }
    
    public function timeOut()
    {
        $userid = Auth::user()->id;
        $timeout = time();
        $date = strtotime(date('d-M-Y'));
        $timein = Attendance::where('user_id', $userid)->latest()->first();
        $timeout = Attendance::where(['user_id' => $userid, 'date' => $timein->date])->update(['timeout' => $timeout, 'totalhours' => ($timeout - ($timein->timein))]);
        $successmessage = 'Timed Out Successfuly!';

        return redirect()->back()->with('success', $successmessage);
    }

    public function attendanceCSV($id, $month, $year)
    {
        $userdata = User::find($id);
        $numofdesc = Discrepancy::whereBetween('date', [\Carbon\Carbon::now()->startOfMonth()->timestamp, \Carbon\Carbon::now()->endOfMonth()->timestamp])->where('user_id', $id)->count();
        $date = "01-" . $month . "-" . $year;
        $firstday = strtotime(date('Y-m-01', strtotime($date)));
        $lastday = strtotime(date('Y-m-t', strtotime($date)));
        $attendance = array();
        $annualleaves = LeaveTypes::where('name', 'Annual Leaves')->pluck('days')->first();
        $casualleaves = LeaveTypes::where('name', 'Casual Leaves')->pluck('days')->first();
        $sickleaves = LeaveTypes::where('name', 'Sick Leaves')->pluck('days')->first();
        for ($i = $firstday; $i <= $lastday; $i += 86400) {

            $disrepency = Discrepancy::where('user_id', $id)->where('date', $i)->count();
            $disrepencystatus = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('status')->first();
            $forgettimeout = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('timeout')->first();
            if ($numofdesc >= 5) {
                $disc_allowed = 0;
            } else {
                $disc_allowed = 1;
            }
            $perdayattendance = Attendance::where([['user_id', '=', $id], ['date', '=', $i]])->first();
            $day = date('l', $i);
            if ($perdayattendance == NULL) {
                if ($i > strtotime(date('d-M-Y'))) {
                    $data = ['status' => 'future', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => ''];
                } elseif (strtotime($userdata->getMeta('date_join')) > $i) {
                    $data = ['status' => 'beforejoining', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Not Joined Yet'];
                } else {
                    if (date('D', $i) == 'Sat' || date('D', $i) == 'Sun') {
                        $data = ['status' => 'weekend', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Weekend'];
                    } elseif (Holiday::where('date', $i)->count() > 0) {
                        $data = ['status' => 'holiday', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Holiday (' . Holidays::where('holiday_date', $i)->pluck('name')->first() . ')'];
                    } else {
                        $data = ['status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Absent'];
                        $absent++;
                    }
                }
            } elseif ($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == NULL) {
                $data = ['status' => 'today', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Today'];
            } elseif ($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600) {
                $data = ['status' => 'halfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Half Day'];
            } elseif ($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != NULL) {

                $data = ['status' => 'nohalfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Less then Half Day (Absent)', 'no_of_leaves' => $noofleaves, 'leave_status' => $leavestatus, 'disc_allowed' => $disc_allowed ,'forget_time' => $forgettimeout ? $forgettimeout : '-', 'num_of_descrepancy' => $disrepency, 'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed ] ;
                $absent++;
            } elseif ($perdayattendance->timeout == NULL && $perdayattendance->timein != NULL) {
                $data = ['status' => 'forgettotimeout', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Forgot to Timeout'];
            } else {
                $data = ['status' => 'present', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Present'];

                if ($data['timein'] != null) {

                    $timeIn = Carbon::createFromTimestamp($perdayattendance->timein);
                    $shift = $userdata->shift;
                    $shiftStartTime = Carbon::parse($shift->starting_time);

                    $shiftStartTimeWithGrace = $shiftStartTime->addMinutes($shift->grace_time);

                    if ($timeIn->format('H:i:s') > $shiftStartTimeWithGrace->format('H:i:s')) {
                        $data['name'] = 'Late Check In';
                        $late++;
                    } else if ($perdayattendance->totalhours < ($shift->shift_hours * 3600)) {
                        $data['name'] = 'Early Check Out';
                        $early++;
                    }
                }
                //present
            }
            array_push($attendance, $data);
        }

        $headers = array("Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=attendance-" . $userdata->name . "-" . date('F', mktime(0, 0, 0, $month, 10)) . "-" . $year . ".csv", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0");
        $columns = array('Date', 'Day', 'Time In', 'Time Out', 'Working Hours', 'Status');
        $callback = function () use ($attendance, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($attendance as $row) {
                $data = array($row['date'], $row['day'], $row['timein'], $row['timeout'], $row['totalhours'], $row['name']);

                fputcsv($file, $data);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}