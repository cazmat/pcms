<?php
define("ROOT_PATH", "../");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/../includes/functions.php';

// Require authentication
requireAuth();

$current_user = getCurrentUser();
$errors = [];
$success = '';

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tag'])) {
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if (!validateCSRFToken($csrf_token)) {
        $errors[] = 'Invalid security token. Please try again.';
    } else {
        $tag_id = (int)$_POST['tag_id'];
        $tag = getTagById($tag_id);

        if (!$tag) {
            $errors[] = 'Tag not found.';
        } else {
            if (deleteTag($tag_id)) {
                redirect('tags.php?deleted=1');
            } else {
                $errors[] = 'Failed to delete tag.';
            }
        }
    }
}

// Handle success messages from redirects
if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
    $success = 'Tag deleted successfully.';
}
if (isset($_GET['created']) && $_GET['created'] == '1') {
    $success = 'Tag created successfully.';
}
if (isset($_GET['updated']) && $_GET['updated'] == '1') {
    $success = 'Tag updated successfully.';
}

// Get all tags with post counts
$tags = getAllTags();
foreach ($tags as &$tag) {
    $tag['post_count'] = getTagPostCount($tag['id']);
}
unset($tag);

// Render template
echo $template->render('pages/admin-tags.php', [
    'tags' => $tags,
    'errors' => $errors,
    'success' => $success,
    'current_user' => $current_user
]);
