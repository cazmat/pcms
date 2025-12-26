<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/includes/functions.php';

// Check for maintenance mode
if ($system->get_setting('maintenance') && !isLoggedIn()) {
    require_once 'maintenance.php';
    exit;
}

// Pagination setup
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$posts_per_page = $system->get_setting('blog_ppp');
$total_posts = getTotalPublishedPosts();

// Generate pagination data
$pagination = getPaginationData(
    $current_page,
    $total_posts,
    $posts_per_page,
    $system->get_setting('base_url') . '/index.php'
);

// Fetch posts for current page
$posts = getAllPosts($posts_per_page, $pagination['offset']);

echo $template->render('pages/home.php', [
    'posts' => $posts,
    'pagination' => $pagination
]);
