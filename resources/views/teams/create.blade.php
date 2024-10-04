@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Teams</h4>

            </div>
            <div class="card-body p-4">

                <form action="{{ $data == null ? route('teams.store') : route('teams.update',$data->id) }}" method="POST">
                    @csrf
                    {{ $data != null ? method_field('PUT') : '' }}                        
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Team Name</label>
                                <input class="form-control" name="name" type="text" value="{{ $data == null ? old('name') : $data->name }}" id="name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="team_lead" class="form-label">Team Lead</label>
                            <select name="leader_id" id="team_lead" class="form-select">
                                <option selected hidden>Select Team Lead</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $data != null && $data->leader_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="department" class="form-label">Department</label>
                            <select name="department_id" id="department" class="form-select">
                                <option selected hidden>Select Department</option>
                                @foreach ($dept as $items)
                                    <option value="{{ $items->id }}" {{ $data != null && $data->department_id == $items->id ? 'selected' : '' }}>{{ $items->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }}
                            Team</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection