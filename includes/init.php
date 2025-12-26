<?php
  // Security, for if .htaccess does not exist.
  if(!defined("ROOT_PATH")) {
    http_response_code(403);
    // TODO: Implement 403 error page.
    // require_once("403.php");
    exit;
  }
  
  require_once(ROOT_PATH ."includes/class.system.php");
  
  $system = new System();
