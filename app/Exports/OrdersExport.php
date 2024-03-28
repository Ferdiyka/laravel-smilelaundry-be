<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->orders->flatMap(function ($order) {
            $totalPrice = 0;
            return $order->orderDetails->map(function ($orderDetail) use ($order, &$totalPrice) {
                $price = $orderDetail->product->price;
                $subtotal = $price * $orderDetail->quantity;
                $totalPrice += $subtotal;
                return [
                    'id' => $order->id,
                    'user_name' => $order->user->name,
                    'address' => $order->user->address,
                    'note_address' => $order->user->note_address,
                    'jasa' => $orderDetail->product->name,
                    'quantity' => $orderDetail->product->name === 'Reguler' || $orderDetail->product->name === 'Express' ? $orderDetail->quantity . ' Kg' : $orderDetail->quantity,
                    'price' => 'Rp ' . number_format($price, 0, ',', '.'),
                    'subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                    'order_status' => $order->order_status,
                    'payment_status' => $order->payment_status,
                    'order_date' => $order->order_date,
                ];
            })->push([
                'id' => '', // empty cell for spacing
                'user_name' => '',
                'address' => '',
                'note_address' => '',
                'jasa' => '',
                'quantity' => '',
                'price' => '',
                'subtotal' => 'Total : Rp ' . number_format($totalPrice, 0, ',', '.'),
                'order_status' => '',
                'payment_status' => '',
                'order_date' => '',
            ]);
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            'User Name',
            'Address',
            'Note Address',
            'Jasa',
            'Jumlah',
            'Price',
            'Subtotal',
            'Order Status',
            'Payment Status',
            'Order Date',
        ];
    }
}
