<?php
  // Security, for if .htaccess does not exist.
  if(!defined("ROOT_PATH")) {
    http_response_code(403);
    // TODO: Implement 403 error page.
    // require_once("403.php");
    exit;
  }
  
  require_once(ROOT_PATH ."includes/functions.php");
  require_once(ROOT_PATH ."includes/class.system.php");
  require_once(ROOT_PATH ."includes/class.template.php");
  require_once(ROOT_PATH ."includes/helpers.php");

  // Initialize error logging
  initErrorLogging();

  $system = new System();
  $template = new Template($system);
