@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Leave Request Form</h4>

            </div>
            <div class="card-body p-4">

                <form action="{{ route('leaves.appliedLeave') }}" method="POST">
                    @csrf                      
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input class="form-control" name="start_date" type="date" id="start_date" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>

                        <div class="col-lg-6">
                            <label for="halfday" class="form-label">Half Day</label>
                                <select name="half_day" id="halfday" class="form-select">
                                    <option selected hidden>Select Half Day</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="type" class="form-label">Leave Type</label>
                            <select name="type" id="type" class="form-select" required>
                                <option selected hidden>Select Leave Type</option>
                                @foreach ($leaveType as $items)
                                    <option value="{{ $items->id }}">{{ $items->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea name="reason" id="reason" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">Create Leave</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection