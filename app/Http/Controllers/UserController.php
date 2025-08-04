<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Display a listing of users
    }

    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }
}
