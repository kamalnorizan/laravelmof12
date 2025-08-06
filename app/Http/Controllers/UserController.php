<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserUpdateRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::pluck('name');
        $permissions = Permission::pluck('name');
        return view('users.index', compact('roles', 'permissions'));
    }

    public function ajaxloadusers(Request $request)
    {
        $users = User::query();

        return DataTables::of($users)
            ->addColumn('rolepermissions', function ($user) {
                $roles = '';
                foreach ($user->getRoleNames() as $role) {
                    $roles .= ' <span class="badge bg-label-success me-1">' . ucfirst($role) . '</span>';
                }

                foreach ($user->getDirectPermissions() as $permission) {
                    $roles .= ' <span class="badge bg-label-info me-1">' . ucfirst($permission->name) . '</span>';
                }
                return $roles;
            })
            ->addColumn('action', function ($user) {
                $buttons = '';

                if (Auth::user()->can('edit users')) {
                    $buttons .= '<button class="btn btn-sm btn-primary edit" data-id="' . $user->uuid . '">Edit</button>';
                }

                if (Auth::user()->can('delete users')) {
                    $buttons .= ' <button class="btn btn-sm btn-danger delete" data-id="' . $user->uuid . '">Delete</button>';
                }

                return $buttons;
            })
            ->rawColumns(['rolepermissions', 'action'])
            ->make(true);
    }

    public function edit(User $user)
    {
        return response()->json([
            'user' => $user->load(['roles', 'permissions']),
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        return response()->json([
            'user' => $user
        ]);
    }
}
