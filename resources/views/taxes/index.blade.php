@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                <div class="page-title-right">
                    <a href="{{ route('taxes.create') }}"
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
                        data-get='{{ route('taxes.get') }}' data-filter='[{"data": "id", "title": "ID"},{"data": "from", "title": "From"}, {"data": "to", "title": "To"}, {"data": "tax_percent", "title": "Tax Percent"}, {"data": "amount", "title": "Amount"}, {"data": "action", "title": "Action"}]'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Tax Percent</th>
                                <th>Amount</th>
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
