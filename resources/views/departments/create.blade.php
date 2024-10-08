@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Department</h4>

            </div>
            <div class="card-body p-4">

                <form action="{{ $data == null ? route('departments.store') : route('departments.update',$data->id) }}" method="POST">
                    @csrf
                        {{ $data != null ? method_field('PUT') : '' }}                        
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Department Name</label>
                                <input class="form-control" name="name" type="text" value="{{ $data == null ? old('name') : $data->name }}" id="name" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <textarea name="desc" id="desc" cols="30" rows="10" class="form-control" required>{{ $data == null ? old('desc') : $data->desc }}</textarea>
                            </div>
                        </div>   
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }}
                                Department</button>
                        </div>          
                </form>

            </div>
        </div>
    </div>
</div>
@endsection