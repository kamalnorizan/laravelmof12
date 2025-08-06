<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::all()
        ]);
    }

    public function ajaxloadusers(Request $request) {
        $users = User::query();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '';
            })
            ->make(true);
    }

    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }
}
