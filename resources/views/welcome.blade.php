@extends('front.layouts.app')
@section('content')
    <div class="job-wrapper">
        <div class="job-content">
            <nav class="navbar">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="https://demo.workdo.io/hrmgo-saas/storage/uploads/logo//logo-light.png?1728492354"
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
                    </div>
                </div>
            </section>
            <section class="placedjob-section">
                <div class="container">
                    <div class="section-title bg-light">

                        <h2 class="h1 mb-3"> <span class="text-primary">+4
                            </span>Job openings</h2>
                        <p>Always looking for better ways to do things, innovate <br>
                            and help people achieve their goals.</p>
                    </div>
                    <div class="row g-4">
                        @foreach ($jobs as $items)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 job-card">
                                <div class="job-card-body">
                                    <div class="d-flex mb-3 align-items-center justify-content-between ">
                                        <img src="https://demo.workdo.io/hrmgo-saas/storage/uploads/job/figma.png"
                                            alt="">
                                        <span>{{ ucwords($items->branch) }} <i class="ti ti-map-pin ms-1"></i></span>
                                    </div>
                                    <h5 class="mb-3">
                                        <a href="https://demo.workdo.io/hrmgo-saas/job/requirement/605ae87b0ef3a/en"
                                            class="text-dark">{{ $items->job_title }}</a>
                                    </h5>
                                    <div
                                        class="d-flex mb-3 align-items-start flex-column flex-xl-row flex-md-row flex-lg-column">
                                        <span class="d-inline-block me-2"> <i class="ti ti-circle-plus "></i>
                                            {{ $items->no_of_position }} position available</span>
                                    </div>

                                    <div class="d-flex flex-wrap gap-1 align-items-center">
                                        <span class="badge rounded  p-2 bg-primary">{{ $items->skills }}</span>
                                    </div>

                                    <a href="{{ route('job.Detail', $items->id) }}" class="btn btn-primary w-100 mt-4">Read
                                        more</a>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
