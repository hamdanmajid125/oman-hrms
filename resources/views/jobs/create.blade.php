@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Job</h4>

                </div>
                <div class="card-body p-4">

                    <form action="{{ $data == null ? route('jobs.store') : route('jobs.update', $data->id) }}" method="POST">
                        @csrf
                        {{ $data != null ? method_field('PUT') : '' }}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="job_title" class="form-label">Job Title</label>
                                    <input class="form-control" name="job_title" placeholder="Enter Job Title"
                                        type="text" value="{{ $data == null ? old('job_title') : $data->job_title }}"
                                        id="name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date"
                                        value="{{ $data == null ? old('start_date') : \Carbon\Carbon::createFromTimestamp($data->start_date)->toDateString() }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date"
                                        value="{{ $data == null ? old('end_date') : \Carbon\Carbon::createFromTimestamp($data->end_date)->toDateString() }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="branch" class="form-label">Branch</label>
                                <select name="branch" id="branch" class="form-select">
                                    <option selected hidden>Select Branch</option>
                                    <option value="all" {{ $data != null && $data->branch == 'all' ? 'selected' : '' }}>
                                        All</option>
                                    <option value="oman" {{ $data != null && $data->branch == 'oman' ? 'selected' : '' }}>
                                        Oman</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="positions" class="form-label">No. of Position</label>
                                <input type="text" name="no_of_position" placeholder="Enter No. of Position"
                                    value="{{ $data == null ? old('no_of_position') : $data->no_of_position }}"
                                    class="form-control" required>
                            </div>

                            <div class="col-lg-6">
                                <label for="department" class="form-label">Department</label>
                                <select name="depart_id" id="department" class="form-select">
                                    <option selected hidden>Select Department</option>
                                    @foreach ($dept as $items)
                                        <option value="{{ $items->id }}"
                                            {{ $data != null && $data->depart_id == $items->id ? 'selected' : '' }}>
                                            {{ $items->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="skills" class="form-label">Skills</label>
                                <input type="text" name="skills"
                                    placeholder='Enter Job Skills e.g "Data Analysis", "Communication"'
                                    value="{{ $data == null ? old('skills') : $data->skills }}" class="form-control">
                            </div>

                            <div class="col-lg-6">
                                <label for="shift" class="form-label">Shift</label>
                                <select name="shift_id" id="shift" class="form-select">
                                    <option selected hidden>Select Shift</option>
                                    @foreach ($shift as $items)
                                        <option value="{{ $items->id }}"
                                            {{ $data != null && $data->shift_id == $items->id ? 'selected' : '' }}>
                                            {{ $items->name }} ({{ $items->timing }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-12">
                                <label for="description" class="form-label">Job Description</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="10" required>{{ $data == null ? old('description') : $data->description }}</textarea>
                            </div>

                            <div class="col-lg-12">
                                <label for="requirement" class="form-label">Job Requirement</label>
                                <textarea name="requirement" id="requirement" class="form-control" cols="30" rows="10" required>{{ $data == null ? old('requirement') : $data->requirement }}</textarea>
                            </div>

                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }}
                                    Job</button>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
