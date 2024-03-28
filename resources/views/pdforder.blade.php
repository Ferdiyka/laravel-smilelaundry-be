<!DOCTYPE html>
<html>
<head>
    <title>Order #{{ $order->id }}</title>
    <style>
        /* Add some basic styles for the PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Order #{{ $order->id }}</h1>
    <p><strong>Customer:</strong> {{ $order->user->name }}</p>
    <p><strong>Address:</strong> {{ $order->user->address }}</p>
    <p><strong>Note Address:</strong> {{ $order->user->note_address }}</p>
    <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
    <p><strong>Order Status:</strong> {{ $order->order_status }}</p>
    <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>

    <h2>Order Details</h2>
    <table>
        <thead>
            <tr>
                <th>Jasa</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>
                        @if (in_array($item->product->name, ['Reguler', 'Express']))
                            {{ $item->quantity }} Kg
                        @else
                            {{ $item->quantity }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
