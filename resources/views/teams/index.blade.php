@extends('layouts.dashboard')

@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                <div class="page-title-right">
                    <a href="{{ route('teams.create') }}"
                        class="btn btn-md btn-primary btn-rounded waves-effect waves-light">Create {{ $title }}</a>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table class="datatable table table-bordered dt-responsive  nowrap w-100 datatable"
                        data-get='{{ route('teams.get') }}' data-filter='[{"data": "id", "title": "ID"},{"data": "name", "title": "Name"}, {"data": "lead", "title": "Team Lead"}, {"data": "action", "title": "Action"}]'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Team Lead</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
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
