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
    'color' => '#8B5CF6'
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
        $color = trim($_POST['color'] ?? '#8B5CF6');

        $form_data = [
            'name' => $name,
            'slug' => $slug,
            'color' => $color
        ];

        // Validation
        if (empty($name)) {
            $errors[] = 'Tag name is required.';
        } elseif (strlen($name) > 100) {
            $errors[] = 'Tag name must not exceed 100 characters.';
        }

        if (empty($slug)) {
            $errors[] = 'Tag slug is required.';
        } elseif (strlen($slug) > 100) {
            $errors[] = 'Tag slug must not exceed 100 characters.';
        } elseif (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $errors[] = 'Tag slug can only contain lowercase letters, numbers, and hyphens.';
        } else {
            // Check if slug already exists
            $existing = getTagBySlug($slug);
            if ($existing) {
                $errors[] = 'A tag with this slug already exists.';
            }
        }

        // Validate color (hex format)
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
            $errors[] = 'Invalid color format. Must be a hex color code (e.g., #8B5CF6).';
        }

        // If no errors, create tag
        if (empty($errors)) {
            $tag_id = createTag($name, $slug, $color);

            if ($tag_id) {
                redirect('tags.php?created=1');
            } else {
                $errors[] = 'Failed to create tag. Please try again.';
            }
        }
    }
}

// Render template
echo $template->render('pages/admin-tag-form.php', [
    'mode' => 'create',
    'tag' => $form_data,
    'errors' => $errors,
    'current_user' => $current_user
]);
