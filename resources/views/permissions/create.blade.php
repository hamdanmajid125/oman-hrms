@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} {{ $title }}</h4>

                </div>
                <div class="card-body p-4">

                    <form action="{{ $data == null ? route('permissions.store') : route('permissions.update', $data->id) }}"
                        method="POST">
                        @csrf
                        {{ $data != null ? method_field('PUT') : '' }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Permission Name</label>
                                    <input class="form-control" name="name" type="text"
                                        value="{{ $data == null ? old('name') : $data->name }}" id="name">
                                </div>
                            </div>

                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }}
                                {{ $title }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div> <!-- end col -->
    </div>
@endsection
