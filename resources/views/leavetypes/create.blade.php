@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Leave Type</h4>

            </div>
            <div class="card-body p-4">

                <form action="{{ $data == null ? route('leavetypes.store') : route('leavetypes.update',$data->id) }}" method="POST">
                    @csrf
                        {{ $data != null ? method_field('PUT') : '' }}                        
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Leave Type Name</label>
                                <input class="form-control" name="name" type="text" value="{{ $data == null ? old('name') : $data->name }}" id="name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="desc" class="form-label">Days</label>
                                <input type="text" name="days" value="{{ $data == null ? old('days') : $data->days }}" class="form-control">
                            </div>
                        </div>   
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }}
                                Leave Type</button>
                        </div>          
                </form>

            </div>
        </div>
    </div>
</div>
@endsection