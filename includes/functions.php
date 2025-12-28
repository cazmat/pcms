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
function createPost($title, $slug, $content, $excerpt, $author, $status = 'draft', $category_id = null) {
    $db = getDB();

    // If no category provided, use "Uncategorized"
    if ($category_id === null) {
        $uncategorized = getCategoryBySlug('uncategorized');
        $category_id = $uncategorized ? $uncategorized['id'] : null;
    }

    $stmt = $db->prepare("
        INSERT INTO posts (title, slug, content, excerpt, author, category_id, status)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param('sssssis', $title, $slug, $content, $excerpt, $author, $category_id, $status);
    $result = $stmt->execute();
    $insert_id = $db->insert_id;
    $stmt->close();

    return $result ? $insert_id : false;
}

/**
 * Update an existing post
 */
function updatePost($id, $title, $slug, $content, $excerpt, $author, $status, $category_id = null) {
    $db = getDB();

    // If no category provided, use "Uncategorized"
    if ($category_id === null) {
        $uncategorized = getCategoryBySlug('uncategorized');
        $category_id = $uncategorized ? $uncategorized['id'] : null;
    }

    $stmt = $db->prepare("
        UPDATE posts
        SET title = ?, slug = ?, content = ?,
            excerpt = ?, author = ?, category_id = ?, status = ?
        WHERE id = ?
    ");
    $stmt->bind_param('sssssisi', $title, $slug, $content, $excerpt, $author, $category_id, $status, $id);
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
 * Get total count of published posts
 */
function getTotalPublishedPosts() {
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE status = 'published'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return (int)$row['total'];
}

/**
 * Get total count of all posts (for admin)
 */
function getTotalPosts() {
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM posts");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return (int)$row['total'];
}

/**
 * Get total count of draft posts
 */
function getTotalDraftPosts() {
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE status = 'draft'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return (int)$row['total'];
}

/**
 * Generate pagination data
 *
 * @param int $current_page Current page number (1-indexed)
 * @param int $total_items Total number of items
 * @param int $per_page Items per page
 * @param string $base_url Base URL for pagination links
 * @return array Pagination data including pages, links, etc.
 */
function getPaginationData($current_page, $total_items, $per_page, $base_url = '') {
    // Calculate total pages
    $total_pages = max(1, ceil($total_items / $per_page));

    // Ensure current page is within valid range
    $current_page = max(1, min($current_page, $total_pages));

    // Calculate offset for database query
    $offset = ($current_page - 1) * $per_page;

    // Determine which page numbers to show
    $page_range = 2; // Show 2 pages before and after current page
    $start_page = max(1, $current_page - $page_range);
    $end_page = min($total_pages, $current_page + $page_range);

    return [
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'total_items' => $total_items,
        'per_page' => $per_page,
        'offset' => $offset,
        'has_prev' => $current_page > 1,
        'has_next' => $current_page < $total_pages,
        'prev_page' => $current_page - 1,
        'next_page' => $current_page + 1,
        'start_page' => $start_page,
        'end_page' => $end_page,
        'base_url' => $base_url,
        'show_first' => $start_page > 1,
        'show_last' => $end_page < $total_pages
    ];
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

// ============================================================================
// CSRF Protection Functions
// ============================================================================

/**
 * Generate a CSRF token and store it in the session
 */
function generateCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token from POST request
 */
function validateCSRFToken($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token (generate if not exists)
 */
function getCSRFToken() {
    return generateCSRFToken();
}

// ============================================================================
// Input Validation Functions
// ============================================================================

/**
 * Validate post title
 */
function validatePostTitle($title) {
    $errors = [];
    
    if (empty(trim($title))) {
        $errors[] = 'Title is required';
    } elseif (strlen($title) < 3) {
        $errors[] = 'Title must be at least 3 characters long';
    } elseif (strlen($title) > 200) {
        $errors[] = 'Title must not exceed 200 characters';
    }
    
    return $errors;
}

/**
 * Validate post content
 */
function validatePostContent($content) {
    $errors = [];
    
    if (empty(trim($content))) {
        $errors[] = 'Content is required';
    } elseif (strlen($content) < 10) {
        $errors[] = 'Content must be at least 10 characters long';
    } elseif (strlen($content) > 100000) {
        $errors[] = 'Content must not exceed 100,000 characters';
    }
    
    return $errors;
}

/**
 * Validate username
 */
function validateUsername($username) {
    $errors = [];
    
    if (empty(trim($username))) {
        $errors[] = 'Username is required';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Username must be at least 3 characters long';
    } elseif (strlen($username) > 50) {
        $errors[] = 'Username must not exceed 50 characters';
    } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
        $errors[] = 'Username can only contain letters, numbers, underscores, and hyphens';
    }
    
    return $errors;
}

/**
 * Validate excerpt
 */
function validateExcerpt($excerpt) {
    $errors = [];
    
    if (strlen($excerpt) > 500) {
        $errors[] = 'Excerpt must not exceed 500 characters';
    }
    
    return $errors;
}

/**
 * Validate author name
 */
function validateAuthor($author) {
    $errors = [];
    
    if (empty(trim($author))) {
        $errors[] = 'Author is required';
    } elseif (strlen($author) > 100) {
        $errors[] = 'Author name must not exceed 100 characters';
    }
    
    return $errors;
}

// ============================================================================
// Input Sanitization Functions (XSS Prevention)
// ============================================================================

/**
 * Sanitize HTML content - allows safe HTML tags for blog posts
 */
function sanitizeHTML($html) {
    // Allow these tags for blog post content
    $allowed_tags = '<p><br><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><blockquote><code><pre>';
    
    // Strip all tags except allowed ones
    $html = strip_tags($html, $allowed_tags);
    
    // Additional attribute filtering for allowed tags
    // This is a basic implementation - for production, consider using HTML Purifier library
    
    return $html;
}

/**
 * Sanitize plain text input (removes all HTML)
 */
function sanitizePlainText($text) {
    return strip_tags($text);
}

/**
 * Sanitize input for database (additional layer beyond prepared statements)
 */
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// ============================================================================
// Error Logging Functions
// ============================================================================

/**
 * Get the current environment (development or production)
 */
function getEnvironment() {
    static $environment = null;
    
    if ($environment === null) {
        // Load .env file
        $envFile = ROOT_PATH . '.env';
        if (file_exists($envFile)) {
            $envContent = parse_ini_file($envFile);
            $environment = $envContent['APP_ENV'] ?? 'production';
        } else {
            $environment = 'production'; // Default to production for safety
        }
    }
    
    return $environment;
}

/**
 * Check if we're in production environment
 */
function isProduction() {
    return getEnvironment() === 'production';
}

/**
 * Get the current log file path (with rotation)
 */
function getLogFilePath() {
    $logDir = ROOT_PATH . 'includes/logs/';
    $logFile = $logDir . 'error.log';
    
    // Check if log file needs rotation (5MB = 5242880 bytes)
    if (file_exists($logFile) && filesize($logFile) > 5242880) {
        // Rotate: rename current log to error.log.1, error.log.1 to error.log.2, etc.
        $timestamp = date('Y-m-d_H-i-s');
        $rotatedFile = $logDir . 'error_' . $timestamp . '.log';
        rename($logFile, $rotatedFile);
    }
    
    return $logFile;
}

/**
 * Write a log entry
 */
function logError($level, $message, $context = []) {
    $logFile = getLogFilePath();
    
    // Build log entry
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = [
        'timestamp' => $timestamp,
        'level' => strtoupper($level),
        'message' => $message
    ];
    
    // Add context information
    if (!empty($context)) {
        if (isset($context['file'])) $logEntry['file'] = $context['file'];
        if (isset($context['line'])) $logEntry['line'] = $context['line'];
        if (isset($context['trace'])) $logEntry['trace'] = $context['trace'];
    }
    
    // Add request information
    if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_id'])) {
        $logEntry['user_id'] = $_SESSION['user_id'];
    }
    
    if (isset($_SERVER['REMOTE_ADDR'])) {
        $logEntry['ip'] = getClientIP();
    }
    
    if (isset($_SERVER['REQUEST_URI'])) {
        $logEntry['url'] = $_SERVER['REQUEST_URI'];
    }
    
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $logEntry['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    }
    
    // Format as JSON for easier parsing
    $formattedEntry = json_encode($logEntry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
    
    // Write to log file
    file_put_contents($logFile, $formattedEntry, FILE_APPEND | LOCK_EX);
}

/**
 * Log levels
 */
function logCritical($message, $context = []) {
    logError('CRITICAL', $message, $context);
}

function logErrorMessage($message, $context = []) {
    logError('ERROR', $message, $context);
}

function logWarning($message, $context = []) {
    logError('WARNING', $message, $context);
}

function logInfo($message, $context = []) {
    logError('INFO', $message, $context);
}

function logDebug($message, $context = []) {
    // Only log debug messages in development
    if (!isProduction()) {
        logError('DEBUG', $message, $context);
    }
}

/**
 * Clean up old log files (older than 30 days)
 */
function cleanupOldLogs() {
    $logDir = ROOT_PATH . 'includes/logs/';
    $cutoffTime = time() - (30 * 24 * 60 * 60); // 30 days ago
    
    if (!is_dir($logDir)) {
        return;
    }
    
    $files = glob($logDir . 'error_*.log');
    foreach ($files as $file) {
        if (filemtime($file) < $cutoffTime) {
            unlink($file);
        }
    }
}

/**
 * Get all log files (sorted by modification time, newest first)
 */
function getLogFiles() {
    $logDir = ROOT_PATH . 'includes/logs/';
    $files = glob($logDir . '*.log');
    
    if (empty($files)) {
        return [];
    }
    
    // Sort by modification time, newest first
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    return $files;
}

/**
 * Read log file contents (latest entries first)
 */
function readLogFile($filename = null) {
    if ($filename === null) {
        $filename = getLogFilePath();
    }
    
    if (!file_exists($filename)) {
        return '';
    }
    
    $contents = file_get_contents($filename);
    
    // Reverse the order so newest entries are at the top
    $lines = explode(PHP_EOL, trim($contents));
    $lines = array_reverse($lines);
    
    return implode(PHP_EOL, $lines);
}

/**
 * Custom error handler for PHP errors
 */
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Don't log errors suppressed with @
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    $errorType = 'ERROR';
    switch ($errno) {
        case E_ERROR:
        case E_USER_ERROR:
        case E_COMPILE_ERROR:
        case E_CORE_ERROR:
            $errorType = 'CRITICAL';
            break;
        case E_WARNING:
        case E_USER_WARNING:
        case E_COMPILE_WARNING:
        case E_CORE_WARNING:
            $errorType = 'WARNING';
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
            $errorType = 'INFO';
            break;
    }
    
    logError($errorType, $errstr, [
        'file' => $errfile,
        'line' => $errline,
        'errno' => $errno
    ]);
    
    // In production, don't show errors to users
    if (isProduction()) {
        return true; // Prevent PHP from displaying the error
    }
    
    return false; // Let PHP display the error in development
}

/**
 * Custom exception handler
 */
function customExceptionHandler($exception) {
    logCritical($exception->getMessage(), [
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTraceAsString()
    ]);
    
    // In production, show generic error page
    if (isProduction()) {
        http_response_code(500);
        require_once ROOT_PATH . '500.php';
        exit;
    } else {
        // In development, let PHP display the exception
        throw $exception;
    }
}

/**
 * Initialize error logging
 */
function initErrorLogging() {
    // Set error handler
    set_error_handler('customErrorHandler');
    
    // Set exception handler
    set_exception_handler('customExceptionHandler');
    
    // Configure error reporting based on environment
    if (isProduction()) {
        // Production: log errors, don't display them
        ini_set('display_errors', '0');
        ini_set('display_startup_errors', '0');
        error_reporting(E_ALL);
    } else {
        // Development: log and display errors
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    }
    
    // Clean up old logs periodically (1% chance on each request)
    if (rand(1, 100) === 1) {
        cleanupOldLogs();
    }
}

// ============================================================================
// CATEGORY FUNCTIONS
// ============================================================================

/**
 * Get all categories
 */
function getAllCategories() {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM categories ORDER BY name ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $categories;
}

/**
 * Get category by ID
 */
function getCategoryById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();

    return $category;
}

/**
 * Get category by slug
 */
function getCategoryBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM categories WHERE slug = ? LIMIT 1");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();

    return $category;
}

/**
 * Create a new category
 */
function createCategory($name, $slug, $color = '#3B82F6') {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO categories (name, slug, color) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $slug, $color);
    $result = $stmt->execute();
    $insert_id = $db->insert_id;
    $stmt->close();

    return $result ? $insert_id : false;
}

/**
 * Update a category
 */
function updateCategory($id, $name, $slug, $color) {
    $db = getDB();
    $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ?, color = ? WHERE id = ?");
    $stmt->bind_param('sssi', $name, $slug, $color, $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Delete a category (reassigns posts to "Uncategorized")
 */
function deleteCategory($id) {
    $db = getDB();

    // Get the "Uncategorized" category ID
    $uncategorized = getCategoryBySlug('uncategorized');
    if (!$uncategorized) {
        return false;
    }

    // Reassign all posts from this category to "Uncategorized"
    $stmt = $db->prepare("UPDATE posts SET category_id = ? WHERE category_id = ?");
    $stmt->bind_param('ii', $uncategorized['id'], $id);
    $stmt->execute();
    $stmt->close();

    // Delete the category
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Get post count for a category
 */
function getCategoryPostCount($category_id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM posts WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return $row ? (int)$row['count'] : 0;
}

/**
 * Get posts by category (with pagination)
 */
function getPostsByCategory($category_id, $limit = null, $offset = 0, $published_only = true) {
    $db = getDB();

    $sql = "SELECT * FROM posts WHERE category_id = ?";
    if ($published_only) {
        $sql .= " AND status = 'published'";
    }
    $sql .= " ORDER BY created_at DESC";

    if ($limit !== null) {
        $sql .= " LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('iii', $category_id, $limit, $offset);
    } else {
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $category_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $posts;
}

/**
 * Get total posts count for a category
 */
function getTotalPostsByCategory($category_id, $published_only = true) {
    $db = getDB();

    $sql = "SELECT COUNT(*) as total FROM posts WHERE category_id = ?";
    if ($published_only) {
        $sql .= " AND status = 'published'";
    }

    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return (int)$row['total'];
}

// ============================================================================
// TAG FUNCTIONS
// ============================================================================

/**
 * Get all tags
 */
function getAllTags() {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM tags ORDER BY name ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    $tags = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $tags;
}

/**
 * Get tag by ID
 */
function getTagById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM tags WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tag = $result->fetch_assoc();
    $stmt->close();

    return $tag;
}

/**
 * Get tag by slug
 */
function getTagBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM tags WHERE slug = ? LIMIT 1");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $tag = $result->fetch_assoc();
    $stmt->close();

    return $tag;
}

/**
 * Create a new tag
 */
function createTag($name, $slug, $color = '#8B5CF6') {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO tags (name, slug, color) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $slug, $color);
    $result = $stmt->execute();
    $insert_id = $db->insert_id;
    $stmt->close();

    return $result ? $insert_id : false;
}

/**
 * Update a tag
 */
function updateTag($id, $name, $slug, $color) {
    $db = getDB();
    $stmt = $db->prepare("UPDATE tags SET name = ?, slug = ?, color = ? WHERE id = ?");
    $stmt->bind_param('sssi', $name, $slug, $color, $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Delete a tag (removes all post-tag associations)
 */
function deleteTag($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM tags WHERE id = ?");
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Get post count for a tag
 */
function getTagPostCount($tag_id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM post_tags WHERE tag_id = ?");
    $stmt->bind_param('i', $tag_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return $row ? (int)$row['count'] : 0;
}

/**
 * Get tags for a post
 */
function getPostTags($post_id) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT t.*
        FROM tags t
        INNER JOIN post_tags pt ON t.id = pt.tag_id
        WHERE pt.post_id = ?
        ORDER BY t.name ASC
    ");
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tags = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $tags;
}

/**
 * Get posts by tag (with pagination)
 */
function getPostsByTag($tag_id, $limit = null, $offset = 0, $published_only = true) {
    $db = getDB();

    $sql = "
        SELECT p.*
        FROM posts p
        INNER JOIN post_tags pt ON p.id = pt.post_id
        WHERE pt.tag_id = ?
    ";
    if ($published_only) {
        $sql .= " AND p.status = 'published'";
    }
    $sql .= " ORDER BY p.created_at DESC";

    if ($limit !== null) {
        $sql .= " LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('iii', $tag_id, $limit, $offset);
    } else {
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $tag_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $posts;
}

/**
 * Get total posts count for a tag
 */
function getTotalPostsByTag($tag_id, $published_only = true) {
    $db = getDB();

    $sql = "
        SELECT COUNT(*) as total
        FROM posts p
        INNER JOIN post_tags pt ON p.id = pt.post_id
        WHERE pt.tag_id = ?
    ";
    if ($published_only) {
        $sql .= " AND p.status = 'published'";
    }

    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $tag_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return (int)$row['total'];
}

/**
 * Add a tag to a post
 */
function addTagToPost($post_id, $tag_id) {
    $db = getDB();
    $stmt = $db->prepare("INSERT IGNORE INTO post_tags (post_id, tag_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $post_id, $tag_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Remove a tag from a post
 */
function removeTagFromPost($post_id, $tag_id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM post_tags WHERE post_id = ? AND tag_id = ?");
    $stmt->bind_param('ii', $post_id, $tag_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Remove all tags from a post
 */
function removeAllTagsFromPost($post_id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM post_tags WHERE post_id = ?");
    $stmt->bind_param('i', $post_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

/**
 * Set tags for a post (replaces existing tags)
 */
function setPostTags($post_id, $tag_ids) {
    // Remove all existing tags
    removeAllTagsFromPost($post_id);

    // Add new tags
    if (!empty($tag_ids)) {
        foreach ($tag_ids as $tag_id) {
            addTagToPost($post_id, $tag_id);
        }
    }

    return true;
}
