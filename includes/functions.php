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
