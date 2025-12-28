<?php
define("ROOT_PATH", "../");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/../includes/functions.php';

// Require authentication
requireAuth();

$current_user = getCurrentUser();
$errors = [];
$form_data = [
    'name' => '',
    'slug' => '',
    'color' => '#3B82F6'
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if (!validateCSRFToken($csrf_token)) {
        $errors[] = 'Invalid security token. Please try again.';
    } else {
        // Get and sanitize form data
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $color = trim($_POST['color'] ?? '#3B82F6');

        $form_data = [
            'name' => $name,
            'slug' => $slug,
            'color' => $color
        ];

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
            // Check if slug already exists
            $existing = getCategoryBySlug($slug);
            if ($existing) {
                $errors[] = 'A category with this slug already exists.';
            }
        }

        // Validate color (hex format)
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
            $errors[] = 'Invalid color format. Must be a hex color code (e.g., #3B82F6).';
        }

        // If no errors, create category
        if (empty($errors)) {
            $category_id = createCategory($name, $slug, $color);

            if ($category_id) {
                redirect('categories.php?created=1');
            } else {
                $errors[] = 'Failed to create category. Please try again.';
            }
        }
    }
}

// Render template
echo $template->render('pages/admin-category-form.php', [
    'mode' => 'create',
    'category' => $form_data,
    'errors' => $errors,
    'current_user' => $current_user
]);
