<?php
require_once __DIR__ . '/../includes/functions.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('index.php');
}

// Check for remember token
if (isset($_COOKIE['remember_token']) && !isLoggedIn()) {
    $user = validateRememberToken($_COOKIE['remember_token']);
    if ($user) {
        startUserSession($user);
        redirect('index.php');
    } else {
        // Invalid or expired token, delete it
        setcookie('remember_token', '', time() - 3600, '/');
    }
}

$errors = [];
$username = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    $ip_address = getClientIP();

    // Check for rate limiting
    if (checkLoginAttempts($ip_address)) {
        $errors[] = 'Too many login attempts. Please try again in 15 minutes.';
    } else {
        // Validation
        if (empty($username)) {
            $errors[] = 'Username is required';
        }
        if (empty($password)) {
            $errors[] = 'Password is required';
        }

        if (empty($errors)) {
            // Attempt authentication
            $user = authenticateUser($username, $password);

            if ($user) {
                // Clear login attempts on successful login
                clearLoginAttempts($ip_address);

                // Start session
                startUserSession($user);

                // Handle "Remember Me"
                if ($remember) {
                    $token = createRememberToken($user['id']);
                    // Set cookie for 30 days
                    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
                }

                // Clean up old data
                cleanupOldLoginAttempts();
                cleanupExpiredTokens();

                // Redirect to admin panel
                redirect('index.php');
            } else {
                // Record failed attempt
                recordLoginAttempt($ip_address, $username);
                $errors[] = 'Invalid username or password';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo e(SITE_NAME); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h1>Admin Login</h1>
            <p class="login-subtitle"><?php echo e(SITE_NAME); ?></p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo e($username); ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group checkbox-group">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        Remember me for 30 days
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                </div>
            </form>

            <div class="login-footer">
                <a href="../index.php">&larr; Back to Blog</a>
            </div>
        </div>
    </div>
</body>
</html>
