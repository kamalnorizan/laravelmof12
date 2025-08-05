@extends('layouts.materio')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" name="invoiceFrm" id="invoiceFrm" action="{{ route('invoices.store') }}" class="form-horizontal">
             @csrf
            <div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }} mt-3">
                <label for="customer_name">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}"  class="form-control" required="required" placeholder="Placeholder">
                <small class="text-danger">{{ $errors->first('customer_name') }}</small>
            </div>
            <div class="form-group {{ $errors->has('customer_email') ? 'has-error' : '' }} mt-3">
                <label for="customer_email">Customer Email</label>
                <input type="text" id="customer_email" name="customer_email" value="{{ old('customer_email') }}"  class="form-control" required="required" placeholder="Placeholder">
                <small class="text-danger">{{ $errors->first('customer_email') }}</small>
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }} mt-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="unpaid">Unpaid</option>
                    <option value="paid">Paid</option>
                </select>
                <small class="text-danger">{{ $errors->first('status') }}</small>
            </div>
            <div class="btn-group float-right mt-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button type="submit" class="btn btn-success">Add</button>
            </div>

        </form>
    </div>
</div>

@endsection
