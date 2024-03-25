@extends('layouts.app')

@section('title', 'Edit Order')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Order</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></div>
                    <div class="breadcrumb-item active">Edit Order</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('order.update', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @foreach ($order->orderDetails as $item)
                                <div class="form-group">
                                    <input type="hidden" name="order_detail[{{ $item->id }}][id]"
                                        value="{{ $item->id }}">
                                    <label>Product: {{ $item->product->name }}</label>
                                    <input type="number" class="form-control"
                                        name="order_detail[{{ $item->id }}][quantity]" required
                                        value="{{ $item->quantity }}">
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label>Order Status</label>
                                <input type="text" class="form-control" name="order_status" required
                                    value="{{ $order->order_status }}">
                            </div>
                            <div class="form-group">
                                <label>Payment Status</label>
                                <input type="text" class="form-control" name="payment_status" required
                                    value="{{ $order->payment_status }}">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
