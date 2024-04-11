<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        //get users with pagination
        $users = DB::table('users')
        ->where(function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('address', 'like', '%' . $keyword . '%')
                  ->orWhere('note_address', 'like', '%' . $keyword . '%')
                  ->orWhere('phone', 'like', '%' . $keyword . '%')
                  ->orWhere('radius', 'like', '%' . $keyword . '%')
                  ->orWhere('latitude_user', 'like', '%' . $keyword . '%')
                  ->orWhere('longitude_user', 'like', '%' . $keyword . '%');
        })
        ->paginate(5);
        return view('pages.user.index', ['users' => $users, 'keyword' => $keyword]);
    }

    //show
    public function show($id)
    {
        return view('pages.dashboard');
    }

    //edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    //update
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);
        //check if password is not empty
        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        } else {
            //if password is empty, then use the old password
            $data['password'] = $user->password;
        }
        $user->update($data);
        return redirect()->route('user.index');
    }

    //destroy
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }
}
