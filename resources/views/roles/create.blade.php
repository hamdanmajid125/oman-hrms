@extends('layouts.dashboard')
@section('page_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} {{ $title }}</h4>

                </div>
                <div class="card-body p-4">

                    <form action="{{ $data == null ? route('roles.store') : route('roles.update', $data->id) }}" method="POST">
                        @csrf
                        {{ $data != null ? method_field('PUT') : '' }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input class="form-control" name="name" type="text"
                                        value="{{ $data == null ? old('name') : $data->name }}" id="name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="row">
                                        @forelse ($permissions as $key => $item)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="permissions[]" type="checkbox" id="permission_{{ $key }}" {{ $data ? ($data->hasPermissionTo($item->name) ? 'checked' : '') : '' }}
                                                        value="{{ $item->name }}" id="flexCheckDefault">
                                                    <label class="form-check-label" for="permission_{{ $key }}">
                                                        {{ ucwords($item->name) }}
                                                    </label>
                                                </div>


                                            </div>
                                        @empty
                                            <p>No permission found</p>
                                        @endforelse


                                    </div>

                                </div>
                            </div>
                        </div>

                </div>
                <div class="text-center">
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
