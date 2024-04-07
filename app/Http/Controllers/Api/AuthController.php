<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|unique:users|max:50',
            'password' => 'required',
        ]);

        // Tambahkan default 'USER' ke roles
        $validated['roles'] = 'USER';

        //password encryption
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout success',
        ], 200);
    }

    public function login(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        //cek email
        $user = User::where('email', $validated['email'])->first();

        //cek user nya ada ato ga
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        //cek password nya bener ato ga
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid password'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 200);
    }

}
