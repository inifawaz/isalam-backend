<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginPostRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'email atau password anda salah'
            ], 401);
        }

        return response()->json([
            'user' => new UserResource(auth()->user()),
            'token' => auth()->user()->createToken('token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Berhasil Logout'
        ]);
    }

    public function me(Request $request)
    {
        $user = new UserResource($request->user());
        return response([
            'user' => $user
        ]);
    }

    public function register(RegisterPostRequest $request)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $user->assignRole('user');
        return response([
            'user' => new UserResource($user),
            'token' => $user->createToken('token')->plainTextToken
        ], 201);
    }
}
