@extends('layouts.dashboard')

@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Permissions</h4>

                <div class="page-title-right">
                    <a href="{{ route('permissions.create') }}"
                        class="btn btn-md btn-primary btn-rounded waves-effect waves-light">Create</a>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card-header">
                <h5>Payroll Filter</h5>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select class="form-select">
                                    @for ($i = 2000; $i <= now()->format('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="year">Salary Cycle</label>
                                <select class="form-select">
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                            </div>


                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="year">Salary Month</label>
                                @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">Monthly</option>
                                @endfor
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table class="datatable table table-bordered dt-responsive  nowrap w-100 datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Salary</th>
                                <th>Deduction</th>
                                <th>Net Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($final_data as $item)
                                <tr>
                                    <td><img class="rounded-circle avatar-md" src="{{ asset($item['image']) }}"
                                            alt=""> <strong>{{ $item['name'] }}</strong> </td>
                                    <td>{{ currency_list()[$item['currency']]['symbol'] . ' ' . $item['salary'] }}</td>
                                    <td>{{ currency_list()[$item['currency']]['symbol'] . ' ' . $item['salary'] - $item['deduction'] }}
                                    </td>
                                    <td>{{ currency_list()[$item['currency']]['symbol'] . ' ' . $item['deduction'] }}</td>
                                    <td>
                                        <a href="{{ route('attendance.index', ['id' => $item['id'], 'month' => now()->format('m'), 'year' => now()->format('Y')]) }}"
                                            class="btn btn-sm btn-info">Show Attendance</a>
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
