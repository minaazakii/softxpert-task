<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Wrong Email Or Password'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'user' => new UserResource(auth()->user()),
            'token' => auth()->user()->createToken('authToken')->plainTextToken
        ]);
    }
}
