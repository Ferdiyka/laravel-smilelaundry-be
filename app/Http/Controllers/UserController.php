<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function destroy($id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Cari semua pesanan (orders) yang dibuat oleh pengguna ini
        $orders = Order::where('user_id', $user->id)->get();

        // Hapus semua detail pesanan yang terkait dengan setiap pesanan
        foreach ($orders as $order) {
            // Hapus semua detail pesanan terkait
            $order->orderDetails()->delete();
            // Hapus pesanan itu sendiri
            $order->delete();
        }

        // Sekarang pengguna dapat dihapus karena tidak ada pesanan yang terkait lagi
        $user->delete();

        // Redirect kembali ke halaman daftar pengguna
        return redirect()->route('user.index');
    }
}
