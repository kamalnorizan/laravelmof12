<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\UserRegisteredNotification;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::pluck('name');
        $permissions = Permission::orderBy('id')->pluck('name');
        return view('users.index', compact('roles', 'permissions'));
    }

    public function ajaxLoadUsers(Request $request)
    {
        $user = User::query();

        if ($request->has('roles') && !empty($request->roles)) {
            $user->whereHas('roles', function ($query) use ($request) {
                $query->whereIn('name', $request->roles);
            });
        }

        if ($request->has('permissions') && !empty($request->permissions)) {
            $user->whereHas('permissions', function ($query) use ($request) {
                $query->whereIn('name', $request->permissions);
            });
        }

        return DataTables::of($user)
            ->addColumn('role', function ($row) {
                $roles = '';
                foreach ($row->getRoleNames() as $role) {
                    $roles .= '<span class="badge bg-info">' . ucfirst($role) . '</span> ';
                }

                foreach ($row->getPermissionNames() as $permission) {
                    $roles .= '<span class="badge bg-success">' . ucfirst($permission) . '</span> ';
                }
                return $roles;
            })
            ->addColumn('action', function ($row) {
                $buttons = '';
                if (auth()->user()->can('edit user')) {
                    $buttons .= '<button class="btn btn-sm btn-primary waves-effect edit" data-id="' . $row->uuid . '">Edit</button>';
                }
                if (auth()->user()->can('delete user')) {
                    $buttons .= ' <button class="btn btn-sm btn-danger waves-effect delete" data-id="' . $row->uuid . '">Delete</button>';
                }
                return $buttons;
            })
            ->rawColumns(['action', 'role'])
            ->make(true);
    }

    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return response()->json([
            'user' => $user->load(['roles', 'permissions'])
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return response()->json(['message' => 'User updated successfully']);
    }

    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $password = Str::random(10);
        $user->password = Hash::make($password);
        $user->uuid = Uuid::uuid4();
        $user->save();

        $user->notify(new UserRegisteredNotification($user, $password));

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }



        return response()->json(['message' => 'User updated successfully']);
    }

}

