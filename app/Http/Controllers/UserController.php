<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function fetchUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        return response()->json(['user' => $user]);
    }
}
