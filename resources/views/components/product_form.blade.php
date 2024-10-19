<div class="">
    <div class="row mb-4 sticky-header">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-dark-blue">{{ $mode === 'create' ? 'Create Product' : 'Update Product' }}</h2>
                <p class="text-muted">
                    {{ $mode === 'create' ? 'Fill in the details below to create a new product.' : 'Update the details below for the product.' }}
                </p>
            </div>

            @if ($mode === 'update' && Auth::user()->hasPermission('delete-products'))
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmationModal">
                    Delete Product
                </button>
            @endif
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ $mode === 'create' ? route('products.store') : route('products.update', $product->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($mode === 'update')
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $product->id }}">
                        @endif

                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $product->name ?? '') }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="code">Product Code</label>
                            <input type="text" name="code" id="code"
                                value="{{ old('code', $product->code ?? '') }}"
                                class="form-control @error('code') is-invalid @enderror">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="4">{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Price ($)</label>
                            <input type="number" name="price" id="price"
                                value="{{ old('price', $product->price ?? '') }}"
                                class="form-control @error('price') is-invalid @enderror" step="0.01" min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags (Space separated)</label>
                            <input type="text" name="tags" id="tags"
                                value="{{ old('tags', $product->tags ?? '') }}"
                                class="form-control @error('tags') is-invalid @enderror">
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image" class="font-weight-bold">Product Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" id="image"
                                        class="custom-file-input @error('image') is-invalid @enderror" accept="image/*">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-secondary" id="imageIcon"
                                        style="display:none;" onclick="showImage()">
                                        <i class="fas fa-image"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span id="imageName" class="text-muted"></span>
                                @if ($mode === 'update' && $product->image)
                                    <div>
                                        <strong>Current Image:</strong>
                                        <img src="{{ asset($product->image) }}" alt="Current Product Image"
                                            class="img-fluid mt-2" style="max-width: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">-- Select a category (optional) --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-2">
                                <div class="mt-2">
                                    <span class="text-muted">Active</span>
                                    <label class="switch">
                                        <input type="hidden" name="active" value="0">
                                        <input type="checkbox" name="active" value="1"
                                            {{ old('active', $product->active ?? 0) == '1' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-10 text-right">
                                <button type="submit"
                                    class="btn btn-primary">{{ $mode === 'create' ? 'Create Product' : 'Update Product' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for larger image preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="#" alt="Large Image Preview" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    @if ($mode === 'update')
        <!-- Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product? This action cannot be undone.
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form id="deleteForm" action="{{ route('products.delete', $product->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        document.getElementById("image").addEventListener("change", function(event) {
            const imageIcon = document.getElementById("imageIcon");
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageIcon.style.display = "inline-block";
                    document.getElementById("modalImage").src = e.target.result; // Set modal image source
                    document.getElementById("imageName").textContent = file.name; // Set file name
                }
                reader.readAsDataURL(file);
            } else {
                imageIcon.style.display = "none";
                document.getElementById("imageName").textContent = ''; // Clear the file name
            }
        });

        function showImage() {
            $('#imageModal').modal('show');
        }

        $(document).on('click', function(event) {
            const target = $(event.target);
            if (!target.closest('#imageModal').length && !target.is('#imageIcon')) {
                $('#imageModal').modal('hide');
            }
        });
    </script>

</div>
