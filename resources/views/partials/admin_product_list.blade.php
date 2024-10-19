<div class="container-fluid p-0"> <!-- Use container-fluid to take full width and remove padding -->
    <div class="table-responsive">
        <table class="table custom-table text-center mb-0 table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Tags</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $page = request()->get('page');
                    $index = $page ? ($page - 1) * 9 : 0;
                @endphp
                @foreach ($products as $product)
                    <tr onclick="handleRowClick('{{ route('products.edit', $product->id) }}')" style="cursor: pointer;">
                        <td class="text-left">
                            <span class="text-dark-blue font-weight-30">{{ $index + 1 }}</span>
                        </td>
                        @php
                            $index++;
                        @endphp
                        <td>
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 40px; height: auto;">
                        </td>
                        <td class="align-middle">
                            <span class="text-dark-blue font-weight-500">{{ $product->code }}</span>
                        </td>
                        <td class="align-middle">
                            <span class="text-dark-blue font-weight-500">{{ $product->name }}</span>
                        </td>
                        <td class="align-middle">
                            <span class="text-primary font-weight-bold">${{ number_format($product->price, 2) }}</span>
                        </td>
                        <td class="align-middle">
                            <span class="text-dark-blue font-weight-500">{{ $product->description }}</span>
                        </td>
                        <td class="align-middle">
                            @if ($product->active)
                                <span class="font-weight-500 badge badge-primary">active</span>
                            @else
                                <span class="font-weight-500 badge badge-danger">inactive</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <span class="text-dark-blue font-weight-500">{{ $product->category?->name }}</span>
                        </td>
                        <td>
                            @foreach (explode(' ', $product->tags) as $tag)
                                <span class="badge badge-info rounded-pill">{{ trim($tag) }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function handleRowClick(url) {
        window.location.href = url; // Redirect to the generated edit URL
    }
</script>
