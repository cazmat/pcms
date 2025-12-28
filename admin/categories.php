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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if (!validateCSRFToken($csrf_token)) {
        $errors[] = 'Invalid security token. Please try again.';
    } else {
        $category_id = (int)$_POST['category_id'];
        $category = getCategoryById($category_id);

        if (!$category) {
            $errors[] = 'Category not found.';
        } elseif ($category['slug'] === 'uncategorized') {
            $errors[] = 'The "Uncategorized" category cannot be deleted.';
        } else {
            if (deleteCategory($category_id)) {
                redirect('categories.php?deleted=1');
            } else {
                $errors[] = 'Failed to delete category.';
            }
        }
    }
}

// Handle success messages from redirects
if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
    $success = 'Category deleted successfully. Posts have been reassigned to "Uncategorized".';
}
if (isset($_GET['created']) && $_GET['created'] == '1') {
    $success = 'Category created successfully.';
}
if (isset($_GET['updated']) && $_GET['updated'] == '1') {
    $success = 'Category updated successfully.';
}

// Get all categories with post counts
$categories = getAllCategories();
foreach ($categories as &$category) {
    $category['post_count'] = getCategoryPostCount($category['id']);
}
unset($category);

// Render template
echo $template->render('pages/admin-categories.php', [
    'categories' => $categories,
    'errors' => $errors,
    'success' => $success,
    'current_user' => $current_user
]);
