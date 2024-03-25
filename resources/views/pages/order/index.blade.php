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
                <h1>Order</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Order</div>
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
                                <div class="float-right">
                                    <form method="GET" action="{{ route('order.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="keyword">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Order Id</th>
                                            <th>User Name</th>
                                            <th>Address</th>
                                            <th>Note Address</th>
                                            <th>Jasa</th>
                                            <th>Quantity</th>
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
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->user->address }}</td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->user->note_address }}</td>
                                                        @endif
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        @if ($key == 0)
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->order_date }}</td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->order_status }}</td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                {{ $order->payment_status }}</td>
                                                            <td rowspan="{{ count($order->orderDetails) }}">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href='{{ route('order.edit', $order->id) }}'
                                                                        class="btn btn-sm btn-info btn-icon">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>

                                                                    <form action="{{ route('order.destroy', $order->id) }}"
                                                                        method="POST" class="ml-2">
                                                                        <input type="hidden" name="_method"
                                                                            value="DELETE" />
                                                                        <input type="hidden" name="_token"
                                                                            value="{{ csrf_token() }}" />
                                                                        <button
                                                                            class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
