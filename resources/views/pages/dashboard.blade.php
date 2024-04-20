@extends('layouts.app')

@section('title', 'Ecommerce Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/flag-icon-css/css/flag-icon.min.css') }}">
@endpush

@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {{-- Order Status --}}
                    <div class="card card-statistic-2">
                        <div class="card-stats pb-5">
                            <div class="text-center font-size-lg mb-5 mt-4">
                                <strong>Order Status</strong>
                            </div>
                            <div class="card-stats-items">
                                @foreach ($orderStatuses as $status => $label)
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-label mb-3">{{ $label }}</div>
                                        <div class="card-stats-item-count">
                                            <a href="{{ route('order.index') }}">
                                                {{ $orders->where('order_status', $status)->count() }} </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- Payment Status --}}
                    <div class="card card-statistic-2">
                        <div class="card-stats pb-5">
                            <div class="text-center font-size-lg mb-5 mt-4">
                                <strong>Payment Status</strong>
                            </div>
                            <div class="card-stats-items">
                                @foreach ($paymentStatuses as $status => $label)
                                    <div class="card-stats-item"></div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-label mb-3">{{ $label }}</div>
                                        <div class="card-stats-item-count">
                                            <a href="{{ route('order.index') }}">
                                                {{ $orders->where('payment_status', $status)->count() }} </a>
                                        </div>
                                    </div>
                                    <div class="card-stats-item"></div>
                                @endforeach
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
    <script src="{{ asset('library/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.js') }}"></script>
    <script src="{{ asset('library/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index.js') }}"></script>
@endpush
