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

        // Check if product_id 1 is ordered more than once
        if ($productQuantities->get(11, 0) > 1) {
            throw ValidationException::withMessages([
                'items' => 'You cannot order product Paket Reguler more than once.',
            ]);
        }

        // Check if product_id 2 is ordered more than once
        if ($productQuantities->get(12, 0) > 1) {
            throw ValidationException::withMessages([
                'items' => 'You cannot order product Paket Express more than once.',
            ]);
        }

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
}
