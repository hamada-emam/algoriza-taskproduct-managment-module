<!-- resources/views/partials/product_list.blade.php -->
@if ($products->count())
    @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 product-card">
                <div class="card-img-container">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                    <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                    <a href="{{ route('guest.product', $product->id) }}" class="btn btn-outline-primary">View
                        Product</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-12">
        <p>No products found.</p>
    </div>
@endif
