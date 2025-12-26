<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH . "includes/init.php");
require_once __DIR__ . '/includes/functions.php';

// Set proper HTTP status code
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - <?php echo e($system->get_setting("site_name")); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error-page {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        .error-content {
            max-width: 600px;
        }
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #667eea;
            line-height: 1;
            margin-bottom: 1rem;
        }
        .error-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }
        .error-message {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="/"><?php echo e($system->get_setting("site_name")); ?></a></h1>
        </div>
    </header>

    <main class="error-page">
        <div class="error-content">
            <div class="error-code">404</div>
            <h2 class="error-title">Page Not Found</h2>
            <p class="error-message">
                Sorry, the page you're looking for doesn't exist or has been moved.
            </p>
            <div class="error-actions">
                <a href="/" class="btn btn-primary">Go to Homepage</a>
                <a href="/admin" class="btn btn-secondary">Admin Panel</a>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo e($system->get_setting("site_name")); ?>. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
