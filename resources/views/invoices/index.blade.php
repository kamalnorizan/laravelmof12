@extends('layouts.materio')

@section('content')
    <h1>Invoices</h1>
    <p>List of all invoices will be displayed here.</p>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Recent Invoices</h5>
        </div>
        <div class="card-body">
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
