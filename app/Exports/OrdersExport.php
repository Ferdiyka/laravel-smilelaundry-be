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
        return $order->orderDetails->map(function ($orderDetail) use ($order) {
            return [
                'id' => $order->id,
                'user_name' => $order->user->name,
                'address' => $order->user->address,
                'note_address' => $order->user->note_address,
                'jasa' => $orderDetail->product->name,
                'quantity' => $orderDetail->product->name === 'Reguler' || $orderDetail->product->name === 'Express' ? $orderDetail->quantity . ' Kg' : $orderDetail->quantity,
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status,
                'order_date' => $order->order_date,
            ];
        });
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
            'Order Status',
            'Payment Status',
            'Order Date',
        ];
    }
}
