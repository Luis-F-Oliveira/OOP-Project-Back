<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255'
            ]);
            
            if (Auth::attempt($validated)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                $cookie = cookie('jwt', $token, 60 * 24);

                return response()->json([
                    'token' => $token,
                    'user' => $user
                ])->withCookie($cookie);
            }

            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
               'message' => 'Logged out successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
