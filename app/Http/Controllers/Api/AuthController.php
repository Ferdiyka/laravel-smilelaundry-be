<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required'
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'roles' => 'USER'
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'user' => UserResource::make($user),
            ]);
        } catch (ValidationException $e) {
            // Handle validation errors
            $errorMessage = 'The given data was invalid.';
            if ($e->errors()['email'][0] === 'The email has already been taken.') {
                $errorMessage = 'Email already exists.';
            }

            return response($errorMessage, 422);
        }
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
            return response('User not found', 401);
        }

        // //cek password nya bener ato ga
        // if (!Hash::check($validated['password'], $user->password)) {
        //     return response('Wrong Password', 401);
        // }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 200);
    }

    //update fcm id
    public function updateFcmId(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'fcm_id' => 'required',
        ]);

        $user = $request->user();
        $user->fcm_id = $validated['fcm_id'];
        $user->save();

        return response()->json([
            'message' => 'FCM ID updated',
        ], 200);
    }

}
