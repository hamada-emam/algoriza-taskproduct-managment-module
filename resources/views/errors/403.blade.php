<!-- resources/views/unauthorized.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
        }

        .error-container {
            max-width: 500px;
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #dc3545;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #6c757d;
        }

        .btn-primary {
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="error-container text-center">
        <h1>403</h1>
        <h3>Unauthorized</h3>
        <p>Sorry, you don't have permission to view this page.</p>
        <a href="{{ route('guest.products') }}" class="btn btn-primary">Back to Homepage</a>
    </div>
</body>

</html>
