@extends('layouts.materio')

@section('title', 'Users Management')

@section('head')

@endsection

@section('content')
    <h1>Users Management</h1>

    <div class="card">

        <div class="card-body">
            <table class="table" id="userTbl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles/Permission</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/users.js'])
@endpush
