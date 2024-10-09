@extends('front.layouts.app')
@section('content')
    <div class="job-wrapper">
        <div class="job-content">
            <nav class="navbar">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="https://demo.workdo.io/hrmgo-saas/storage/uploads/logo//logo-light.png?1728498376"
                            alt="logo" style="width: 90px">

                    </a>
                </div>
            </nav>
            <section class="job-banner">
                <div class="job-banner-bg">
                    <img src="https://demo.workdo.io/hrmgo-saas/storage/uploads/job/banner.png" alt="">
                </div>
                <div class="container">
                    <div class="job-banner-content text-center text-white">
                        <h1 class="text-white mb-3">
                            We help <br> businesses grow
                        </h1>
                        <p>Work there. Find the dream job you’ve always wanted..</p>
                        </p>
                    </div>
                </div>
            </section>
            <section class="apply-job-section">
                <div class="container">
                    <div class="apply-job-wrapper bg-light">
                        <div class="section-title text-center">
                            <h2 class="h1 mb-3"> {{ $jobs->job_title }}</h2>
                            <div class="d-flex flex-wrap justify-content-center gap-1 mb-4">
                                <span class="badge rounded p-2 bg-primary">{{ $jobs->skills }}</span>
                            </div>
                            <p> <i class="ti ti-map-pin ms-1"></i>
                                {{ ucwords($jobs->branch) }}</p>

                        </div>
                        <div class="apply-job-form">
                            <h2 class="mb-4">Apply for this job</h2>
                            <form method="POST" action="{{ route('submitApplication') }}" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" value="{{ $jobs->id }}" name="job_id">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Name</label><span
                                                class="text-danger">*</span>
                                            <input class="form-control name" required="required" name="name"
                                                type="text" id="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label><span
                                                class="text-danger">*</span>
                                            <input class="form-control" required="required" name="email" type="email"
                                                id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Phone</label> <span
                                                class="text-danger">*</span>
                                            <input class="form-control" placeholder="Enter Phone Number"
                                                pattern="^\+\d{1,3}\d{9,13}$" id="phone" required="true" name="phone"
                                                type="text">
                                            {{--  <div class=" text-xs text-danger">
                                                Please use with country code. (ex. +91)
                                            </div>  --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dob" class="form-label">Date of Birth</label><span
                                                class="text-danger">*</span>
                                            <input class="form-control datepicker w-100" required="required"
                                                name="date_of_birth" type="date" id="dob">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="gender" class="form-label">Gender</label>
                                        <div class="d-flex radio-check">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="g_male" value="male" name="gender"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="g_male">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="g_female" value="female" name="gender"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="g_female">Female</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6 ">
                                        <label for="profile" class="col-form-label">Profile</label>
                                        <input type="file" class="form-control" name="profile" id="profile"
                                            data-filename="profile_create"
                                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                        <img id="blah" src="" class="mt-3" width="25%" />
                                        <p class="profile_create"></p>
                                    </div>

                                    <div class="form-group col-md-6 ">
                                        <label for="resume" class="col-form-label">CV / Resume</label><span
                                            class="text-danger">*</span>
                                        <input type="file" class="form-control" name="resume" id="resume"
                                            data-filename="resume_create"
                                            onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])"
                                            required>
                                        <img id="blah1" class="mt-3" src="" width="25%" />
                                        <p class="resume_create"></p>

                                    </div>

                                    <div class="form-group col-md-12 ">
                                        <label for="cover_letter" class="form-label">Cover Letter</label>
                                        <textarea class="form-control" rows="3" name="cover_letter" cols="50" id="cover_letter"></textarea>
                                    </div>

                                    <div class="form-group col-md-12  question question_1">
                                        <label for="Why Do You Want to Work at This Company?" class="form-label">Why Do
                                            You Want to Work at This Company?</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="company" required>
                                    </div>
                                    <div class="form-group col-md-12  question question_2">
                                        <label for="Why Do You Want This Job?" class="form-label">Why Do You Want This
                                            Job?</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="job" required>
                                    </div>
                                    <div class="form-group col-md-12  question question_3">
                                        <label for="What Do You Consider to Be Your Weaknesses?" class="form-label">What
                                            Do You Consider to Be Your Weaknesses?</label>
                                        <input type="text" class="form-control" name="weakness">
                                    </div>

                                    <div class="col-12">
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary">Submit your
                                                application</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection
