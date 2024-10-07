@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Leaves</h4>

            <div class="page-title-right">
                <a href="{{ route('leaves.leaveRequest') }}"
                    class="btn btn-md btn-primary btn-rounded waves-effect waves-light">Create Leave</a>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table class="datatable table table-bordered dt-responsive  nowrap w-100 datatable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Leave Date</th>
                            <th>Leave Type</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $key => $items)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ date('d-M-Y', $items->date) }}</td>
                                <td>@if($items->half_day == 1)
                                    (Half Day)
                                    @else
                                    {{ $items->leavetype->name }}
                                    @endif
                                </td>
                                <td>{{ $items->reason }}</td>
                                <td>@if($items->final_status == 'pending')
                                    <span class="badge rounded-pill bg-warning">Pending</span> 
                                    @elseif($items->final_status == 'approved')
                                    <span class="badge rounded-pill bg-success">Approved</span>
                                    @else
                                    <span class="badge rounded-pill bg-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection