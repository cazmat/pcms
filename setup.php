<?php
/**
 * Database Setup Script for PHP Blog System
 *
 * This script creates the database, tables, and initial admin user.
 * Run this script once to set up your blog system.
 */

// Include configuration
require_once __DIR__ . '/includes/config.php';

// Check if already set up
$setupComplete = false;
$setupError = null;
$setupSuccess = false;

// Database schema definitions
$schema = [
    'database' => "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",

    'users' => "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_username (username)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'remember_tokens' => "CREATE TABLE IF NOT EXISTS remember_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        token VARCHAR(64) NOT NULL UNIQUE,
        expires_at TIMESTAMP NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_token (token),
        INDEX idx_user_id (user_id),
        INDEX idx_expires_at (expires_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'login_attempts' => "CREATE TABLE IF NOT EXISTS login_attempts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45) NOT NULL,
        username VARCHAR(50),
        attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_ip_address (ip_address),
        INDEX idx_attempted_at (attempted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'categories' => "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        slug VARCHAR(100) NOT NULL UNIQUE,
        color VARCHAR(7) DEFAULT '#3B82F6',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_slug (slug),
        INDEX idx_name (name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'tags' => "CREATE TABLE IF NOT EXISTS tags (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        slug VARCHAR(100) NOT NULL UNIQUE,
        color VARCHAR(7) DEFAULT '#8B5CF6',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_slug (slug),
        INDEX idx_name (name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'posts' => "CREATE TABLE IF NOT EXISTS posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        content TEXT NOT NULL,
        excerpt VARCHAR(500),
        meta_description VARCHAR(160),
        meta_keywords VARCHAR(255),
        author VARCHAR(100) NOT NULL,
        category_id INT NULL,
        status ENUM('draft', 'published') DEFAULT 'draft',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
        INDEX idx_slug (slug),
        INDEX idx_status (status),
        INDEX idx_created_at (created_at),
        INDEX idx_category_id (category_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'post_tags' => "CREATE TABLE IF NOT EXISTS post_tags (
        post_id INT NOT NULL,
        tag_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (post_id, tag_id),
        FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
        FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
        INDEX idx_post_id (post_id),
        INDEX idx_tag_id (tag_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

// Sample categories data
$sampleCategories = [
    ['name' => 'Uncategorized', 'slug' => 'uncategorized', 'color' => '#6B7280'],
    ['name' => 'Technology', 'slug' => 'technology', 'color' => '#3B82F6'],
    ['name' => 'Programming', 'slug' => 'programming', 'color' => '#8B5CF6'],
    ['name' => 'Tutorials', 'slug' => 'tutorials', 'color' => '#10B981']
];

// Sample tags data
$sampleTags = [
    ['name' => 'PHP', 'slug' => 'php', 'color' => '#8B5CF6'],
    ['name' => 'MySQL', 'slug' => 'mysql', 'color' => '#F59E0B'],
    ['name' => 'Web Development', 'slug' => 'web-development', 'color' => '#10B981'],
    ['name' => 'Tutorial', 'slug' => 'tutorial', 'color' => '#EC4899'],
    ['name' => 'Beginner', 'slug' => 'beginner', 'color' => '#6366F1']
];

// Sample posts data
$samplePosts = [
    [
        'title' => 'Welcome to My Blog',
        'slug' => 'welcome-to-my-blog',
        'content' => '<p>Welcome to my new blog! This is my first post and I\'m excited to share my thoughts with you.</p><p>This blog is built using PHP and MySQL, providing a simple but effective platform for sharing content.</p><p>Stay tuned for more posts!</p>',
        'excerpt' => 'Welcome to my new blog! This is my first post and I\'m excited to share my thoughts with you.',
        'author' => 'Admin',
        'category_slug' => 'uncategorized',
        'status' => 'published',
        'tags' => ['web-development', 'beginner']
    ],
    [
        'title' => 'Getting Started with PHP',
        'slug' => 'getting-started-with-php',
        'content' => '<p>PHP is a popular server-side scripting language that powers millions of websites worldwide.</p><p>In this post, we\'ll explore the basics of PHP and why it\'s a great choice for web development.</p><p>PHP is easy to learn, widely supported, and integrates seamlessly with databases like MySQL.</p>',
        'excerpt' => 'Learn the basics of PHP and discover why it\'s such a popular choice for web development.',
        'author' => 'Admin',
        'category_slug' => 'programming',
        'status' => 'published',
        'tags' => ['php', 'tutorial', 'beginner']
    ],
    [
        'title' => 'Building a Blog with PHP',
        'slug' => 'building-a-blog-with-php',
        'content' => '<p>Creating a blog system is a great way to learn PHP and database integration.</p><p>In this tutorial series, we\'ll build a complete blog from scratch, including features like:</p><ul><li>Post creation and editing</li><li>Database integration</li><li>Clean URL slugs</li><li>Responsive design</li></ul>',
        'excerpt' => 'Learn how to build a complete blog system using PHP and MySQL from scratch.',
        'author' => 'Admin',
        'category_slug' => 'tutorials',
        'status' => 'draft',
        'tags' => ['php', 'mysql', 'tutorial', 'web-development']
    ]
];

// Check if setup is already complete
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        throw new Exception("Connection failed");
    }

    // Check if users table exists and has data
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            $setupComplete = true;
        }
    }
    $conn->close();
} catch (Exception $e) {
    // Database or table doesn't exist yet
    $setupComplete = false;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$setupComplete) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $email = trim($_POST['email'] ?? '');

    $errors = [];

    // Validation
    if (empty($username)) {
        $errors[] = 'Username is required';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Username must be at least 3 characters';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = 'Username can only contain letters, numbers, and underscores';
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters';
    }

    if ($password !== $password_confirm) {
        $errors[] = 'Passwords do not match';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address';
    }

    if (empty($errors)) {
        try {
            // Create connection without database selection first
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Create database
            if (!$conn->query($schema['database'])) {
                throw new Exception("Error creating database: " . $conn->error);
            }

            // Select database
            $conn->select_db(DB_NAME);

            // Create tables (order matters due to foreign key constraints)
            foreach (['users', 'remember_tokens', 'login_attempts', 'categories', 'tags', 'posts', 'post_tags'] as $table) {
                if (!$conn->query($schema[$table])) {
                    throw new Exception("Error creating table $table: " . $conn->error);
                }
            }

            // Insert admin user
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $username, $hashed_password, $email);

            if (!$stmt->execute()) {
                throw new Exception("Error creating admin user: " . $stmt->error);
            }
            $stmt->close();

            // Insert sample categories
            $stmt = $conn->prepare("INSERT INTO categories (name, slug, color) VALUES (?, ?, ?)");
            foreach ($sampleCategories as $category) {
                $stmt->bind_param('sss', $category['name'], $category['slug'], $category['color']);
                $stmt->execute();
            }
            $stmt->close();

            // Insert sample tags
            $stmt = $conn->prepare("INSERT INTO tags (name, slug, color) VALUES (?, ?, ?)");
            foreach ($sampleTags as $tag) {
                $stmt->bind_param('sss', $tag['name'], $tag['slug'], $tag['color']);
                $stmt->execute();
            }
            $stmt->close();

            // Insert sample posts with categories
            $stmt = $conn->prepare("
                INSERT INTO posts (title, slug, content, excerpt, author, category_id, status)
                VALUES (?, ?, ?, ?, ?, (SELECT id FROM categories WHERE slug = ?), ?)
            ");

            foreach ($samplePosts as $post) {
                $stmt->bind_param('sssssss',
                    $post['title'],
                    $post['slug'],
                    $post['content'],
                    $post['excerpt'],
                    $post['author'],
                    $post['category_slug'],
                    $post['status']
                );
                $stmt->execute();
            }
            $stmt->close();

            // Insert sample post-tag associations
            $stmtPostTag = $conn->prepare("
                INSERT INTO post_tags (post_id, tag_id)
                SELECT p.id, t.id
                FROM posts p, tags t
                WHERE p.slug = ? AND t.slug = ?
            ");

            foreach ($samplePosts as $post) {
                if (!empty($post['tags'])) {
                    foreach ($post['tags'] as $tag_slug) {
                        $stmtPostTag->bind_param('ss', $post['slug'], $tag_slug);
                        $stmtPostTag->execute();
                    }
                }
            }
            $stmtPostTag->close();

            $conn->close();

            $setupSuccess = true;
            $setupComplete = true;

        } catch (Exception $e) {
            $setupError = $e->getMessage();
        }
    } else {
        $setupError = implode('<br>', $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .setup-container {
            max-width: 600px;
            margin: 4rem auto;
            padding: 0 20px;
        }
        .setup-box {
            background: #fff;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .setup-box h1 {
            margin-bottom: 0.5rem;
            color: #333;
        }
        .setup-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .setup-complete {
            text-align: center;
            padding: 3rem 2rem;
        }
        .setup-complete h2 {
            color: #28a745;
            margin-bottom: 1rem;
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        .config-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 5px;
            margin: 1.5rem 0;
            border-left: 4px solid #667eea;
        }
        .config-info h3 {
            margin-top: 0;
            color: #495057;
            font-size: 1.1rem;
        }
        .config-info code {
            background: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            color: #e83e8c;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-box">
            <?php if ($setupComplete && $setupSuccess): ?>
                <div class="setup-complete">
                    <div class="success-icon">✓</div>
                    <h2>Setup Complete!</h2>
                    <p>Your blog system has been successfully set up.</p>

                    <div style="margin: 2rem 0; text-align: left;">
                        <p><strong>Your admin credentials:</strong></p>
                        <ul style="list-style: none; padding: 0;">
                            <li>Username: <code><?php echo htmlspecialchars($username); ?></code></li>
                            <li>Password: <em>(the one you just created)</em></li>
                        </ul>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                        <a href="index.php" class="btn btn-primary">View Blog</a>
                        <a href="admin/login.php" class="btn btn-secondary">Admin Login</a>
                    </div>

                    <p style="margin-top: 2rem; color: #6c757d; font-size: 0.9rem;">
                        <strong>Important:</strong> For security, consider deleting or restricting access to setup.php
                    </p>
                </div>
            <?php elseif ($setupComplete): ?>
                <div class="setup-complete">
                    <h2>Already Set Up</h2>
                    <p>The blog system has already been set up.</p>
                    <p>If you need to reset the database, please do so manually.</p>

                    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                        <a href="index.php" class="btn btn-primary">View Blog</a>
                        <a href="admin/login.php" class="btn btn-secondary">Admin Login</a>
                    </div>
                </div>
            <?php else: ?>
                <h1>Blog System Setup</h1>
                <p class="setup-subtitle">Create your admin account to get started</p>

                <div class="config-info">
                    <h3>Database Configuration</h3>
                    <p>
                        <strong>Host:</strong> <code><?php echo DB_HOST; ?></code><br>
                        <strong>Database:</strong> <code><?php echo DB_NAME; ?></code><br>
                        <strong>User:</strong> <code><?php echo DB_USER; ?></code>
                    </p>
                    <p style="margin-bottom: 0; font-size: 0.9rem; color: #6c757d;">
                        Make sure your MySQL server is running and the credentials in <code>includes/config.php</code> are correct.
                    </p>
                </div>

                <?php if ($setupError): ?>
                    <div class="alert alert-error">
                        <?php echo $setupError; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="post-form" style="padding: 0;">
                    <div class="form-group">
                        <label for="username">Admin Username *</label>
                        <input type="text" id="username" name="username"
                               value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                               required autofocus
                               pattern="[a-zA-Z0-9_]+"
                               title="Only letters, numbers, and underscores allowed">
                        <small>At least 3 characters. Only letters, numbers, and underscores.</small>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address (optional)</label>
                        <input type="email" id="email" name="email"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required minlength="6">
                        <small>At least 6 characters.</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirm Password *</label>
                        <input type="password" id="password_confirm" name="password_confirm" required minlength="6">
                    </div>

                    <div class="form-actions" style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            Create Admin Account & Set Up Database
                        </button>
                    </div>
                </form>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e9ecef; font-size: 0.9rem; color: #6c757d;">
                    <p><strong>This setup will:</strong></p>
                    <ul>
                        <li>Create the database and all required tables</li>
                        <li>Create your admin account with the credentials above</li>
                        <li>Add 4 sample categories and 5 sample tags</li>
                        <li>Add 3 sample blog posts with categories and tags (2 published, 1 draft)</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
