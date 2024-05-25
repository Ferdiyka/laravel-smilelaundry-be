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
                    <div class="breadcrumb-item active">Orders / Order</div>
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

                                <div class="clearfix mb-4"></div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Id</th>
                                            <th>User Name</th>
                                            <th>Address</th>
                                            <th>Note Address</th>
                                            <th>Jasa</th>
                                            <th>Jumlah</th>
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
                                                        <td>
                                                            @if ((stripos($item->product->name, 'Paket') !== false) && ($order->order_status === 'Menunggu Konfirmasi' || $order->order_status === 'Picking Up'))
                                                                <strong class="truncated-address" data-toggle="tooltip" title="Anda harus mengupdate beratnya">? Kg</strong>
                                                            @else
                                                                {{ $item->quantity }}
                                                                {{ stripos($item->product->name, 'Paket') !== false ? 'Kg' : 'Pcs' }}
                                                            @endif
                                                        </td>

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
                                                                </div>
                                                            </td>
                                                        @endif

                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <p>No orders found.</p>
                                        @endif

                                        <!-- Order Status Modal
                                        @foreach ($orders as $order)
                                            <div class="modal fade" id="orderStatusModal-{{ $order->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="orderStatusModalLabel-{{ $order->id }}"
                                                aria-hidden="true" data-backdrop="false" data-keyboard="false">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" style="margin-top: 5px"
                                                                id="orderStatusModalLabel-{{ $order->id }}">Update
                                                                Order
                                                                Status</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('order.updateStatus', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <select class="form-control" id="orderStatus"
                                                                        name="order_status">
                                                                        <option value="Menunggu Konfirmasi"
                                                                            {{ $order->order_status === 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                                                            Menunggu Konfirmasi</option>
                                                                        <option value="Picking Up"
                                                                            {{ $order->order_status === 'Picking Up' ? 'selected' : '' }}>
                                                                            Picking Up</option>
                                                                        <option value="Processing"
                                                                            {{ $order->order_status === 'Processing' ? 'selected' : '' }}>
                                                                            Processing</option>
                                                                        <option value="Shipping"
                                                                            {{ $order->order_status === 'Shipping' ? 'selected' : '' }}>
                                                                            Shipping</option>
                                                                        <option value="Delivered"
                                                                            {{ $order->order_status === 'Delivered' ? 'selected' : '' }}>
                                                                            Delivered</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    -->

                                        <!-- Payment Status Modal
                                        @foreach ($orders as $order)
                                            <div class="modal fade" id="paymentStatusModal-{{ $order->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="paymentStatusModalLabel-{{ $order->id }}"
                                                aria-hidden="true" data-backdrop="false" data-keyboard="false">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="paymentStatusModalLabel-{{ $order->id }}">Update
                                                                Payment Status</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('order.updatePaymentStatus', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <select class="form-control" id="paymentStatus"
                                                                        name="payment_status">
                                                                        <option value="Paid"
                                                                            {{ $order->payment_status === 'Paid' ? 'selected' : '' }}>
                                                                            Paid</option>
                                                                        <option value="Unpaid"
                                                                            {{ $order->payment_status === 'Unpaid' ? 'selected' : '' }}>
                                                                            Unpaid</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach -->
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

        // Fungsi untuk menyegarkan isi tabel dengan AJAX
        function refreshTableContent() {
            $.ajax({
                url: "{{ route('order.index') }}", // Ganti dengan URL yang sesuai untuk mendapatkan data tabel
                method: "GET",
                success: function(data) {
                    // Ganti konten tabel dengan data yang baru
                    $('.table-responsive').html($(data).find('.table-responsive').html());
                }
            });
        }

        // Panggil fungsi refreshTableContent setiap 3 detik
        setInterval(refreshTableContent, 3000); // 3000 milidetik = 3 detik
    </script>
@endpush

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
