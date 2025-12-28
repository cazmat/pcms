<?php
define("ROOT_PATH", "../");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/../includes/functions.php';

// Require authentication
requireAuth();

$current_user = getCurrentUser();
$errors = [];
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get category
$category = getCategoryById($category_id);

if (!$category) {
    redirect('categories.php');
}

// Check if this is the protected "Uncategorized" category
$is_protected = ($category['slug'] === 'uncategorized');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if (!validateCSRFToken($csrf_token)) {
        $errors[] = 'Invalid security token. Please try again.';
    } elseif ($is_protected) {
        $errors[] = 'The "Uncategorized" category cannot be edited.';
    } else {
        // Get and sanitize form data
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $color = trim($_POST['color'] ?? '#3B82F6');

        $category['name'] = $name;
        $category['slug'] = $slug;
        $category['color'] = $color;

        // Validation
        if (empty($name)) {
            $errors[] = 'Category name is required.';
        } elseif (strlen($name) > 100) {
            $errors[] = 'Category name must not exceed 100 characters.';
        }

        if (empty($slug)) {
            $errors[] = 'Category slug is required.';
        } elseif (strlen($slug) > 100) {
            $errors[] = 'Category slug must not exceed 100 characters.';
        } elseif (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $errors[] = 'Category slug can only contain lowercase letters, numbers, and hyphens.';
        } else {
            // Check if slug already exists (excluding current category)
            $existing = getCategoryBySlug($slug);
            if ($existing && $existing['id'] != $category_id) {
                $errors[] = 'A category with this slug already exists.';
            }
        }

        // Validate color (hex format)
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
            $errors[] = 'Invalid color format. Must be a hex color code (e.g., #3B82F6).';
        }

        // If no errors, update category
        if (empty($errors)) {
            if (updateCategory($category_id, $name, $slug, $color)) {
                redirect('categories.php?updated=1');
            } else {
                $errors[] = 'Failed to update category. Please try again.';
            }
        }
    }
}

// Render template
echo $template->render('pages/admin-category-form.php', [
    'mode' => 'edit',
    'category' => $category,
    'is_protected' => $is_protected,
    'errors' => $errors,
    'current_user' => $current_user
]);
