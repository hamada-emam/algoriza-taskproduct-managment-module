<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Top Navbar -->
            @include('partials.dashboard_nav', [])

            <!-- Sidebar -->
            @include('partials.dashboard_sidebare', [])

            <!-- Main content -->
            <main role="main" class="main-content">
                <div class="container-fluid mt-16"> <!-- Change to container-fluid -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @include('partials.loading_spinner')

    <!-- Use full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            document.getElementById('sidebarToggle').onclick = function() {
                var sidebar = document.getElementById('sidebar');
                var mainContent = document.querySelector('.main-content');
                sidebar.classList.toggle('visible');

                if (sidebar.classList.contains('visible')) {
                    mainContent.classList.add('full-width');
                } else {
                    mainContent.classList.remove('full-width');
                }
            };
        });

        // Handle search filter
        $('#search-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Collect all form data
            const formData = {
                search: $('input[name="search"]').val(),
                categoryId: $('select[name="categoryId"]').val(),
                price: $('input[name="price"]').val(),
                tags: $('input[name="tags"]').val(),
                active: $('select[name="active"]').val(), // Get the value of the active/inactive dropdown
            };

            $.ajax({
                url: '{{ route('products.list') }}',
                type: 'GET',
                data: formData, // Send the collected data
                beforeSend: function() {
                    $('#loading-spinner').show(); // Show the loading spinner
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
    </script>
</body>

</html>
