@extends('layouts.dashboard')
@section('page_content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $data == null ? 'Create' : 'Update' }} Tax</h4>

            </div>
            <div class="card-body p-4">

                <form action="{{ $data == null ? route('taxes.store') : route('taxes.update',$data->id) }}" method="POST">
                    @csrf
                    {{ $data != null ? method_field('PUT') : '' }}                        
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="from" class="form-label">From</label>
                                <input class="form-control" name="from" type="text" value="{{ $data == null ? old('from') : $data->from }}" id="from" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="to" class="form-label">To</label>
                            <input type="text" name="to" id="to" value="{{ $data == null ? old('to') : $data->to }}" class="form-control" required>
                        </div>

                        <div class="col-lg-6">
                            <label for="tax_percent" class="form-label">Tax Percent</label>
                            <input type="text" name="tax_percent" id="tax_percent" value="{{ $data == null ? old('tax_percent') : $data->tax_percent }}" class="form-control" required>
                        </div>

                        <div class="col-lg-6">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="amount" name="amount" id="amount" value="{{ $data == null ? old('amount') : $data->amount }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">{{ $data == null ? 'Create' : 'Update' }}
                            Tax</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection