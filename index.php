<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/includes/functions.php';

$posts = getAllPosts();

echo $template->render('pages/home.php', [
    'posts' => $posts
]);
