<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");

// Check for maintenance mode
showMaintenance();

// Check for coming soon mode
showComingSoon();

// Check for category filter
$filter_category = null;
$category_slug = isset($_GET['category']) ? trim($_GET['category']) : '';

if (!empty($category_slug)) {
    $filter_category = getCategoryBySlug($category_slug);
    // If invalid category slug, ignore filter
    if (!$filter_category) {
        $category_slug = '';
    }
}

// Pagination setup
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$posts_per_page = $system->get_setting('blog_ppp');

// Get total posts (filtered or all)
if ($filter_category) {
    $total_posts = getTotalPostsByCategory($filter_category['id'], true);
} else {
    $total_posts = getTotalPublishedPosts();
}

// Determine pagination base URL based on pretty_url setting
$pagination_base = $system->get_setting('pretty_url')
    ? $system->get_setting('base_url') . '/'
    : $system->get_setting('base_url') . '/index.php';

// Add category parameter to pagination base if filtering
if ($filter_category) {
    $pagination_base .= '?category=' . urlencode($category_slug);
}

// Generate pagination data
$pagination = getPaginationData(
    $current_page,
    $total_posts,
    $posts_per_page,
    $pagination_base
);

// Fetch posts for current page (filtered or all)
if ($filter_category) {
    $posts = getPostsByCategory($filter_category['id'], $posts_per_page, $pagination['offset'], true);
} else {
    $posts = getAllPosts($posts_per_page, $pagination['offset']);
}

// Enrich posts with category data
foreach ($posts as &$post) {
    if (!empty($post['category_id'])) {
        $post['category'] = getCategoryById($post['category_id']);
    }
}
unset($post); // Break reference

echo $template->render('pages/home.php', [
    'posts' => $posts,
    'pagination' => $pagination,
    'filter_category' => $filter_category
]);
