@extends('layouts.app')

@section('content')
    <!-- Header Section -->
    <header class="header-section py-3 mb-4 bg-light">
        <div class="container">
            <h1 class="text-center">Product Details</h1>
        </div>
    </header>

    <div class="container">
        <!-- Back to Products Link -->
        <div class="row mt-3 mb-4">
            <div class="col-12">
                <a href="{{ route('guest.products') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>

        <!-- Product Details -->
        <div class="row">
            <!-- Image Section -->
            <div class="col-md-6">
                <div class="product-image-wrapper">
                    <img src="{{ $product->image }}" class="img-fluid product-image zoom" alt="{{ $product->name }}">
                </div>
            </div>

            <!-- Product Info Section -->
            <div class="col-md-6">
                <div class="product-details">
                    <h1 class="product-name">{{ $product->name }}</h1>
                    <p class="product-category"><strong>Category:</strong> {{ $product->category->name }}</p>
                    <p class="product-price"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>

                    <div class="description mt-4">
                        <h5>Description</h5>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="tags mt-4">
                        <h5>Tags</h5>
                        <p>{{ $product->tags }}</p>
                    </div>

                    <div class="code mt-4">
                        <h5>Product Code</h5>
                        <p>{{ $product->code }}</p>
                    </div>

                    <!-- Disabled Purchase Button -->
                    <button class="btn btn-primary mt-4" disabled>Login to Purchase</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-image-wrapper {
            overflow: hidden;
            /* Hide overflow for zoom effect */
            position: relative;
        }

        .product-image {
            transition: transform 0.3s ease;
            /* Smooth transition for zoom effect */
        }

        .product-image.zoom:hover {
            transform: scale(1.1);
            /* Zoom in effect */
        }
    </style>
@endsection
