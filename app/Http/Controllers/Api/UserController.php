<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan pengguna yang saat ini sedang login
        $user = Auth::user();

        // Mengambil data pengguna yang login
        return response()->json([
            'message' => 'Success',
            'data' => $user
        ], 200);
    }

    public function updateAddress(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'note_address' => 'nullable',
            'radius' => 'nullable',
            'latitude_user' => 'nullable',
            'longitude_user' => 'nullable',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($validatedData);

        return response()->json([
            'message' => 'User address updated successfully',
            'data' => $user
        ], 200);
    }
}
