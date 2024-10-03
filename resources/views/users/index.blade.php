@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Employees</h4>

                <div class="page-title-right">
                    <a href="{{ route('users.create') }}"
                        class="btn btn-md btn-primary btn-rounded waves-effect waves-light">Create Employee</a>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table class="datatable table table-bordered dt-responsive nowrap w-100 datatable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $items)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $items->name }}</td>
                                    <td>{{ $items->email }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a class="btn btn-sm btn-primary" href="{{ route('users.edit', $items->id) }}">Edit</a>
                                            <form action="{{ route('users.destroy', $items->id) }}" method="POST">
                                                <input type="hidden" name="id" value="{{ $items->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                            <a href="{{ route('attendance.index', $items->id) }}" class="btn btn-sm btn-info">Show Attendance</a>
                                        </div>
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

@push('post-css')
    @include('includes.datatable.css')
@endpush

@push('post-js')
    @include('includes.datatable.script')
@endpush

