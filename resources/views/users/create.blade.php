@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Employee Form</h4>

                </div>
                <div class="card-body p-4">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Name</label>
                                <input class="form-control" name="name" type="text"
                                    value="{{ $data == null ? old('name') : $data->name }}" id="name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label for="emp-id" class="form-label">Text</label>
                                    <input class="form-control" name="emp_id" type="text"
                                        value="{{ $data == null ? $data->getMeta('emp_id') : '' }}" id="emp-id">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email"
                                        value="{{ $data == null ? old('name') : $data->name }}" id="email">
                                </div>
                                <div class="mb-3">
                                    <label for="example-email-input" class="form-label">Contact Number</label>
                                    <input class="form-control" type="tel"
                                        value="{{ $data == null ? $data->getMeta('phone') : '' }}" id="example-email-input">
                                </div>
                                <div class="mb-3">
                                    <label for="doj" class="form-label">Date of Joining</label>
                                    <input class="form-control" type="date"
                                        value="{{ $data == null ? $data->getMeta('date_of_join') : '' }}" id="doj">
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Telephone</label>
                                    <select name="gender" class="form-control">
                                        <option value="male" {{ $data->getMeta('gender') == 'male' ? selected : '' }}>Male
                                        </option>
                                        <option value="female" {{ $data->getMeta('gender') == 'female' ? selected : '' }}>
                                            Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="example-password-input" class="form-label">Password</label>
                                    <input class="form-control" type="password" value="hunter2" id="example-password-input">
                                </div>
                                <div class="mb-3">
                                    <label for="example-number-input" class="form-label">Number</label>
                                    <input class="form-control" type="number" value="42" id="example-number-input">
                                </div>
                                <div>
                                    <label for="example-datetime-local-input" class="form-label">Date and time</label>
                                    <input class="form-control" type="datetime-local" value="2019-08-19T13:45:00"
                                        id="example-datetime-local-input">
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <label for="example-date-input" class="form-label">Date</label>
                                    <input class="form-control" type="date" value="2019-08-19" id="example-date-input">
                                </div>
                                <div class="mb-3">
                                    <label for="example-month-input" class="form-label">Month</label>
                                    <input class="form-control" type="month" value="2019-08" id="example-month-input">
                                </div>
                                <div class="mb-3">
                                    <label for="example-week-input" class="form-label">Week</label>
                                    <input class="form-control" type="week" value="2019-W33" id="example-week-input">
                                </div>
                                <div class="mb-3">
                                    <label for="example-time-input" class="form-label">Time</label>
                                    <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                                </div>
                                <div class="mb-3">
                                    <label for="example-color-input" class="form-label">Color picker</label>
                                    <input type="color" class="form-control form-control-color mw-100"
                                        id="example-color-input" value="#5156be" title="Choose your color">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Select</label>
                                    <select class="form-select">
                                        <option>Select</option>
                                        <option>Large select</option>
                                        <option>Small select</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="exampleDataList" class="form-label">Datalists</label>
                                    <input class="form-control" list="datalistOptions" id="exampleDataList"
                                        placeholder="Type to search...">
                                    <datalist id="datalistOptions">
                                        <option value="San Francisco">
                                        </option>
                                        <option value="New York">
                                        </option>
                                        <option value="Seattle">
                                        </option>
                                        <option value="Los Angeles">
                                        </option>
                                        <option value="Chicago">
                                        </option>
                                    </datalist>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
