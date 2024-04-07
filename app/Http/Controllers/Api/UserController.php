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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari pengguna
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'note_address' => 'nullable',
            'radius' => 'nullable',
            'latitude_user' => 'nullable',
            'longitude_user' => 'nullable',
        ]);

        // Buat pengguna baru berdasarkan data yang divalidasi
        $user = User::create($validatedData);

        // Berikan respons yang sesuai
        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
