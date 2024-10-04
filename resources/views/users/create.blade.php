@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Employee Form</h4>
                </div>
                <div class="card-body p-0">
                    <ul class="nav custom-nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-bs-toggle="tab" href="#overview" id="overview-tab"
                                role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Overview</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" id="joining-tab" href="#joining" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Joining</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" id="address-tab" href="#address" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Address & Contacts</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" id="salary-tab" href="#salary" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Salary</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" id="personal-tab" href="#personal" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Personal</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" id="profile-tab" href="#profile" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" id="exit-tab" href="#exit" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Exit</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted emp-form">

                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <div class="row">

                                <input type="hidden" name="save_method" value="overview">
                                @if ($data)
                                    <input type="hidden" id="id" value="{{ $data->id }}" name="id"
                                        value="overview">
                                @endif
                                <x-input-component :data="$data" name="name" id="name" labelText="Employee Name"
                                    colClass="col-lg-12" required="true" value="{{ $data ? $data->name : old('name') }}" />
                                <x-input-component :data="$data" name="meta[dob]" id="dob" type="date"
                                    labelText="Date of Birth" colClass="col-lg-4" required="true"
                                    value="{{ $data ? $data->getMeta('dob') : old('meta[dob]') }}" />

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="gender">Gender</label>
                                        <select name="meta[gender]" id="gender" class="form-control">
                                            <option
                                                {{ $data ? ($data->getMeta('gender') == 'male' ? 'selected' : '') : '' }}
                                                value="male">Male</option>
                                            <option
                                                {{ $data ? ($data->getMeta('gender') == 'female' ? 'selected' : '') : '' }}
                                                value="female">Female</option>
                                        </select>

                                    </div>
                                </div>
                                <x-input-component :data="$data" name="meta[salutation]" id="salutation"
                                    type="text" labelText="Salutation" colClass="col-lg-4"
                                    value="{{ $data ? $data->getMeta('salutation') : old('meta[salutation]') }}" />

                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end next" data-next="joining"
                                        data-current="overview" data-tab="joining-tab">Next</button>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="joining" role="tabpanel">
                            <div class="row">
                                <input type="hidden" name="save_method" value="joining">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="dept">Department <span class="text-danger">*</span></label>
                                        <select name="department_id" id="dept" class="form-control" required>
                                            <option hidden value="">Select Department</option>
                                            @foreach ($dept as $item)
                                                <option
                                                    {{ $data ? ($item->id == $data->department_id ? 'selected' : '') : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <x-input-component :data="$data" name="meta[date_join]" id="date_join"
                                    value="{{ $data ? $data->getMeta('date_join') : old('meta[date_join]') }}"
                                    labelText="Date of Joining" type="date" colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data" name="meta[offer_date]" id="offer_date"
                                    value="{{ $data ? $data->getMeta('offer_date') : old('meta[offer_date]') }}"
                                    labelText="Offer Date" type="date" colClass="col-lg-4" />

                                <x-input-component :data="$data" name="meta[notice_days]"
                                    value="{{ $data ? $data->getMeta('notice_days') : old('meta[notice_days]') }}"
                                    id="notice_days" labelText="Notice (days)" type="number" colClass="col-lg-4" />

                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('contract_date') : old('meta[contract_date]') }}"
                                    name="meta[contract_date]" id="contract_date" labelText="Contract End Date"
                                    type="date" colClass="col-lg-4" />


                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('retire_date') : old('meta[retire_date]') }}"
                                    name="meta[retire_date]" id="retire_date" labelText="Date of Retirement"
                                    type="date" colClass="col-lg-4" />
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end next" data-next="address"
                                        data-current="joining" data-tab="address-tab">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="address" role="tabpanel">
                            <div class="row">
                                <input type="hidden" name="save_method" value="address">
                                <x-input-component :data="$data" name="meta[address]" id="address"
                                    labelText="Address"
                                    value="{{ $data ? $data->getMeta('address') : old('meta[address]') }}" type="address"
                                    colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('mobile_number') : old('meta[mobile_number]') }}"
                                    name="meta[mobile_number]" id="date_join" labelText="Mobile Number" type="number"
                                    colClass="col-lg-4" />

                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('personal_email') : old('meta[personal_email]') }}"
                                    name="meta[personal_email]" id="personal_email" labelText="Personal Email"
                                    type="email" colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('prefered_email') : old('meta[prefered_email]') }}"
                                    name="meta[prefered_email]" id="prefered_email" labelText="Prefered Email"
                                    type="email" colClass="col-lg-4" />

                                <x-input-component :data="$data" value="{{ $data ? $data->email : '' }}"
                                    name="email" id="email" labelText="Company Email" type="email"
                                    colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('phone_number') : old('meta[phone_number]') }}"
                                    name="meta[phone_number]" id="meta[phone_number]" labelText="Emergency Phone Number"
                                    type="number" colClass="col-lg-4" />
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end next" data-next="salary"
                                        data-current="address" data-tab="salary-tab">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="salary" role="tabpanel">
                            <div class="row">
                                <input type="hidden" name="save_method" value="salary">
                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('salary') : old('meta[salary]') }}"
                                    name="meta[salary]" id="salary" labelText="Salary" type="number"
                                    colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data"
                                    value="{{ $data ? $data->getMeta('after_tax_salary') : old('meta[after_tax_salary]') }}"
                                    name="meta[after_tax_salary]" id="after_tax_salary" labelText="Salary After Tax"
                                    type="number" colClass="col-lg-4" required="true" />

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="currency">Currency</label>
                                        <select name="meta[currency]" id="currency" class="form-control">
                                            @foreach (currency_list() as $item)
                                                <option
                                                    {{ $data ? ($data->getMeta('currency') == $item['code'] ? 'selected' : '') : '' }}
                                                    {{ $item['code'] == 'USD' ? 'selected' : '' }}
                                                    value="{{ $item['code'] }}">
                                                    {{ $item['name'] . ' (' . $item['code'] . ')' }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end next" data-next="personal"
                                        data-current="salary" data-tab="personal-tab">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="personal" role="tabpanel">
                            <div class="row">
                                <input type="hidden" name="save_method" value="personal">
                                <div class="col-lg-4">
                                    <div class="mb-3">

                                        <label for="marital_status">Marital Status</label>
                                        <select name="meta[marital_status]" id="marital_status" class="form-control">
                                            <option
                                                {{ $data ? ($data->getMeta('marital_status') == 'single' ? 'selected' : '') : '' }}
                                                value="single">Single</option>
                                            <option
                                                {{ $data ? ($data->getMeta('marital_status') == 'married' ? 'selected' : '') : '' }}
                                                value="married">Married</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">

                                        <label for="blood_group">Blood Group</label>
                                        <select name="meta[blood_group]" id="blood_group" class="form-control">
                                            <option
                                                {{ $data ? ($data->getMeta('blood_group') == 'A+' ? 'selected' : '') : '' }}
                                                value="A+">A+</option>
                                            <option
                                                {{ $data ? ($data->getMeta('blood_group') == 'A-' ? 'selected' : '') : '' }}
                                                value="A-">A-</option>
                                            <option
                                                {{ $data ? ($data->getMeta('blood_group') == 'B+' ? 'selected' : '') : '' }}
                                                value="B+">B+</option>
                                            <option
                                                {{ $data ? ($data->getMeta('blood_group') == 'B-' ? 'selected' : '') : '' }}
                                                value="B-">B-</option>
                                            <option
                                                {{ $data ? ($data->getMeta('blood_group') == 'AB+' ? 'selected' : '') : '' }}
                                                value="AB+">AB+</option>
                                            <option
                                                {{ $data ? ($data->getMeta('blood_group') == 'AB-' ? 'selected' : '') : '' }}
                                                value="AB-">AB-</option>
                                        </select>
                                    </div>
                                </div>
                                <x-input-component :data="$data" name="meta[place_of_birth]" id="place_of_birth"
                                    labelText="Place Of Birth" type="text" colClass="col-lg-4"
                                    value="{{ $data ? $data->getMeta('place_of_birth') : old('meta[place_of_birth]') }}" />

                                <div class="col-lg-12">
                                    <div class="mb-3">

                                        <label for="bio">Bio / Cover Letter</label>
                                        <textarea name="meta[bio]" value="{{ $data ? $data->getMeta('bio') : old('meta[bio]') }}" id="bio"
                                            class="form-control" cols="30" rows="10">{!! $data ? $data->getMeta('bio') : old('meta[bio]') !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end next" data-next="profile"
                                        data-current="personal" data-tab="profile-tab">Next</button>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">

                                        <label for="report_author">Reporting Authority <span
                                                class="text-danger">*</span></label>
                                        <select name="reporting_authority" class="form-control" id="report_author"
                                            required>
                                            <option hidden value="">Select Reporting Authority</option>
                                            @foreach ($users as $item)
                                                <option
                                                    {{ $data ? ($data->reporting_authority == $item->id ? 'selected' : '') : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="team_id">Team <span class="text-danger">*</span></label>
                                        <select name="team_id" class="form-control" id="team_id" required>
                                            <option hidden value="">Select Team</option>
                                            @foreach ($team as $item)
                                                <option {{ $data ? ($data->team_id == $item->id ? 'selected' : '') : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">

                                        <label for="shift_id">Team <span class="text-danger">*</span></label>
                                        <select name="shift_id" class="form-control" id="shift_id" required>
                                            <option hidden value="">Select Shift Timings</option>
                                            @foreach ($shifts as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data ? ($data->shift_id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}
                                                    ({{ $item->timing }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <x-input-component :data="$data" name="meta[designation]" id="designation"
                                    labelText="Designation"
                                    value="{{ $data ? $data->getMeta('designation') : old('meta[designation]') }}"
                                    type="text" colClass="col-lg-6" required="true" />

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shift_id">Roles</label>
                                        <select class="select2 form-control" name="roles[]" multiple>
                                            @foreach ($roles as $item)
                                                <option value="{{ $item->name }}"
                                                    {{ $data ? ($data->hasRole($item->name) ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6>Education</h6>
                                    <hr>
                                    @if ($data)
                                        @if ($data->getMeta('education'))
                                            @php
                                                $count = 0;
                                            @endphp
                                            @foreach (json_decode($data->getMeta('education'), true) as $item)
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">Level</label>
                                                        <input name="preeducation[{{ $count }}][level]"
                                                            type="text" value="{{ $item['level'] }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Institute</label>
                                                        <input type="text"
                                                            name="preeducation[{{ $count }}][institue]"
                                                            value="{{ $item['institue'] }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Grade/CGPA</label>
                                                        <input type="text"
                                                            name="preeducation[{{ $count }}][grade]"
                                                            name="grade" value="{{ $item['grade'] }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button class="btn btn-danger mt-4"
                                                            onclick="deleteForm(this.parentElement.parentElement)"
                                                            type="button">Delete</button>
                                                    </div>
                                                </div>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @endif
                                    <div class="repeater">
                                        <div data-repeater-list="education">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">Level</label>
                                                        <input type="text" name="level" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Institute</label>
                                                        <input type="text" name="institue" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Grade/CGPA</label>
                                                        <input type="text" name="grade" class="form-control">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button data-repeater-delete class="btn btn-danger mt-4"
                                                            type="button">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button data-repeater-create class="btn btn-primary mt-4" type="button">Add
                                            More</button>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <h6>Work Experience</h6>
                                    <hr>
                                    @if ($data)
                                        @if ($data->getMeta('work_experience'))
                                            @foreach (json_decode($data->getMeta('work_experience'), true) as $item)
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">Company</label>
                                                        <input type="text" value="{{ $item['company'] }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Position</label>
                                                        <input type="text" value="{{ $item['position'] }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Year</label>
                                                        <input type="text" value="{{ $item['year'] }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button class="btn btn-danger mt-4" type="button">Remove</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                    <div class="repeater">
                                        <div data-repeater-list="education">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">Level</label>
                                                        <input type="text" name="level" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Institute</label>
                                                        <input type="text" name="institue" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Grade/CGPA</label>
                                                        <input type="text" name="grade" class="form-control">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button data-repeater-delete class="btn btn-danger mt-4"
                                                            type="button">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button data-repeater-create class="btn btn-primary mt-4" type="button">Add
                                            More</button>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end next" data-next="exit"
                                        data-current="profile" data-tab="exit-tab">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="exit" role="tabpanel">
                            <div class="row">
                                <x-input-component :data="$data" name="resignation_letter_date"
                                    id="meta[resignation_letter_date]"
                                    value="{{ $data ? $data->getMeta('resignation_letter_date') : old('meta[resignation_letter_date]') }}"
                                    labelText="Resignation Letter Date" type="date" colClass="col-lg-4" />
                                <x-input-component :data="$data" id="exit_interview_held_on"
                                    value="{{ $data ? $data->getMeta('exit_interview_held_on') : old('meta[exit_interview_held_on]') }}"
                                    name="meta[exit_interview_held_on]" labelText="Exit Interview Held On" type="date"
                                    colClass="col-lg-4" />
                                <div class="col-lg-4">
                                    <label for="leave_encashed">Leave Encashed</label>
                                    <select name="meta[leave_encashed]" id="leave_encashed" class="form-control">
                                        <option
                                            {{ $data ? ($data->getMeta('leave_encashed') == 'Yes' ? 'selected' : '') : '' }}
                                            value="Yes">Yes</option>
                                        <option
                                            {{ $data ? ($data->getMeta('leave_encashed') == 'No' ? 'selected' : '') : '' }}
                                            value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="reason_leaving">Reason for Leaving</label>
                                    <textarea name="meta[reason_leaving]"
                                        value="{{ $data ? $data->getMeta('reason_leaving') : old('meta[reason_leaving]') }}" id="reason_leaving"
                                        class="form-control" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end submit-btn">Submit</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end col -->
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('js/select2.min.css') }}">
@endpush

@push('post-js')
    <script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>

    <script>
        $('.repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'level': '',
                'institue': '',
                'grade': ''
            },
            show: function() {
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        function deleteForm(elem) {
            elem.remove()
        }


        $('.next').click(function() {
            let required = false;
            let invalidEmail = false;

            $('#' + $(this).data('current') + ' .form-control[required]').each(function() {
                let fieldValue = $(this).val();

                // Check if required field is empty
                if (!required && fieldValue.length === 0) {
                    required = true;
                }

                // Check if it's an email field and validate the email format
                if ($(this).attr('type') === 'email' && !invalidEmail) {
                    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email validation regex
                    if (!emailPattern.test(fieldValue)) {
                        invalidEmail = true;
                    }
                }
            });

            // Show error messages
            if (required) {
                toastr.error('Please fill all required fields');
            } else if (invalidEmail) {
                toastr.error('Please enter a valid email address');
            } else {
                $('#' + $(this).data('tab')).tab('show');
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
            }
        });

        // Submit button functionality with form data collection and AJAX request
        $('.submit-btn').click(function() {
            let data = {};

            $('.emp-form .form-control').each(function() {
                console.log($(this))
                data[$(this).attr('name')] = $(this).val();
            });
            if ($('#id').val().length > 0) {
                data['id'] = $('#id').val()

            }

            $.ajax({
                type: 'POST',
                url: "{{ route('user.save.form') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success('Form submitted successfully');
                    }
                },
                error: function(response) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });
    </script>
@endpush
