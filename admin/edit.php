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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit' : 'Create'; ?> Post - <?php echo e($system->get_setting("site_name")); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo $isEdit ? 'Edit' : 'Create'; ?> Post</h1>
            <nav>
                <a href="<?php echo e($system->get_setting('base_url')); ?>/index.php">View Blog</a>
                <a href="<?php echo e($system->get_setting('base_url')); ?>/admin/index.php">Manage Posts</a>
                <span class="nav-divider">|</span>
                <span class="nav-user">Logged in as: <strong><?php echo e($current_user['username']); ?></strong></span>
                <a href="<?php echo e($system->get_setting('base_url')); ?>/admin/logout.php" class="btn-logout">Log Out</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="post-form">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?php echo e($formData['id']); ?>">
                <input type="hidden" name="original_slug" value="<?php echo e($formData['slug']); ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" value="<?php echo e($formData['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="3"><?php echo e($formData['excerpt']); ?></textarea>
                <small>A short summary of your post (optional)</small>
            </div>

            <div class="form-group">
                <label for="content">Content *</label>
                <textarea id="content" name="content" rows="15" required><?php echo e($formData['content']); ?></textarea>
                <small>You can use HTML tags for formatting</small>
            </div>

            <div class="form-group">
                <label for="author">Author *</label>
                <input type="text" id="author" name="author" value="<?php echo e($formData['author']); ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="draft" <?php echo $formData['status'] === 'draft' ? 'selected' : ''; ?>>
                        Draft
                    </option>
                    <option value="published" <?php echo $formData['status'] === 'published' ? 'selected' : ''; ?>>
                        Published
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?php echo $isEdit ? 'Update' : 'Create'; ?> Post
                </button>
                <a href="<?php echo e($system->get_setting('base_url')); ?>/admin/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo e($system->get_setting("site_name")); ?>. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
