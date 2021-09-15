<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || \Hash::check($request->password, $request->password)) {
            return response()->json([
                'status'    => 0,
                'message'   => "failed",
            ], 401);
        }

        $token = $user->createToken('token', ['server:update'])->plainTextToken;

        return response()->json([
            'status'    => 1,
            'message'   => "success",
            'user'      => $user,
            'token'     => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'    => 1,
            'message'   => "success",
            'user'      => $user
        ], 200);
    }
}
