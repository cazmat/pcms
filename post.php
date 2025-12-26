<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/includes/functions.php';

// Check for maintenance mode
if ($system->get_setting('maintenance') && !isLoggedIn()) {
    require_once 'maintenance.php';
    exit;
}

if (!isset($_GET['slug'])) {
    redirect('index.php');
}

$post = getPostBySlug($_GET['slug']);

if (!$post) {
    http_response_code(404);
    require_once '404.php';
    exit;
}

echo $template->render('pages/post.php', [
    'post' => $post
]);
