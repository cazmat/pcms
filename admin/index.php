<?php
  define("ROOT_PATH", "../");

  require_once(ROOT_PATH ."includes/init.php");

require_once __DIR__ . '/../includes/functions.php';

// Require authentication
requireAuth();

$current_user = getCurrentUser();

// Handle post deletion
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (deletePost($id)) {
        redirect('index.php?deleted=1');
    }
}

// Pagination setup
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$posts_per_page = $system->get_setting('blog_ppp');
$total_posts = getTotalPosts();

// Generate pagination data
$pagination = getPaginationData(
    $current_page,
    $total_posts,
    $posts_per_page,
    $system->get_setting('base_url') . '/admin/index.php'
);

// Fetch posts for current page
$posts = getAllPostsAdmin($posts_per_page, $pagination['offset']);

$message = '';

if (isset($_GET['created'])) {
    $message = 'Post created successfully!';
} elseif (isset($_GET['updated'])) {
    $message = 'Post updated successfully!';
} elseif (isset($_GET['deleted'])) {
    $message = 'Post deleted successfully!';
}

echo $template->render('pages/admin-index.php', [
    'posts' => $posts,
    'message' => $message,
    'current_user' => $current_user,
    'pagination' => $pagination
]);
