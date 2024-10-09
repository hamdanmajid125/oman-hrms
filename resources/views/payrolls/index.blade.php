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
                <div class="card-body payroll-filter">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select class="form-select" id="year-select">
                                    @for ($i = 2000; $i <= now()->format('Y'); $i++)
                                        <option {{ request()->get('year') == $i ? 'selected' : '' }}
                                            value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="year">Salary Cycle</label>
                                <select class="form-select switch-select" name="option" id="cycle-select">
                                    <option {{ request()->get('option') == 'monthly' ? 'selected' : '' }} value="monthly"
                                        data-other="weekly">Monthly</option>
                                    <option {{ request()->get('option') == 'weekly' ? 'selected' : '' }} value="weekly"
                                        data-other="monthly">Weekly</option>
                                </select>
                            </div>


                        </div>
                        <div class="col-md-4 main-filter">
                            <div class="form-group" id="monthly" style="display: {{ request()->get('option') == 'monthly' ? 'block' : 'none' }};">
                                <label for="month">Salary Month</label>
                                <select name="month" id="month-select" class="form-select switch-select">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option {{ request()->get('month') == $i ? 'selected' : '' }} value="{{ $i }}">
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                    @endfor
                                </select>

                            </div>
                            <div class="form-group" id="weekly"
                                style="display: {{ request()->get('option') == 'weekly' ? 'block' : 'none' }};">
                                <label for="month">Salary Week</label>
                                <select name="month" id="week-select" class="form-select">
                                    @foreach (getWeeklyDates(request()->get('year')) as $item)
                                        <option data-start="{{ $item['start_date'] }}" data-end="{{ $item['end_date'] }}">
                                            {{ $item['start_date'] . ' to ' . $item['end_date'] }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table class="table table-bordered dt-responsive  nowrap w-100">
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
                                        <a href="{{ route('attendance.index', ['id' => $item['id'], 'month' => request()->get('month'), 'year' => now()->format('Y')]) }}"
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

@push('post-js')
    <script>
        function formatDate(date) {
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0'); // Adding 1 because months are zero-indexed
            let year = date.getFullYear();
            return `${year}-${month}-${day}`;
        }
        $('.switch-select').change(function() {
            $('#' + $(this).find(':selected').data('other')).slideUp()
            $('#' + $(this).find(':selected').val()).slideDown()

        });
        $('.payroll-filter .main-filter .form-select, #year-select').change(function() {
            let option = $('#cycle-select').find(':selected').val()
            let year = $('#year-select').find(':selected').val();
            let data = {
                month: $('#month-select').find(':selected').val(),
                year: year,
                option: option,

            };
            if (option == 'monthly') {
                let month = $('#month-select').find(':selected').val();
                let startDate = new Date(year, month - 1, 1);
                let endDate = new Date(year, month, 0)
                data['start_date'] = formatDate(startDate);
                data['end_date'] = formatDate(endDate);
            } else {
                data['start_date'] = $('#week-select').find(':selected').data('start')
                data['end_date'] = $('#week-select').find(':selected').data('end')
            }
            let queryParams = $.param(data);

            window.location.href = `/payrolls?${queryParams}`;

        })
    </script>
@endpush
