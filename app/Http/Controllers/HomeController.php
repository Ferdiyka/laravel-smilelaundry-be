<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')->get();


        $orderStatuses = $this->getOrderStatuses();
        $paymentStatuses = $this->getPaymentStatuses();

        return view('pages.dashboard', [
            'orders' => $orders,
            'orderStatuses' => $orderStatuses,
            'paymentStatuses' => $paymentStatuses,
        ]);
    }

    protected function getOrderStatuses()
    {
        // Retrieve the order statuses from the database or a configuration file
        return [
            'Pending' => 'Pending',
            'Picking Up' => 'Picking Up',
            'Processing' => 'Processing',
            'Shipping' => 'Shipping',
            'Delivered' => 'Delivered',
        ];
    }

    protected function getPaymentStatuses()
    {
        // Retrieve the payment statuses from the database or a configuration file
        return [
            'Pending' => 'Pending',
            'Paid' => 'Paid',
            'Unpaid' => 'Unpaid',
        ];
    }
}
