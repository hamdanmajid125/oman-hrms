@extends('layouts.dashboard')
@section('page_content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm order-2 order-sm-1">
                <div class="d-flex align-items-start mt-3 mt-sm-0">
                    <div class="flex-shrink-0">
                        <div class="avatar-xl me-3">
                            <img src="{{ profileimage() }}" alt="" class="img-fluid rounded-circle d-block">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div>
                            <h5 class="font-size-16 mb-1">{{ $user->name }}</h5>
                            <p class="text-muted font-size-13">{{ $user->getMeta('designation') ? $user->getMeta('designation') : 'Developer' }}</p>

                            <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $user->name }} Attendance</h4>
            </div>
            <div class="card-header">
                <form method="GET" action="{{ route('attendance.index',$user->id) }}">
                <div class="row">
                    <div class="col-lg-3">
                        <select name="month" id="month" class="form-select">
                            <option hidden selected>Select month</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select name="year" id="year" class="form-select">
                            <option hidden selected>Select year</option>
                            <option value="2024" {{ request('year') == 2024 ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ request('year') == 2025 ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ request('year') == 2026 ? 'selected' : '' }}>2026</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Timein</th>
                                <th>Timeout</th>
                                <th>Working Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $daysInMonth = \Carbon\Carbon::create($year, $month)->daysInMonth;
                            @endphp
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $date = \Carbon\Carbon::create($year, $month, $day);
                                    $attendanceRecord = $attendance->firstWhere('date', $date->timestamp);
                                @endphp
                            <tr>
                            <td>{{ $day }}</td>
                            <td>{{ $date->format('d-M-Y') }}</td>
                            <td>{{ $date->format('l') }}</td>
                            <td>{{ $attendanceRecord ? \Carbon\Carbon::createFromTimestamp($attendanceRecord->timein)->format('h:i A') : '--' }}</td>
                            <td>{{ $attendanceRecord ? \Carbon\Carbon::createFromTimestamp($attendanceRecord->timeout)->format('h:i A') : '--' }}</td>
                            <td>{{ $attendanceRecord ? gmdate('H:i:s', $attendanceRecord->totalhours) : '--' }}</td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection