<?php
define("ROOT_PATH", "./");

require_once(ROOT_PATH . "includes/init.php");
require_once __DIR__ . '/includes/functions.php';

// Set proper HTTP status code
http_response_code(500);

echo $template->render('pages/500.php', [
    'page_title' => 'Server Error'
]);
