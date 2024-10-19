@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <!-- Sidebar for filters -->

        <!-- Main Content -->
        <div class="col-md-12">
            <div class="row mb-4 mt-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="text-dark-blue">Products</h2>
                    @if (Auth::user()->hasPermission('create-products'))
                        <div>
                            <button class="btn btn-primary mr-2" onclick="exportProducts()">Export</button>
                            <button class="btn btn-success" onclick="window.location='{{ route('products.create') }}'">Add
                                New</button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Search Bar -->
            {{-- @include('partials.search_bare', ['products' => $products]) --}}

            <!-- Search form -->
            <form id="search-form" method="GET" action="{{ route('products.list') }}">
                <div class="form-row align-items-center">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control mb-2"
                            placeholder=" Name, description, tags, or code" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="categoryId" class="form-control mb-2">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('categoryId') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="price" class="form-control mb-2" placeholder="Min Price"
                            value="{{ request('price') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="tags" class="form-control mb-2" placeholder="Tags"
                            value="{{ request('tags') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="active" class="form-control mb-2">
                            <option value="">All Products</option>
                            <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </div>
                </div>
            </form>

            <!-- Products Grid -->
            <div class="row" id="products-container">
                @include('partials.admin_product_list', ['products' => $products])
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
