<?php
require_once __DIR__ . '/../includes/functions.php';

$posts = getAllPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(SITE_NAME); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo e(SITE_NAME); ?></h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="../admin/index.php">Admin</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="posts-list">
            <?php if (empty($posts)): ?>
                <p class="no-posts">No posts available yet. Check back soon!</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="post-preview">
                        <h2>
                            <a href="post.php?slug=<?php echo e($post['slug']); ?>">
                                <?php echo e($post['title']); ?>
                            </a>
                        </h2>
                        <div class="post-meta">
                            <span class="author">By <?php echo e($post['author']); ?></span>
                            <span class="date"><?php echo formatDate($post['created_at']); ?></span>
                        </div>
                        <?php if ($post['excerpt']): ?>
                            <p class="excerpt"><?php echo e($post['excerpt']); ?></p>
                        <?php endif; ?>
                        <a href="post.php?slug=<?php echo e($post['slug']); ?>" class="read-more">
                            Read more &rarr;
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo e(SITE_NAME); ?>. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
