<?php
require_once __DIR__ . '/../includes/functions.php';

// Handle post deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (deletePost($id)) {
        redirect('index.php?deleted=1');
    }
}

$posts = getAllPostsAdmin();
$message = '';

if (isset($_GET['created'])) {
    $message = 'Post created successfully!';
} elseif (isset($_GET['updated'])) {
    $message = 'Post updated successfully!';
} elseif (isset($_GET['deleted'])) {
    $message = 'Post deleted successfully!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo e(SITE_NAME); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Admin Panel</h1>
            <nav>
                <a href="../index.php">View Blog</a>
                <a href="index.php">Manage Posts</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="admin-header">
            <h2>Manage Posts</h2>
            <a href="edit.php" class="btn btn-primary">Create New Post</a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo e($message); ?></div>
        <?php endif; ?>

        <div class="admin-posts">
            <?php if (empty($posts)): ?>
                <p class="no-posts">No posts found. Create your first post!</p>
            <?php else: ?>
                <table class="posts-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($post['title']); ?></strong>
                                </td>
                                <td><?php echo e($post['author']); ?></td>
                                <td>
                                    <span class="status status-<?php echo e($post['status']); ?>">
                                        <?php echo ucfirst($post['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo formatDate($post['created_at']); ?></td>
                                <td class="actions">
                                    <?php if ($post['status'] === 'published'): ?>
                                        <a href="../post.php?slug=<?php echo e($post['slug']); ?>"
                                           target="_blank" class="btn btn-small">View</a>
                                    <?php endif; ?>
                                    <a href="edit.php?id=<?php echo $post['id']; ?>"
                                       class="btn btn-small">Edit</a>
                                    <a href="index.php?delete=1&id=<?php echo $post['id']; ?>"
                                       class="btn btn-small btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
