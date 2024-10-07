@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Shift</h4>

            </div>
            <div class="card-body p-4">

                <form action="{{ $data == null ? route('shifts.store') : route('shifts.update',$data->id) }}" method="POST">
                    @csrf
                    {{ $data != null ? method_field('PUT') : '' }}                        
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Shift Name</label>
                                <input class="form-control" name="name" type="text" value="{{ $data == null ? old('name') : $data->name }}" id="name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="starting_time" class="form-label">Starting Time</label>
                            <input type="time" value="{{ $data == null ? old('starting_time') : $data->starting_time }}" name="starting_time" class="form-control">
                        </div>

                        <div class="col-lg-4">
                            <label for="ending_time" class="form-label">Ending Time</label>
                            <input type="time" value="{{ $data == null ? old('ending_time') : $data->ending_time }}" name="ending_time" class="form-control">
                        </div>

                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }}
                            Shift</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection