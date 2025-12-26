<?php
require_once __DIR__ . '/db.php';

/**
 * Get all published posts
 */
function getAllPosts($limit = null, $offset = 0) {
    $db = getDB();
    $sql = "SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC";

    if ($limit !== null) {
        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    } else {
        $stmt = $db->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Get all posts (including drafts) for admin
 */
function getAllPostsAdmin($limit = null, $offset = 0) {
    $db = getDB();
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";

    if ($limit !== null) {
        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    } else {
        $stmt = $db->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Get a single post by slug
 */
function getPostBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'published' LIMIT 1");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

/**
 * Get a single post by ID (for admin)
 */
function getPostById($id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

/**
 * Create a new post
 */
function createPost($title, $slug, $content, $excerpt, $author, $status = 'draft') {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO posts (title, slug, content, excerpt, author, status)
        VALUES (:title, :slug, :content, :excerpt, :author, :status)
    ");

    return $stmt->execute([
        ':title' => $title,
        ':slug' => $slug,
        ':content' => $content,
        ':excerpt' => $excerpt,
        ':author' => $author,
        ':status' => $status
    ]);
}

/**
 * Update an existing post
 */
function updatePost($id, $title, $slug, $content, $excerpt, $author, $status) {
    $db = getDB();
    $stmt = $db->prepare("
        UPDATE posts
        SET title = :title, slug = :slug, content = :content,
            excerpt = :excerpt, author = :author, status = :status
        WHERE id = :id
    ");

    return $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':slug' => $slug,
        ':content' => $content,
        ':excerpt' => $excerpt,
        ':author' => $author,
        ':status' => $status
    ]);
}

/**
 * Delete a post
 */
function deletePost($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
    return $stmt->execute([':id' => $id]);
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
