<!-- resources/views/unauthorized.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container text-center mt-5">
        <h1>403 - Unauthorized</h1>
        <p>You do not have permission to access this page.</p>
        <a href="{{ route('guest.products') }}" class="btn btn-primary">Go to Homepage</a>
    </div>
</body>

</html>
