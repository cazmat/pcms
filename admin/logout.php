<?php
require_once __DIR__ . '/../includes/functions.php';

// Perform logout
logout();

// Redirect to login page
redirect('login.php');
