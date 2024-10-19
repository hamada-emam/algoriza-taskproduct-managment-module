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
                            <button class="btn btn-primary mr-2" onclick="showExportConfirmation()">Export</button>
                            <button class="btn btn-success" onclick="window.location='{{ route('products.create') }}'">Add
                                New</button>
                        </div>
                    @endif
                </div>
            </div>
            <div id="notification-area"></div>

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
                        <input type="number" name="price" class="form-control mb-2" placeholder="Price"
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

    <!-- Confirmation Modal -->
    <div class="modal fade" id="exportConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="exportConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportConfirmationModalLabel">Confirm Export</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to export the products with the current filters?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmExportButton">Confirm Export</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showExportConfirmation() {
            $('#exportConfirmationModal').modal('show');
        }

        document.getElementById('confirmExportButton').addEventListener('click', function() {
            exportProducts();
        });

        function exportProducts() {
            const formData = new FormData(document.getElementById('search-form'));

            fetch('{{ route('products.export') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        $('#exportConfirmationModal').modal('hide');
                        showSuccessMessage();
                        return response.json();
                    } else {
                        return response.json().then(err => {
                            throw new Error(err.message);
                        });
                    }
                })
                .then(data => {
                    // Close the modal
                    $('#exportConfirmationModal').modal('hide');

                    // Show success message with the download link
                    const successMessage = `
            <div class="alert alert-success">
                ${data.message} <br>
                <a href="${data.download_link}" target="_blank">Click here to download the file</a>
            </div>
        `;
                    document.getElementById('notification-area').innerHTML = successMessage;
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                    showErrorMessage(error.message);
                });
        }

        function showSuccessMessage() {
            // Display a success message to the user
            const successMessage = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Export started successfully! You will receive an email with a link to download the Excel file once it's ready.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

            document.getElementById('notification-area').innerHTML = successMessage;
        }

        function showErrorMessage(message) {
            const errorMessage = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                There was a problem with the export: ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

            document.getElementById('notification-area').innerHTML = errorMessage;
        }
    </script>
@endsection
