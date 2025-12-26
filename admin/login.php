<?php
define("ROOT_PATH", "../");

require_once(ROOT_PATH ."includes/init.php");
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
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if (!validateCSRFToken($csrf_token)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    $ip_address = getClientIP();

    // Check for rate limiting
    if (checkLoginAttempts($ip_address)) {
        $errors[] = 'Too many login attempts. Please try again in 15 minutes.';
    } elseif (empty($errors)) {
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

echo $template->render('pages/login.php', [
    'errors' => $errors,
    'username' => $username,
    'csrf_token' => getCSRFToken()
]);
