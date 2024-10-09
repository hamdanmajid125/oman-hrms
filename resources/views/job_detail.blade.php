@extends('front.layouts.app')
@section('content')
    <div class="job-wrapper">
        <div class="job-content">
            <nav class="navbar">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="https://demo.workdo.io/hrmgo-saas/storage/uploads/logo//logo-light.png?1728496485"
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

                            <p><b>{{ $jobs->job_title }}</b></p>

                            <div class="d-flex flex-wrap justify-content-center gap-1 mb-4">
                                <span class="badge rounded p-2 bg-primary">{{ $jobs->skills }}</span>
                            </div>

                            <p> <i class="ti ti-map-pin ms-1"></i>
                                {{ ucwords($jobs->branch) }}</p>

                            <a href="{{ route('apply.Job', $jobs->id) }}" class="btn btn-primary rounded">Apply now <i
                                    class="ti ti-send ms-2"></i>
                            </a>
                        </div>
                        <h3>Requirements</h3>
                        <p>
                        <p
                            style="margin-right: 0px; margin-bottom: 18px; margin-left: 0px; border: 0px; padding: 0px; vertical-align: baseline; color: #262626; font-family: Helvetica, Arial, sans-serif; font-size: 13px;">
                            {{ $jobs->requirement }}</p>


                        <hr>
                        <h3>Description</h3><br>
                        <p
                            style="margin-right: 0px; margin-bottom: 1em; margin-left: 0px; -webkit-font-smoothing: antialiased; font-family: 'Noto Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #2d2d2d; font-size: 13.3328px;">
                            {{ $jobs->description }}</p>

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
