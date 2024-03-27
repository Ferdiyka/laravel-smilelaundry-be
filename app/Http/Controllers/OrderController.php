<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        //get orders with pagination
        $orders = Order::with('user')
        ->where(function ($query) use ($keyword) {
            $query
                  ->orWhereHas('user', function ($query) use ($keyword) {
                      $query->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('address', 'like', '%' . $keyword . '%')
                            ->orWhere('note_address', 'like', '%' . $keyword . '%');
                  });
        })
        ->paginate(5);
        return view('pages.order.index', ['orders' => $orders, 'keyword' => $keyword]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('pages.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
{
    // Validasi data yang diterima dari form
    $request->validate([
        'order_status' => 'required',
        'payment_status' => 'required',
        'order_detail' => 'required|array', // pastikan order_detail berupa array
        'order_detail.*.id' => 'required|exists:order_detail,id', // pastikan setiap order detail ID valid
        'order_detail.*.quantity' => 'required|integer|min:1', // pastikan setiap quantity merupakan angka positif
    ]);

    // Mengambil data order berdasarkan ID
    $order = Order::findOrFail($id);

    // Mengupdate status order dan status pembayaran
    $order->update([
        'order_status' => $request->input('order_status'),
        'payment_status' => $request->input('payment_status'),
    ]);

    // Mengupdate quantity produk
    foreach ($request->input('order_detail') as $item) {
        $orderDetail = OrderDetail::findOrFail($item['id']);
        $orderDetail->update(['quantity' => $item['quantity']]);
    }

    // Redirect kembali ke halaman atau route yang diinginkan
    return redirect()->route('order.index')->with('success', 'Order updated successfully');
}

public function updateStatus(Request $request, Order $order)
{
    $order->update([
        'order_status' => $request->input('order_status'),
    ]);

    return redirect()->route('order.index')->with('success', 'Order status updated successfully.');
}

public function updatePaymentStatus(Request $request, Order $order)
{
    $order->update([
        'payment_status' => $request->input('payment_status'),
    ]);

    return redirect()->route('order.index')->with('success', 'Payment status updated successfully.');
}

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('order.index')->with('success', 'Product deleted successfully');
    }

    public function exportOrders()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }
}
