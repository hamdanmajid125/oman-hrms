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
                                <x-input-component :data="$data" name="name" id="name" labelText="Employee Name"
                                    colClass="col-lg-12" required="true" />

                                <x-input-component :data="$data" name="meta[dob]" id="dob" type="date"
                                    labelText="Date of Birth" colClass="col-lg-4" required="true" />

                                <div class="col-lg-4">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" id="meta[gender]" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <x-input-component :data="$data" name="meta[salutation]" id="salutation" type="text"
                                    labelText="Salutation" colClass="col-lg-4" />

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
                                    <label for="dept">Department <span class="text-danger">*</span></label>
                                    <select name="department_id" id="dept" class="form-control" required>
                                        <option hidden value="">Select Department</option>
                                        @foreach ($dept as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <x-input-component :data="$data" name="meta[date_join]" id="date_join"
                                    labelText="Date of Joining" type="date" colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data" name="meta[offer_date]" id="offer_date"
                                    labelText="Offer Date" type="date" colClass="col-lg-4" />

                                <x-input-component :data="$data" name="meta[notice_days]" id="notice_days"
                                    labelText="Notice (days)" type="number" colClass="col-lg-4" />

                                <x-input-component :data="$data" name="meta[contract_date]" id="contract_date"
                                    labelText="Contract End Date" type="date" colClass="col-lg-4" />


                                <x-input-component :data="$data" name="meta[retire_date]" id="retire_date"
                                    labelText="Date of Retirement" type="date" colClass="col-lg-4" />
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
                                    labelText="Address" type="address" colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data" name="meta[date_join]" id="date_join"
                                    labelText="Mobile Number" type="number" colClass="col-lg-4" />

                                <x-input-component :data="$data" name="meta[personal_email]" id="personal_email"
                                    labelText="Personal Email" type="email" colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data" name="meta[prefered_email]" id="prefered_email"
                                    labelText="Prefered Email" type="email" colClass="col-lg-4" />

                                <x-input-component :data="$data" name="email" id="email"
                                    labelText="Company Email" type="email" colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data" name="meta[phone_number]" id="meta[phone_number]"
                                    labelText="Emergency Phone Number" type="number" colClass="col-lg-4" />
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-end next" data-next="salary"
                                        data-current="address" data-tab="salary-tab">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="salary" role="tabpanel">
                            <div class="row">
                                <input type="hidden" name="save_method" value="salary">
                                <x-input-component :data="$data" name="meta[salary]" id="salary"
                                    labelText="Salary" type="number" colClass="col-lg-4" required="true" />

                                <x-input-component :data="$data" name="meta[after_tax_salary]" id="after_tax_salary"
                                    labelText="Salary After Tax" type="number" colClass="col-lg-4" required="true"/>

                                <div class="col-lg-4">
                                    <label for="currency">Currency</label>
                                    <select name="meta[currency]" id="currency" class="form-control">
                                        @foreach (currency_list() as $item)
                                            <option {{ $item['code'] == 'USD' ? 'selected' : '' }}
                                                value="{{ $item['code'] }}">
                                                {{ $item['name'] . ' (' . $item['code'] . ')' }}</option>
                                        @endforeach
                                    </select>
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
                                    <label for="marital_status">Marital Status</label>
                                    <select name="meta[marital_status]" id="marital_status" class="form-control">
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="blood_group">Blood Group</label>
                                    <select name="meta[blood_group]" id="blood_group" class="form-control">
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                </div>
                                <x-input-component :data="$data" name="meta[place_of_birth]" id="place_of_birth"
                                    labelText="Place Of Birth" type="text" colClass="col-lg-4" />

                                <div class="col-lg-12">
                                    <label for="bio">Bio / Cover Letter</label>
                                    <textarea name="meta[bio]" id="bio" class="form-control" cols="30" rows="10"></textarea>
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
                                    <label for="report_author">Reporting Authority <span class="text-danger">*</span></label>
                                    <select name="reporting_authority" class="form-control" id="report_author" required>
                                        <option hidden value="">Select Reporting Authority</option>
                                        @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>                                    
                                        @endforeach
                                    </select>
                                   
                                </div>
                                <div class="col-md-4">
                                    <label for="team_id">Team <span class="text-danger">*</span></label>
                                    <select name="team_id" class="form-control" id="team_id" required>
                                        <option hidden value="">Select Team</option>
                                        @foreach ($team as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>                                    
                                        @endforeach
                                    </select>
                                   
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
                                    id="meta[resignation_letter_date]" labelText="Resignation Letter Date" type="date"
                                    colClass="col-lg-4" />
                                <x-input-component :data="$data" id="exit_interview_held_on"
                                    name="meta[exit_interview_held_on]" labelText="Exit Interview Held On" type="date"
                                    colClass="col-lg-4" />
                                <div class="col-lg-4">
                                    <label for="leave_encashed">Leave Encashed</label>
                                    <select name="meta[leave_encashed]" id="leave_encashed" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="reason_leaving">Reason for Leaving</label>
                                    <textarea name="meta[reason_leaving]" id="reason_leaving" class="form-control" cols="30" rows="10"></textarea>
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

@push('js')
    <script>
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

            $.ajax({
                type: 'POST',
                url: "{{ route('user.save.form') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle the success response
                    toastr.success('Form submitted successfully');
                },
                error: function(response) {
                    // Handle error response
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });
    </script>
@endpush
