<?php
header("HTTP/1.0 404 Not Found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <!-- Bootstrap 5 CSS -->
    <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .error-page {
            text-align: center;
            padding: 40px 0;
        }
        .error-code {
            font-size: 150px;
            font-weight: bold;
            color: #0d6efd;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            font-family: 'Arial Black', sans-serif;
        }
        .error-message {
            font-size: 24px;
            color: #6c757d;
            margin: 20px 0;
        }
        .error-description {
            color: #495057;
            margin-bottom: 30px;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .back-home {
            transition: transform 0.3s ease;
        }
        .back-home:hover {
            transform: scale(1.02);
        }
        .btn {
            padding-top: 4px;
            padding-bottom: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 error-page">

            <div class="error-code">404</div>
            <h1 class="error-message">Oops! Page Not Found</h1>
            <p class="error-description">
                The page you're looking for might have been removed, had its name changed,<br>
                or is temporarily unavailable.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-primary btn-lg back-home">
                    <i class="bi bi-house-door"></i> Back to Home
                </a>
                <button onclick="history.back()" class="btn btn-outline-secondary btn-lg back-home">
                    <i class="bi bi-arrow-left"></i> Go Back
                </button>
            </div>

            <div class="mt-4 text-muted">
                <small>Error Code: 404 | Page Not Found</small>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap 5 JS Bundle -->
</body>
</html>
