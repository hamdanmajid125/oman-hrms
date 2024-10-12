@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">See Applicants</h4>

                {{--  <div class="page-title-right">
                    <a href="{{ route('leaves.leaveRequest') }}"
                        class="btn btn-md btn-primary btn-rounded waves-effect waves-light">Create Leave</a>
                </div>  --}}

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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs->jobApplication as $key => $items)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $items->name }}</td>
                                    <td>{{ $items->email }}</td>
                                    <td><a href="{{ route('applicantDetail', $items->id) }}"
                                            class="btn btn-sm btn-primary">See Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
