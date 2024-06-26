<!DOCTYPE html>
<html>

<head>
    <title>Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('images/Logo.png') }}" class="w-1/2 mx-auto rounded-full" alt="">
    </div>
    <h1>Order Details</h1>
    <table>
        <tr>
            <td><strong>Order ID:</strong></td>
            <td>{{ $order->id }}</td>
        </tr>
        <tr>
            <td><strong>User Name:</strong></td>
            <td>{{ $order->user->name }}</td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td>{{ $order->user->address }}</td>
        </tr>
        <tr>
            <td><strong>Note Address:</strong></td>
            <td>{{ $order->user->note_address }}</td>
        </tr>
        <tr>
            <td><strong>Order Date:</strong></td>
            <td>{{ $order->order_date }}</td>
        </tr>
        <tr>
            <td><strong>Order Status:</strong></td>
            <td>{{ $order->order_status }}</td>
        </tr>
        <tr>
            <td><strong>Payment Status:</strong></td>
            <td>{{ $order->payment_status }}</td>
        </tr>
        <tr>
            <td rowspan="{{ count($order->orderDetails) }}"><strong>Jasa</strong></td>
            <td>
                @php
                    $totalPrice = 0;
                    $first = true;
                    $prevProductName = '';
                @endphp
                @foreach ($order->orderDetails as $item)
                    @if ($prevProductName !== $item->product->name)
                        @if (!$first)
                            </td></tr><tr><td>
                        @else
                            @php
                                $first = false;
                            @endphp
                        @endif
                        <strong>{{ $item->product->name }}</strong> x {{ number_format($item->product->price, 0, ',', '.') }} x
                        @if (in_array($item->product->name, ['Reguler', 'Express']))
                            {{ $item->quantity }} Kg
                        @else
                            {{ $item->quantity }}
                        @endif
                        @php
                            $prevProductName = $item->product->name;
                            $totalPrice += $item->product->price * $item->quantity;
                        @endphp
                    @else
                        <br>
                        @if (in_array($item->product->name, ['Reguler', 'Express']))
                            {{ $item->quantity }} Kg
                        @else
                            {{ $item->quantity }}
                        @endif
                        @php
                            $totalPrice += $item->product->price * $item->quantity;
                        @endphp
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <td><strong>Total Price:</strong></td>
            <td>Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
            {{-- <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td> --}}
        </tr>
    </table>


    <!-- Tambahkan info lainnya sesuai kebutuhan -->

    <div class="footer">
        &copy; {{ date('Y') }} Smile Laundry
    </div>
</body>

</html>
