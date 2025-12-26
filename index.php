<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/includes/functions.php';

// Check for maintenance mode
if ($system->get_setting('maintenance') && !isLoggedIn()) {
    require_once 'maintenance.php';
    exit;
}

$posts = getAllPosts();

echo $template->render('pages/home.php', [
    'posts' => $posts
]);
