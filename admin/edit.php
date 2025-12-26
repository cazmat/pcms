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
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $status = $_POST['status'] ?? 'draft';

    // Validation
    if (empty($title)) {
        $errors[] = 'Title is required';
    }
    if (empty($content)) {
        $errors[] = 'Content is required';
    }
    if (empty($author)) {
        $errors[] = 'Author is required';
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
            if (updatePost($_POST['id'], $title, $slug, $content, $excerpt, $author, $status)) {
                redirect('index.php?updated=1');
            } else {
                $errors[] = 'Failed to update post';
            }
        } else {
            // Create new post
            if (createPost($title, $slug, $content, $excerpt, $author, $status)) {
                redirect('index.php?created=1');
            } else {
                $errors[] = 'Failed to create post';
            }
        }
    }
}

// Set default values
$formData = [
    'id' => $post['id'] ?? '',
    'title' => $_POST['title'] ?? $post['title'] ?? '',
    'content' => $_POST['content'] ?? $post['content'] ?? '',
    'excerpt' => $_POST['excerpt'] ?? $post['excerpt'] ?? '',
    'author' => $_POST['author'] ?? $post['author'] ?? 'Admin',
    'status' => $_POST['status'] ?? $post['status'] ?? 'draft',
    'slug' => $post['slug'] ?? ''
];

echo $template->render('pages/admin-edit.php', [
    'errors' => $errors,
    'formData' => $formData,
    'isEdit' => $isEdit,
    'current_user' => $current_user
]);
