<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser;
use App\Http\Requests\LoginUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function addUser(CreateUser $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        return response()->json(['user' => $user], 200);
    }

    public function login(LoginUser $request)
    {
        $validated = $request->validated();
        // dd($request);
        if (auth()->guard('web')->attempt($validated)) {
            $user = auth()->guard('web')->user();
            // dd($user);
            $token = $user->createToken('JWT')->accessToken;
            return response()->json(['user' => $user, 'token' => $token], 200);
        } else {
            return response()->json(status: 400);
        }
    }
}
