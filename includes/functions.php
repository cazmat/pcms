<?php
require_once __DIR__ . '/db.php';

/**
 * Get all published posts
 */
function getAllPosts($limit = null, $offset = 0) {
    $db = getDB();
    $sql = "SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC";

    if ($limit !== null) {
        $sql .= " LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
    } else {
        $stmt = $db->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $posts;
}

/**
 * Get all posts (including drafts) for admin
 */
function getAllPostsAdmin($limit = null, $offset = 0) {
    $db = getDB();
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";

    if ($limit !== null) {
        $sql .= " LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
    } else {
        $stmt = $db->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $posts;
}

/**
 * Get a single post by slug
 */
function getPostBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM posts WHERE slug = ? AND status = 'published' LIMIT 1");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    return $post;
}

/**
 * Get a single post by ID (for admin)
 */
function getPostById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    return $post;
}

/**
 * Create a new post
 */
function createPost($title, $slug, $content, $excerpt, $author, $status = 'draft') {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO posts (title, slug, content, excerpt, author, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param('ssssss', $title, $slug, $content, $excerpt, $author, $status);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Update an existing post
 */
function updatePost($id, $title, $slug, $content, $excerpt, $author, $status) {
    $db = getDB();
    $stmt = $db->prepare("
        UPDATE posts
        SET title = ?, slug = ?, content = ?,
            excerpt = ?, author = ?, status = ?
        WHERE id = ?
    ");
    $stmt->bind_param('ssssssi', $title, $slug, $content, $excerpt, $author, $status, $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Delete a post
 */
function deletePost($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Generate a URL-friendly slug from a string
 */
function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

/**
 * Format date for display
 */
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

/**
 * Sanitize HTML output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

// ============================================================================
// AUTHENTICATION FUNCTIONS
// ============================================================================

/**
 * Check if too many login attempts from this IP
 * Returns true if IP is rate limited
 */
function checkLoginAttempts($ip_address) {
    $db = getDB();

    // Check attempts in last 15 minutes
    $stmt = $db->prepare("
        SELECT COUNT(*) as attempt_count
        FROM login_attempts
        WHERE ip_address = ?
        AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
    ");
    $stmt->bind_param('s', $ip_address);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Allow max 5 attempts per 15 minutes
    return $row['attempt_count'] >= 5;
}

/**
 * Record a login attempt
 */
function recordLoginAttempt($ip_address, $username = null) {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO login_attempts (ip_address, username) VALUES (?, ?)");
    $stmt->bind_param('ss', $ip_address, $username);
    $stmt->execute();
    $stmt->close();
}

/**
 * Clear login attempts for an IP (called after successful login)
 */
function clearLoginAttempts($ip_address) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
    $stmt->bind_param('s', $ip_address);
    $stmt->execute();
    $stmt->close();
}

/**
 * Clean up old login attempts (older than 1 hour)
 */
function cleanupOldLoginAttempts() {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    $stmt->execute();
    $stmt->close();
}

/**
 * Authenticate user with username and password
 * Returns user array on success, false on failure
 */
function authenticateUser($username, $password) {
    $db = getDB();

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

/**
 * Create a remember token for a user
 * Returns the token string
 */
function createRememberToken($user_id) {
    $db = getDB();

    // Generate a random token
    $token = bin2hex(random_bytes(32));

    // Token expires in 30 days
    $expires_at = date('Y-m-d H:i:s', strtotime('+30 days'));

    $stmt = $db->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $user_id, $token, $expires_at);
    $stmt->execute();
    $stmt->close();

    return $token;
}

/**
 * Validate a remember token
 * Returns user array on success, false on failure
 */
function validateRememberToken($token) {
    $db = getDB();

    $stmt = $db->prepare("
        SELECT u.*
        FROM users u
        INNER JOIN remember_tokens rt ON u.id = rt.user_id
        WHERE rt.token = ? AND rt.expires_at > NOW()
        LIMIT 1
    ");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    return $user ? $user : false;
}

/**
 * Delete a remember token
 */
function deleteRememberToken($token) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM remember_tokens WHERE token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->close();
}

/**
 * Delete all remember tokens for a user
 */
function deleteAllRememberTokens($user_id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM remember_tokens WHERE user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->close();
}

/**
 * Clean up expired remember tokens
 */
function cleanupExpiredTokens() {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM remember_tokens WHERE expires_at < NOW()");
    $stmt->execute();
    $stmt->close();
}

/**
 * Start a user session
 */
function startUserSession($user) {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    // Store user data in session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['logged_in'] = true;
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Get current logged in user
 */
function getCurrentUser() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username']
        ];
    }

    return null;
}

/**
 * Require authentication - redirect to login if not logged in
 */
function requireAuth() {
    if (!isLoggedIn()) {
        redirect('../admin/login.php');
    }
}

/**
 * Logout user
 */
function logout() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Delete remember token if exists
    if (isset($_COOKIE['remember_token'])) {
        deleteRememberToken($_COOKIE['remember_token']);
        setcookie('remember_token', '', time() - 3600, '/');
    }

    // Destroy session
    $_SESSION = array();

    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    session_destroy();
}

/**
 * Get client IP address
 */
function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
