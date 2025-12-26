<?php
require_once __DIR__ . '/config.php';

// Enable MySQLi exception mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Global database connection
$db = null;

/**
 * Get database connection
 */
function getDB() {
    global $db;

    if ($db === null) {
        try {
            $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $db->set_charset('utf8mb4');
        } catch (mysqli_sql_exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    return $db;
}

/**
 * Close database connection
 */
function closeDB() {
    global $db;
    if ($db !== null) {
        $db->close();
        $db = null;
    }
}
