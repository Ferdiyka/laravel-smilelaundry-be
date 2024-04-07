<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
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
        $data = collect([]);

        foreach ($this->orders as $order) {
            foreach ($order->orderDetails as $key => $item) {
                $rowData = [
                    'Id' => $key === 0 ? $order->id : '',
                    'User Name' => $key === 0 ? $order->user->name : '',
                    'Address' => $key === 0 ? $order->user->address : '',
                    'Note Address' => $key === 0 ? $order->user->note_address : '',
                    'Order Date' => $key === 0 ? $order->order_date : '',
                    'Order Status' => $key === 0 ? $order->order_status : '',
                    'Payment Status' => $key === 0 ? $order->payment_status : '',
                    'Jasa' => $item->product->name,
                    'Price' => 'Rp ' . number_format($item->product->price, 0, ',', '.'),
                    'Jumlah' => in_array($item->product->name, ['Reguler', 'Express']) ? $item->quantity . ' Kg' : $item->quantity,
                    'Sub Total' => 'Rp ' . number_format($item->product->price * $item->quantity, 0, ',', '.'),
                    'Total' => $key === 0 ? 'Rp ' . number_format($order->orderDetails->sum(function ($detail) {
                        return $detail->product->price * $detail->quantity;
                    }), 0, ',', '.') : '',
                ];

                $data->push($rowData);
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id', 'User Name', 'Address', 'Note Address',  'Order Date', 'Order Status', 'Payment Status', 'Jasa', 'Price', 'Jumlah', 'Sub Total', 'Total',
        ];
    }
}
