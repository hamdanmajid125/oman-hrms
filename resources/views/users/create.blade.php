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
                            <a class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Overview</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#joining" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Joining</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#address" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Address & Contacts</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#salary" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Salary</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#personal" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Personal</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#exit" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Exit</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="overview" role="tabpanel">
                            <form action="{{ route('user.save.form') }}" method="POST" id="overview-form">
                                <div class="row">
                                    <input type="hidden" name="save_method" value="overview">
                                    <x-input-component :data="$data" name="name" id="name"
                                        labelText="Employee Name" colClass="col-lg-12" />



                                    <x-input-component :data="$data" name="meta[dob]" id="dob" type="date"
                                        labelText="Date of Birth" colClass="col-lg-4" />

                                    <div class="col-lg-4">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" id="meta[gender]" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <x-input-component :data="$data" name="meta[salutation]" id="salutation" type="text"
                                        labelText="Salutation" colClass="col-lg-4" />

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="joining" role="tabpanel">
                            <form action="{{ route('user.save.form') }}" method="POST" id="joining-form">
                                <div class="row">
                                    <input type="hidden" name="save_method" value="joining">
                                    <div class="col-lg-4">
                                        <label for="dept">Department</label>
                                        <select name="meta[dept]" id="dept" class="form-control">
                                            <option value="">Test</option>
                                            <option value="">Testing</option>
                                            <option value="">Neo</option>
                                        </select>
                                    </div>

                                    <x-input-component :data="$data" name="meta[date_join]" id="date_join"
                                        labelText="Date of Joining" type="date" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[offer_date]" id="offer_date"
                                        labelText="Offer Date" type="date" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[notice_days]" id="notice_days"
                                        labelText="Notice (days)" type="number" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[contract_date]" id="contract_date"
                                        labelText="Contract End Date" type="date" colClass="col-lg-4" />


                                    <x-input-component :data="$data" name="meta[retire_date]" id="retire_date"
                                        labelText="Date of Retirement" type="date" colClass="col-lg-4" />

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="address" role="tabpanel">
                            <form action="{{ route('user.save.form') }}" method="POST" id="address-form">
                                <div class="row">
                                    <input type="hidden" name="save_method" value="address">
                                    <x-input-component :data="$data" name="meta[address]" id="date_join"
                                    labelText="Address" type="address" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[date_join]" id="date_join"
                                        labelText="Mobile Number" type="number" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[personal_email]" id="personal_email"
                                        labelText="Personal Email" type="email" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[prefered_email]" id="prefered_email"
                                        labelText="Prefered Email" type="email" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="email" id="email"
                                        labelText="Company Email" type="email" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[phone_number]" id="meta[phone_number]"
                                        labelText="Emergency Phone Number" type="number" colClass="col-lg-4" />

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="salary" role="tabpanel">
                            <form action="{{ route('user.save.form') }}" method="POST" id="salary-form">
                                <div class="row">
                                    <input type="hidden" name="save_method" value="salary">
                                    <x-input-component :data="$data" name="meta[salary]" id="salary"
                                        labelText="Salary" type="number" colClass="col-lg-4" />

                                    <x-input-component :data="$data" name="meta[after_tax_salary]" id="after_tax_salary"
                                        labelText="Salary After Tax" type="number" colClass="col-lg-4" />

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
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="personal" role="tabpanel">
                            <form action="{{ route('user.save.form') }}" method="POST" id="personal-form">
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


                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel">
                            {{-- Roles Department Education and Work Experience --}}
                        </div>
                        <div class="tab-pane" id="exit" role="tabpanel">
                            <form action="{{ route('user.save.form') }}" method="POST" id="exit-form">
                                <div class="row">
                                    <input type="hidden" name="save_method" value="exit">
                                    <x-input-component :data="$data" name="resignation_letter_date"
                                        id="meta[resignation_letter_date]" labelText="Resignation Letter Date" type="date"
                                        colClass="col-lg-4" />
                                    <x-input-component :data="$data" name="exit_interview_held_on"
                                        id="meta[exit_interview_held_on]" labelText="Exit Interview Held On" type="date"
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
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div> <!-- end col -->
    </div>
@endsection
