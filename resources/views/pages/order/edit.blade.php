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

                            <div class="form-group">
                                <label>Order Status</label>
                                <select class="form-control" id="orderStatus" name="order_status">
                                    <option value="Menunggu Konfirmasi"
                                        {{ $order->order_status === 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                        Menunggu Konfirmasi</option>
                                    <option value="Picking Up"
                                        {{ $order->order_status === 'Picking Up' ? 'selected' : '' }}>
                                        Picking Up</option>
                                    <option value="Processing"
                                        {{ $order->order_status === 'Processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="Shipping" {{ $order->order_status === 'Shipping' ? 'selected' : '' }}>
                                        Shipping</option>
                                    <option value="Delivered" {{ $order->order_status === 'Delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Payment Status</label>
                                <select class="form-control" id="paymentStatus" name="payment_status">
                                    <option value="Pending" {{ $order->payment_status === 'Pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="Paid" {{ $order->payment_status === 'Paid' ? 'selected' : '' }}>
                                        Paid</option>
                                    <option value="Unpaid" {{ $order->payment_status === 'Unpaid' ? 'selected' : '' }}>
                                        Unpaid</option>
                                </select>
                            </div>
                            {{-- Input Field Quantity --}}
                            <div class="form-group" id="quantitySection">
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
                            </div>
                            @push('scripts')
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var orderStatusDropdown = document.getElementById('orderStatus');
                                        var quantitySection = document.getElementById('quantitySection');

                                        // Sembunyikan Input Field Quantity secara default
                                        quantitySection.style.display = 'none';

                                        // Tambahkan fungsi untuk menampilkan Input Field Quantity berdasarkan status pesanan
                                        function showHideQuantityField() {
                                            var selectedStatus = orderStatusDropdown.value;

                                            // Jika status adalah 'Menunggu Konfirmasi' atau 'Picking Up', sembunyikan Input Field Quantity
                                            if (selectedStatus === 'Menunggu Konfirmasi' || selectedStatus === 'Picking Up') {
                                                quantitySection.style.display = 'none';
                                            } else {
                                                // Jika status bukan 'Menunggu Konfirmasi' atau 'Picking Up', tampilkan Input Field Quantity
                                                quantitySection.style.display = 'block';
                                            }
                                        }

                                        // Panggil fungsi untuk menampilkan Input Field Quantity saat halaman dimuat
                                        showHideQuantityField();

                                        // Tambahkan event listener untuk mendengarkan perubahan pada dropdown
                                        orderStatusDropdown.addEventListener('change', function() {
                                            // Panggil kembali fungsi untuk menampilkan Input Field Quantity saat dropdown berubah
                                            showHideQuantityField();
                                        });
                                    });
                                </script>
                            @endpush

                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('order.index') }}" class="btn btn-secondary mr-2">Cancel</a>
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
