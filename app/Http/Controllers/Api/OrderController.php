<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    // function for order
    public function order(Request $request)
    {
        // Validate the request
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $productQuantities = collect($request->items)->groupBy('product_id')->map->sum('quantity');

        // Create order
        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_date' => Carbon::now()->format('Y-m-d'),
            'order_status' => 'Pending',
            'payment_status' => 'Pending',
        ]);

        // create order items
        foreach ($request->items as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        // return response
        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ]);

    }
    // function for get all order by user
    public function getOrderByUser(Request $request)
    {
        // Mengambil semua order detail yang terhubung dengan pesanan milik user yang sedang login
        $orderDetails = OrderDetail::with('product')
                                    ->whereHas('order', function($query) use ($request) {
                                        $query->where('user_id', $request->user()->id);
                                    })
                                    ->get();

        // Mengelompokkan order detail berdasarkan order_id
        $groupedOrderDetails = $orderDetails->groupBy('order_id');

        // Mengumpulkan data pesanan beserta informasi produk yang dipesan
        $ordersWithProducts = [];
        foreach ($groupedOrderDetails as $orderId => $orderDetails) {
            $order = Order::find($orderId);
            $products = $orderDetails->map(function ($detail) {
                return [
                    'id' => $detail->product->id,
                    'name' => $detail->product->name,
                    'price' => $detail->product->price,
                    'quantity' => $detail->quantity,
                ];
            });

            $ordersWithProducts[] = [
                'order' => $order,
                'products' => $products,
            ];
        }

        // Mengurutkan data pesanan dari yang terbaru hingga yang terlama
        $ordersWithProducts = collect($ordersWithProducts)->sortByDesc(function ($order) {
            return $order['order']->created_at; // Ubah 'created_at' sesuai dengan nama kolom tanggal pesanan
        })->values()->all();

        return response()->json([
            'orders' => $ordersWithProducts,
        ]);
    }

}
