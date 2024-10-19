<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/product-styles.css') }}">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-lg">
            <a class="navbar-brand" href="{{ route('guest.products') }}">Product Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::guest())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.form') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Register</a>
                        </li>
                    @endif
                    @if (Auth::check())
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="nav-link" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-lg mt-4">
        @yield('content')
        @include('partials.loading_spinner')
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.category-filter').on('click', function(e) {
                e.preventDefault();
                const categoryId = $(this).data('id');
                const search = $('input[name="search"]').val();

                $.ajax({
                    url: '{{ route('guest.products') }}',
                    type: 'GET',
                    data: {
                        categoryId: categoryId,
                        search: search
                    },
                    beforeSend: function() {
                        $('#loading-spinner').show();
                    },
                    success: function(data) {
                        $('#products-container').html(data);
                    },
                    complete: function() {
                        $('#loading-spinner').hide();
                    },
                    error: function(xhr) {
                        console.error("AJAX request failed: ", xhr.responseText);
                    }
                });
            });

            $('.toggle-icon').on('click', function() {
                const targetId = $(this).data('target');
                $(targetId).collapse('toggle');

                const $icon = $(this).find('i');
                $icon.toggleClass('fa-chevron-down fa-chevron-up');
            });

            $('#search-form').on('submit', function(e) {
                e.preventDefault();

                const search = $('input[name="search"]').val();
                const categoryId = $('.category-filter.active').data(
                    'id');

                $.ajax({
                    url: '{{ route('guest.products') }}',
                    type: 'GET',
                    data: {
                        search: search,
                        categoryId: categoryId
                    },
                    beforeSend: function() {
                        $('#loading-spinner').show();
                    },
                    success: function(data) {
                        $('#products-container').html(data); // Load the filtered products
                    },
                    complete: function() {
                        $('#loading-spinner').hide(); // Hide the loading spinner
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Log any errors
                        $('#loading-spinner').hide(); // Hide the loading spinner on error
                    }
                });
            });
        });
    </script>
</body>

</html>
