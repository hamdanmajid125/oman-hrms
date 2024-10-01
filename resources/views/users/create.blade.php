@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Employee Form</h4>

                </div>
                <div class="card-body p-4">

                    <form action="{{ $data == null ? route('users.store') : route('users.update',$data->id) }}" method="POST">
                        @csrf
                        {{ $data != null ? method_field('PUT') : '' }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Employee Name</label>
                                    <input class="form-control" name="name" type="text"
                                        value="{{ $data == null ? old('name') : $data->name }}" id="name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="emp-id" class="form-label">Employee ID</label>
                                    <input class="form-control" name="emp_id" type="text"
                                        value="{{ $data != null ? $data->getMeta('employee_id') : '' }}" id="emp-id">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email"
                                        value="{{ $data == null ? old('name') : $data->email }}" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="example-email-input" class="form-label">Contact Number</label>
                                    <input class="form-control" type="tel"
                                        value="{{ $data != null ? $data->getMeta('phone') : '' }}" id="example-email-input" name="phone">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="doj" class="form-label">Date of Joining</label>
                                    <input class="form-control" type="date"
                                        value="{{ $data != null ? $data->getMeta('date_of_join') : '' }}" id="doj" name="doj">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="" hidden selected>Select Gender</option>
                                        <option value="male"
                                            {{ $data != null && $data->getMeta('gender') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ $data != null && $data->getMeta('gender') == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }} Employee</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div> <!-- end col -->
    </div>
@endsection
