<?php
define("ROOT_PATH", "../");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/../includes/functions.php';

// Require authentication
requireAuth();

$current_user = getCurrentUser();

$errors = [];
$post = null;
$isEdit = false;

// Check if editing existing post
if (isset($_GET['id'])) {
    $isEdit = true;
    $post = getPostById($_GET['id']);
    if (!$post) {
        redirect('index.php');
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $meta_keywords = trim($_POST['meta_keywords'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $status = $_POST['status'] ?? 'draft';
    $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $tag_ids = isset($_POST['tag_ids']) && is_array($_POST['tag_ids']) ? array_map('intval', $_POST['tag_ids']) : [];

    // Validate CSRF token
    if (!validateCSRFToken($csrf_token)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    // Enhanced validation using new validation functions
    if (empty($errors)) {
        $errors = array_merge($errors, validatePostTitle($title));
        $errors = array_merge($errors, validatePostContent($content));
        $errors = array_merge($errors, validateExcerpt($excerpt));
        $errors = array_merge($errors, validateAuthor($author));
    }

    // Sanitize content to prevent XSS
    if (empty($errors)) {
        $content = sanitizeHTML($content);
        $title = sanitizePlainText($title);
        $excerpt = sanitizePlainText($excerpt);
        $meta_description = sanitizePlainText($meta_description);
        $meta_keywords = sanitizePlainText($meta_keywords);
        $author = sanitizePlainText($author);
    }

    if (empty($errors)) {
        // Generate slug from title
        $slug = generateSlug($title);

        // Check if slug already exists (for new posts or changed titles)
        if ($isEdit && isset($_POST['original_slug']) && $_POST['original_slug'] !== $slug) {
            // For edit, we need to check if the new slug conflicts
            $existingPost = getPostBySlug($slug);
            if ($existingPost && $existingPost['id'] != $_POST['id']) {
                $slug = $slug . '-' . time();
            }
        } elseif (!$isEdit) {
            // For new posts
            $existingPost = getPostBySlug($slug);
            if ($existingPost) {
                $slug = $slug . '-' . time();
            }
        }

        if ($isEdit) {
            // Update existing post
            if (updatePost($_POST['id'], $title, $slug, $content, $excerpt, $author, $status, $category_id, $meta_description, $meta_keywords)) {
                // Update tags
                setPostTags($_POST['id'], $tag_ids);
                redirect('index.php?updated=1');
            } else {
                $errors[] = 'Failed to update post';
            }
        } else {
            // Create new post
            $post_id = createPost($title, $slug, $content, $excerpt, $author, $status, $category_id, $meta_description, $meta_keywords);
            if ($post_id) {
                // Set tags for new post
                setPostTags($post_id, $tag_ids);
                redirect('index.php?created=1');
            } else {
                $errors[] = 'Failed to create post';
            }
        }
    }
}

// Set default values
$formData = [
    'id' => $post ? ($post['id'] ?? '') : '',
    'title' => $_POST['title'] ?? ($post ? ($post['title'] ?? '') : ''),
    'content' => $_POST['content'] ?? ($post ? ($post['content'] ?? '') : ''),
    'excerpt' => $_POST['excerpt'] ?? ($post ? ($post['excerpt'] ?? '') : ''),
    'meta_description' => $_POST['meta_description'] ?? ($post ? ($post['meta_description'] ?? '') : ''),
    'meta_keywords' => $_POST['meta_keywords'] ?? ($post ? ($post['meta_keywords'] ?? '') : ''),
    'author' => $_POST['author'] ?? ($post ? ($post['author'] ?? 'Admin') : 'Admin'),
    'status' => $_POST['status'] ?? ($post ? ($post['status'] ?? 'draft') : 'draft'),
    'slug' => $post ? ($post['slug'] ?? '') : '',
    'category_id' => $_POST['category_id'] ?? ($post ? ($post['category_id'] ?? null) : null)
];

// Get all categories and tags for the form
$categories = getAllCategories();
$tags = getAllTags();

// Get current post tags if editing
$currentTagIds = [];
if ($isEdit && $post) {
    $postTags = getPostTags($post['id']);
    $currentTagIds = array_column($postTags, 'id');
}

// If POST submission failed, preserve selected tags
if (!empty($_POST['tag_ids'])) {
    $currentTagIds = array_map('intval', $_POST['tag_ids']);
}

echo $template->render('pages/admin-edit.php', [
    'errors' => $errors,
    'formData' => $formData,
    'isEdit' => $isEdit,
    'current_user' => $current_user,
    'csrf_token' => getCSRFToken(),
    'categories' => $categories,
    'tags' => $tags,
    'currentTagIds' => $currentTagIds
]);
