<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH . "includes/init.php");
require_once __DIR__ . '/includes/functions.php';

// Set proper HTTP status code
http_response_code(404);

echo $template->render('pages/404.php', [
    'page_title' => 'Page Not Found'
]);
