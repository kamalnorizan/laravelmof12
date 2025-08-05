@extends('layouts.materio')

@section('content')
    <h1>Invoices</h1>
    <p>List of all invoices will be displayed here.</p>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Recent Invoices</h5>
        </div>
        <div class="card-body">
            {{-- <div class="row">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('tahun') ? 'has-error' : '' }}">
                        <label for="tahun">Tahun</label>
                        <select id="tahun" name="tahun" class="form-control mySelect" required multiple>
                            @for ($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <small class="text-danger">{{ $errors->first('tahun') }}</small>
                    </div>
                </div>
            </div> --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div></div>


@endsection

@push('scripts')
    <script>
        // window.addEventListener('DOMContentLoaded', function() {
        //     $('.mySelect').select2();
        // });
        // document.addEventListener('DOMContentLoaded', function() {
        //     // $('#tahun').select2({
        //     //     placeholder: 'Select Year',
        //     //     allowClear: true
        //     // });
        // });
    </script>
@endpush
