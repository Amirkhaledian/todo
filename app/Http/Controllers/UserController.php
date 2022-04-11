<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Label;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function register(UserRequest $request)
    {
        $inputs = $request->all();
        $inputs['password'] = Hash::make($inputs['password']);
        $inputs['token'] = Str::random(80);

        $user = User::create($inputs);
        Auth::attempt($request->only('email', 'password'));

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['status' => 'ok', 'data' => auth()->user()]);
        }

        return response()->json(['status' => 'failed', 'message' => 'your email or password is invalid']);
    }
}
