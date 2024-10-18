@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Sidebar for Categories -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Categories</h5>
                </div>

                <ul class="list-group list-group-flush">
                    @foreach ($categories as $category)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Parent Category Link -->
                                <a href="#" class="text-decoration-none text-dark category-filter"
                                    data-id="{{ $category->id }}">
                                    {{ $category->name }}
                                </a>
                                @if ($category->children->isNotEmpty())
                                    <span class="toggle-icon" data-target="#categoryCollapse{{ $category->id }}">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                @endif
                            </div>

                            <!-- Collapsible Child Categories -->
                            @if ($category->children->isNotEmpty())
                                <div class="collapse" id="categoryCollapse{{ $category->id }}">
                                    <ul class="list-group list-group-flush mt-2">
                                        @foreach ($category->children as $childCategory)
                                            <li class="list-group-item">
                                                <a href="#" class="text-decoration-none text-dark category-filter"
                                                    data-id="{{ $childCategory->id }}">
                                                    {{ $childCategory->name }}
                                                </a>

                                                <!-- Recursively display sub-categories -->
                                                @if ($childCategory->children->isNotEmpty())
                                                    @include('categories.partials.child_category', [
                                                        'category' => $childCategory,
                                                    ])
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Search Bar -->
            <form id="search-form" class="mb-4">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control" placeholder="Search products..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <!-- Products Grid -->
            <div class="row" id="products-container">
                @include('partials.product_list', ['products' => $products])
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
