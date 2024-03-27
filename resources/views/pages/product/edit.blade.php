@extends('layouts.app')

@section('title', 'Edit Product')

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
                <h1>Edit Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></div>
                    <div class="breadcrumb-item active">Edit Product</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" required
                                    class="form-control @error('name')
                                is-invalid
                            @enderror"
                                    name="name" value="{{ $product->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" required value="{{ $product->price }}">
                            </div>
                            <div class="form-group">
                                <label>Duration</label>
                                <input type="number" class="form-control" name="duration" required value="{{ $product->duration }}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" data-height="150" name="description" required>{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Note</label>
                                <textarea type="text" class="form-control" data-height="150" name="note">{{ $product->note }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Previous Photo Product</label>
                                <div>
                                    @if ($product->picture)
                                        <img src="{{ asset('storage/products/' . $product->picture) }}" alt="{{ $product->name }}" class="img-thumbnail mb-2" style="max-width: 200px;">
                                    @endif
                                    <input type="file" class="form-control" name="picture">
                                </div>
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
