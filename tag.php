<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");

// Check for maintenance mode
showMaintenance();

// Check for coming soon mode
showComingSoon();

// Get tag slug from URL
$tag_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($tag_slug)) {
    redirect('index.php');
}

// Get tag by slug
$tag = getTagBySlug($tag_slug);

if (!$tag) {
    // Tag not found, show 404
    http_response_code(404);
    echo $template->render('pages/404.php', [
        'message' => 'Tag not found.'
    ]);
    exit;
}

// Pagination setup
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$posts_per_page = $system->get_setting('blog_ppp');
$total_posts = getTotalPostsByTag($tag['id'], true);

// Determine pagination base URL based on pretty_url setting
$pagination_base = $system->get_setting('pretty_url')
    ? $system->get_setting('base_url') . '/tag/' . $tag_slug
    : $system->get_setting('base_url') . '/tag.php?slug=' . $tag_slug;

// Generate pagination data
$pagination = getPaginationData(
    $current_page,
    $total_posts,
    $posts_per_page,
    $pagination_base
);

// Fetch posts for current page
$posts = getPostsByTag($tag['id'], $posts_per_page, $pagination['offset'], true);

// Enrich posts with category data
foreach ($posts as &$post) {
    if (!empty($post['category_id'])) {
        $post['category'] = getCategoryById($post['category_id']);
    }
}
unset($post); // Break reference

echo $template->render('pages/tag.php', [
    'tag' => $tag,
    'posts' => $posts,
    'pagination' => $pagination
]);
