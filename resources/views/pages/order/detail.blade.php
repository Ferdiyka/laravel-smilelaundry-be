@extends('layouts.app')

@section('title', 'Order')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order Detail</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Orders / Order Detail</div>
                </div>
            </div>
            <div class="section-body">
                {{-- <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div> --}}


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-left">
                                    <form method="GET" action="{{ route('orders.export') }}" class="form-inline">
                                        <div class="form-group mr-2">
                                            <label for="start_date" class="mr-1">Start Date:</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                required value="{{ request()->get('start_date') }}">
                                        </div>
                                        <div class="form-group mr-2">
                                            <label for="end_date" class="mr-1">End Date:</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                required value="{{ request()->get('end_date') }}">
                                        </div>
                                        <div class="form-group mr-2">
                                            <button type="submit" class="btn btn-primary mr-1">
                                                <i class="fas fa-download"></i> Excel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('order.detail') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="keyword">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-4"></div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Id</th>
                                            <th>User Name</th>
                                            <th>Address</th>
                                            <th>Note Address</th>
                                            <th>Jasa</th>
                                            <th>Price</th>
                                            <th>Jumlah</th>
                                            <th>Sub Total</th>
                                            <th>Total</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @if ($orders !== null)
                                            @foreach ($orders as $order)
                                                @foreach ($order->orderDetails as $key => $item)
                                                    <tr>
                                                        @if ($key == 0)
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->id }}</td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->user->name }}</td>
                                                            <td rowspan="{{ count($order->orderDetails) }}"
                                                                class="truncated-address" data-toggle="tooltip"
                                                                title="{{ $order->user->address }}">
                                                                {{ strlen($order->user->address) > 20 ? substr($order->user->address, 0, 20) . '...' : $order->user->address }}
                                                            </td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->user->note_address }}</td>
                                                        @endif
                                                        @php
                                                            $totalSubtotal = 0;
                                                        @endphp
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ number_format($item->product->price, 0, ',', '.') }}</td>
                                                        <td>
                                                            @if ((in_array($item->product->id, [11, 12]) && $order->order_status === 'Menunggu Konfirmasi') ||
                                                            $order->order_status === 'Picking Up')
                                                            <strong class="truncated-address" data-toggle="tooltip" title="Anda harus mengupdate beratnya">? Kg</strong>
                                                            @else
                                                                {{ $item->quantity }}
                                                                {{ in_array($item->product->id, [11, 12]) ? 'Kg' : 'Pcs' }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                        </td>
                                                        @if ($key == 0)
                                                            <!-- Calculate and render total for each order only once -->
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ number_format(
                                                                    $order->orderDetails->sum(function ($detail) {
                                                                        return $detail->product->price * $detail->quantity;
                                                                    }),
                                                                    0,
                                                                    ',',
                                                                    '.',
                                                                ) }}
                                                            </td>
                                                        @endif

                                                        @if ($key == 0)
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->order_date }}</td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->order_status }}
                                                            </td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->payment_status }}
                                                            </td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                <div class="d-flex justify-content-center">
                                                                    <form action="{{ route('order.destroy', $order->id) }}"
                                                                        method="POST" class="ml-2"
                                                                        onsubmit="return confirmDelete()">
                                                                        <input type="hidden" name="_method"
                                                                            value="DELETE" />
                                                                        <input type="hidden" name="_token"
                                                                            value="{{ csrf_token() }}" />
                                                                        <button
                                                                            class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>

                                                                    <a href="{{ route('order.downloadPDF', $order->id) }}"
                                                                        class="btn btn-sm btn-primary btn-icon ml-2"
                                                                        target="_blank">
                                                                        <i class="fas fa-file-pdf"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        @endif

                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <p>No orders found.</p>
                                        @endif
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $orders->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi untuk menampilkan pesan konfirmasi sebelum menghapus
        function confirmDelete() {
            return confirm('Are you sure you want to delete this item?');
        }
    </script>
@endpush

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
