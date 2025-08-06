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

    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="userOffcanvas"
        aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">
                Offcanvas
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="userForm">
                @csrf
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="_method" id="method" value="POST">

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"  class="form-control" required="required" placeholder="Enter name">
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} mt-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control"
                        required="required">
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                </div>
                <hr>
                <h4>Roles</h4>
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $role }}"
                            id="role_{{ $role }}" name="roles[]"
                            {{ in_array($role, old('roles', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role_{{ $role }}">
                            {{ ucfirst($role) }}
                        </label>
                    </div>
                @endforeach
                <h4>Permissions</h4>
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $permission }}"
                            id="permission_{{ str_replace(' ', '_', $permission) }}" name="permissions[]"
                            {{ in_array($permission, old('permissions', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission_{{ str_replace(' ', '_', $permission) }}">
                            {{ ucfirst($permission) }}
                        </label>
                    </div>
                @endforeach
                <button type="button" id="saveUserBtn" class="btn btn-primary waves-effect mt-4 float-end">Save
                    changes</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/users.js'])
@endpush
