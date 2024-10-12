@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <div class="mb-4">
                                    <a
                                        href="{{ $detail->profile ? asset($detail->profile) : asset('images/no-image.png') }}"><img
                                            src="{{ $detail->profile ? asset($detail->profile) : asset('images/no-image.png') }}"
                                            alt="" height="24"></a><span
                                        class="logo-txt">{{ $detail->name }}</span>
                                </div>
                            </div>
                        </div>


                        <p class="mb-1">{{ ucwords($detail->gender) }}</p>
                        <p class="mb-1"><i class="mdi mdi-email align-middle me-1"></i>{{ $detail->email }}</p>
                        <p><i class="mdi mdi-phone align-middle me-1"></i>{{ $detail->phone }}</p>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <h5 class="font-size-15 mb-3">See Resume:</h5>
                                <a href="{{ asset($detail->resume) }}" class="btn btn-primary" target="blank">Click
                                    Here</a>
                            </div>
                        </div>
                    </div>

                    <div class="py-2 mt-3">
                        <h5 class="font-size-15">Additional Details</h5>
                    </div>
                    <div class="p-4 border rounded">
                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Cover Letter</td>
                                        <td>{{ $detail->cover_letter }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Date of Birth</td>
                                        <td>{{ $detail->date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Why Do You Want to Work at This Company?</td>
                                        <td>{{ $detail->company }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Why Do You Want This Job?</td>
                                        <td>{{ $detail->job }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">What Do You Consider to Be Your Weaknesses?</td>
                                        <td>{{ $detail->weakness }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
