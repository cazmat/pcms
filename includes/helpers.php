<?php
/**
 * Check and display the Coming Soon page if enabled
 *
 * Redirects non-logged-in users to a coming soon page when the site
 * is in coming soon mode. Administrators can still access the site.
 */
function showComingSoon() {
    global $system, $template;

    if ($system->get_setting('coming_soon') && !isLoggedIn()) {
        echo $template->render('pages/coming-soon.php');
        exit;
    }
}

/**
 * Check and display the Maintenance page if enabled
 *
 * Redirects non-logged-in users to a maintenance page when the site
 * is in maintenance mode. Administrators can still access the site.
 */
function showMaintenance() {
    global $system;

    if ($system->get_setting('maintenance') && !isLoggedIn()) {
        require_once ROOT_PATH . 'maintenance.php';
        exit;
    }
}
