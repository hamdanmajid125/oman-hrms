@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Leave Requests</h4>
            </div>
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="table-wrapper">
                        <div class="table-responsive mb-0 fixed-solution" data-pattern="priority-columns">
                            <div class="sticky-table-header">
                                <table id="tech-companies-1-clone" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th id="tech-companies-1-col-0-clone">ID</th>
                                            <th data-priority="1" id="tech-companies-1-col-1-clone">Name</th>
                                            <th data-priority="3" id="tech-companies-1-col-2-clone">Leave Type</th>
                                            <th data-priority="1" id="tech-companies-1-col-3-clone">Leave Date</th>
                                            <th data-priority="3" id="tech-companies-1-col-4-clone">Reason</th>
                                            <th data-priority="3" id="tech-companies-1-col-5-clone">Team Lead Status</th>
                                            <th data-priority="6" id="tech-companies-1-col-6-clone">Hr Status</th>
                                            <th data-priority="6" id="tech-companies-1-col-7-clone">Final status</th>
                                            <th data-priority="6" id="tech-companies-1-col-8-clone">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaves as $items)
                                        @php
                                            $date = Carbon\Carbon::createFromTimestamp($items->date)->format('d-M-Y');
                                        @endphp
                                            <tr>
                                                <td>{{ $items->user->id }}</td>
                                                <td>{{ $items->user->name }}</td>
                                                <td>{{ $items->leavetype->name }}</td>
                                                <td>{{ $date }}</td>
                                                <td data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat"><span class="badge rounded-pill bg-warning">View Reason</span></td>
                                                <td>@if($items->lead_status == 'pending')
                                                    <span class="badge rounded-pill bg-warning">Pending</span> 
                                                    @elseif($items->lead_status == 'approved')
                                                    <span class="badge rounded-pill bg-success">Approved</span>
                                                    @else
                                                    <span class="badge rounded-pill bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>@if($items->hr_status == 'pending')
                                                    <span class="badge rounded-pill bg-warning">Pending</span> 
                                                    @elseif($items->hr_status == 'approved')
                                                    <span class="badge rounded-pill bg-success">Approved</span>
                                                    @else
                                                    <span class="badge rounded-pill bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>@if($items->final_status == 'pending')
                                                    <span class="badge rounded-pill bg-warning">Pending</span> 
                                                    @elseif($items->final_status == 'approved')
                                                    <span class="badge rounded-pill bg-success">Approved</span>
                                                    @else
                                                    <span class="badge rounded-pill bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="javascript:;" rel="{{ $items->id }}" class="btn btn-success w-sm waves-effect waves-light">Approve</a>
                                                    <a href="javascript:;" rel="{{ $items->id }}" class="btn btn-danger w-sm waves-effect waves-light">Reject</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>
@endsection

@push('js')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog" style="display: block; padding-left: 0px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    
@endpush