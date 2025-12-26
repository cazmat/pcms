<?php
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['slug'])) {
    redirect('index.php');
}

$post = getPostBySlug($_GET['slug']);

if (!$post) {
    http_response_code(404);
    die('Post not found');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($post['title']); ?> - <?php echo e(SITE_NAME); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php"><?php echo e(SITE_NAME); ?></a></h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="../admin/index.php">Admin</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <article class="post-single">
            <h1><?php echo e($post['title']); ?></h1>
            <div class="post-meta">
                <span class="author">By <?php echo e($post['author']); ?></span>
                <span class="date"><?php echo formatDate($post['created_at']); ?></span>
                <?php if ($post['updated_at'] != $post['created_at']): ?>
                    <span class="updated">Updated: <?php echo formatDate($post['updated_at']); ?></span>
                <?php endif; ?>
            </div>
            <div class="post-content">
                <?php echo $post['content']; ?>
            </div>
            <div class="post-actions">
                <a href="index.php" class="btn-back">&larr; Back to all posts</a>
            </div>
        </article>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo e(SITE_NAME); ?>. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
