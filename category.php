<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");

// Check for maintenance mode
showMaintenance();

// Check for coming soon mode
showComingSoon();

// Get category slug from URL
$category_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($category_slug)) {
    redirect('index.php');
}

// Get category by slug
$category = getCategoryBySlug($category_slug);

if (!$category) {
    // Category not found, show 404
    http_response_code(404);
    echo $template->render('pages/404.php', [
        'message' => 'Category not found.'
    ]);
    exit;
}

// Pagination setup
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$posts_per_page = $system->get_setting('blog_ppp');
$total_posts = getTotalPostsByCategory($category['id'], true);

// Determine pagination base URL based on pretty_url setting
$pagination_base = $system->get_setting('pretty_url')
    ? $system->get_setting('base_url') . '/category/' . $category_slug
    : $system->get_setting('base_url') . '/category.php?slug=' . $category_slug;

// Generate pagination data
$pagination = getPaginationData(
    $current_page,
    $total_posts,
    $posts_per_page,
    $pagination_base
);

// Fetch posts for current page
$posts = getPostsByCategory($category['id'], $posts_per_page, $pagination['offset'], true);

// Enrich posts with category data (they all have the same category, but for consistency)
foreach ($posts as &$post) {
    $post['category'] = $category;
}
unset($post); // Break reference

echo $template->render('pages/category.php', [
    'category' => $category,
    'posts' => $posts,
    'pagination' => $pagination
]);
