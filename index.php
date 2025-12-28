<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/includes/functions.php';

// Check for maintenance mode
if ($system->get_setting('maintenance') && !isLoggedIn()) {
    require_once 'maintenance.php';
    exit;
}

// Check for coming soon mode
if ($system->get_setting('coming_soon') && !isLoggedIn()) {
    //$template = new Template();
    echo $template->render('pages/coming-soon.php');
    exit;
}

// Pagination setup
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$posts_per_page = $system->get_setting('blog_ppp');
$total_posts = getTotalPublishedPosts();

// Determine pagination base URL based on pretty_url setting
$pagination_base = $system->get_setting('pretty_url')
    ? $system->get_setting('base_url') . '/'
    : $system->get_setting('base_url') . '/index.php';

// Generate pagination data
$pagination = getPaginationData(
    $current_page,
    $total_posts,
    $posts_per_page,
    $pagination_base
);

// Fetch posts for current page
$posts = getAllPosts($posts_per_page, $pagination['offset']);

// Enrich posts with category data
foreach ($posts as &$post) {
    if (!empty($post['category_id'])) {
        $post['category'] = getCategoryById($post['category_id']);
    }
}
unset($post); // Break reference

echo $template->render('pages/home.php', [
    'posts' => $posts,
    'pagination' => $pagination
]);
