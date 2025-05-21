<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Summary of register
     * @param \App\Http\Requests\Auth\StoreUserRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\LoginUserRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $request->validated();

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    /**
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

}
