@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Discrepancy</h4>
            </div>
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="table-wrapper">
                        <div class="table-responsive mb-0 fixed-solution" data-pattern="priority-columns">
                            <div class="sticky-table-header">
                                <table id="tech-companies-1-clone" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th id="tech-companies-1-col-0-clone">EMP-ID</th>
                                            <th data-priority="1" id="tech-companies-1-col-1-clone">Name</th>
                                            <th data-priority="3" id="tech-companies-1-col-2-clone">Date</th>
                                            <th data-priority="1" id="tech-companies-1-col-3-clone">Timein</th>
                                            <th data-priority="3" id="tech-companies-1-col-4-clone">Timeout</th>
                                            <th data-priority="3" id="tech-companies-1-col-5-clone">Reason</th>
                                            <th data-priority="6" id="tech-companies-1-col-6-clone">Status</th>
                                            <th data-priority="6" id="tech-companies-1-col-7-clone">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($discrepancy as $items)
                                            <tr>
                                                <td>{{ $items->user->id }}</td>
                                                <td>{{ $items->user->name }}</td>
                                                <td>{{ date('d-M-Y', $items->date) }}</td>
                                                <td>@if ($items->timein)
                                                    {{ date('h:i:s A', $items->timein) }}
                                                @else
                                                    --
                                                @endif</td>
                                                <td>@if ($items->timeout)
                                                    {{ date('h:i:s A', $items->timeout) }}
                                                @else
                                                    --
                                                @endif</td>
                                                <td data-bs-toggle="modal" data-bs-target="#reasonModal" rel="{{ $items->desc }}" class="showreason"><span class="badge rounded-pill bg-success">View Reason</span></td>
                                                <td>@if($items->status == 'pending')
                                                    <span class="badge rounded-pill bg-warning">Pending</span> 
                                                    @elseif($items->status == 'approved')
                                                    <span class="badge rounded-pill bg-success">Approved</span>
                                                    @else
                                                    <span class="badge rounded-pill bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="javascript:;" rel="{{ $items->id }}" class="btn btn-success w-sm waves-effect waves-light approveDiscrepancy">Approve</a>
                                                    <a href="javascript:;" rel="{{ $items->id }}" class="btn btn-danger w-sm waves-effect waves-light rejectDiscrepancy">Reject</a>
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

@push('post-css')
    @include('includes.datatable.css')
@endpush

@push('post-js')
    @include('includes.datatable.script')
@endpush

@push('js')
<div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Discrepancy Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="discrepancyreason"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    document.querySelectorAll('.showreason').forEach(function(element) {
        element.addEventListener('click', function() {
            let reason = this.getAttribute('rel');
            document.querySelector('.discrepancyreason').textContent = reason;
        });
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.approveDiscrepancy', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to Approve This Discrepancy?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then(function() {
            $.ajax({
                url: "{{ route('discrepancy.approveDiscrepancy') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    type: 'approveDiscrepancy',
                    id: id
                },
                success: function(result) {
                    Swal.fire(
                            'Approved!',
                            'Leave has been Approved successfully!',
                            'success'
                    )
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }

            })
        }, function(result) {
            if (result === 'cancel') {}
        })
    })

    $(document).on('click', '.rejectDiscrepancy', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to Reject This Discrepancy?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reject it!'
        }).then(function() {
            $.ajax({
                url: "{{ route('discrepancy.rejectDiscrepancy') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    type: 'rejectDiscrepancy',
                    id: id
                },
                success: function(result) {
                    Swal.fire(
                            'Rejected!',
                            'Leave has been Rejected successfully!',
                            'success'
                    )
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }

            })
        }, function(result) {
            if (result === 'cancel') {}
        })
    })
</script>
@endpush