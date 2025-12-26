<?php
define("ROOT_PATH", "../");

require_once(ROOT_PATH ."includes/init.php");

// Require authentication
requireAuth();

$current_user = getCurrentUser();

// Get all log files
$logFiles = getLogFiles();

// Determine which log file to display
$currentLogFile = $_GET['file'] ?? null;

if ($currentLogFile === null && !empty($logFiles)) {
    // Default to the most recent log file
    $currentLogFile = basename($logFiles[0]);
}

// Read log contents
$logContents = '';
if ($currentLogFile) {
    $logPath = ROOT_PATH . 'includes/logs/' . basename($currentLogFile);
    if (file_exists($logPath)) {
        $logContents = readLogFile($logPath);
    }
}

// Get environment
$environment = getEnvironment();

echo $template->render('pages/admin-logs.php', [
    'logFiles' => array_map('basename', $logFiles),
    'currentLogFile' => $currentLogFile,
    'logContents' => $logContents,
    'environment' => $environment,
    'current_user' => $current_user
]);
