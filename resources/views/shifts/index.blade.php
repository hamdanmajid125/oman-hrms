@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

            <div class="page-title-right">
                <a href="{{ route('shifts.create') }}"
                    class="btn btn-md btn-primary btn-rounded waves-effect waves-light">Create {{ $title }}</a>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table class="datatable table table-bordered dt-responsive  nowrap w-100" data-get='{{ route('shift.get') }}' data-filter='[{"data": "id", "title": "ID"},{"data": "name", "title": "Shift Name"}, {"data": "starting_time", "title": "Starting Time"}, {"data": "ending_time", "title": "Ending Time"}, {"data": "timing", "title": "Timing"}, {"data": "action", "title": "Action"}]'>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Shift Name</th>
                            <th>Starting Time</th>
                            <th>Ending Time</th>
                            <th>Timing</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{--  @foreach ($data as $key => $items)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $items->name }}</td>
                                <td>{{ $items->starting_time }}</td>
                                <td>{{ $items->ending_time }}</td>
                                <td>{{ $items->timing }}</td>
                                <td class="d-flex gap-1"><a href="{{ route('shifts.edit',$items->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form class="m-0" action="{{ route('shifts.destroy', $items->id) }}"
                                        method="POST">
                                        <input type="hidden" name="id"
                                            value="{{ $items->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                                
                            </tr>
                        @endforeach  --}}
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