<?php
define("ROOT_PATH", "../");

require_once(ROOT_PATH ."includes/init.php");
require_once __DIR__ . '/../includes/functions.php';

// Require authentication
requireAuth();

$current_user = getCurrentUser();
$errors = [];
$success = '';

// Get current and default settings
$currentSettings = $system->get_all_settings();
$defaultSettings = $system->get_default_settings();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if (!validateCSRFToken($csrf_token)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    if (empty($errors)) {
        // Handle Reset All action
        if (isset($_POST['reset_all'])) {
            foreach ($defaultSettings as $key => $value) {
                $system->set_setting($key, $value);
            }

            if ($system->save_settings()) {
                redirect('settings.php?reset_all=1');
            } else {
                $errors[] = 'Failed to reset settings to defaults';
            }
        }
        // Handle individual field reset
        elseif (isset($_POST['reset_field'])) {
            $field = $_POST['reset_field'];
            if (isset($defaultSettings[$field])) {
                $system->set_setting($field, $defaultSettings[$field]);

                if ($system->save_settings()) {
                    redirect("settings.php?reset=$field");
                } else {
                    $errors[] = 'Failed to reset setting';
                }
            }
        }
        // Handle save settings
        elseif (isset($_POST['save_settings'])) {
            // Validate and sanitize inputs
            $site_name = trim($_POST['site_name'] ?? '');
            $admin_email = trim($_POST['admin_email'] ?? '');
            $base_url = trim($_POST['base_url'] ?? '');
            $blog_ppp = intval($_POST['blog_ppp'] ?? 10);
            $timezone = trim($_POST['timezone'] ?? 'UTC');
            $date_format = trim($_POST['date_format'] ?? 'F j, Y');
            $maintenance = isset($_POST['maintenance']) && $_POST['maintenance'] === '1';
            $pretty_url = isset($_POST['pretty_url']) && $_POST['pretty_url'] === '1';

            // Social media links
            $social_github = trim($_POST['social_github'] ?? '');
            $social_insta = trim($_POST['social_insta'] ?? '');
            $social_linked = trim($_POST['social_linked'] ?? '');
            $social_twitch = trim($_POST['social_twitch'] ?? '');
            $social_twitter = trim($_POST['social_twitter'] ?? '');

            // Validation
            if (empty($site_name)) {
                $errors[] = 'Site name is required';
            } elseif (strlen($site_name) > 100) {
                $errors[] = 'Site name must not exceed 100 characters';
            }

            if (empty($admin_email)) {
                $errors[] = 'Admin email is required';
            } elseif (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Admin email must be a valid email address';
            }

            if (empty($base_url)) {
                $errors[] = 'Base URL is required';
            } elseif (!filter_var($base_url, FILTER_VALIDATE_URL)) {
                $errors[] = 'Base URL must be a valid URL';
            }

            if ($blog_ppp < 5 || $blog_ppp > 50) {
                $errors[] = 'Posts per page must be between 5 and 50';
            }

            if (empty($timezone)) {
                $errors[] = 'Timezone is required';
            }

            if (empty($date_format)) {
                $errors[] = 'Date format is required';
            }

            // Validate social media URLs (optional, but must be valid if provided)
            if (!empty($social_github) && !filter_var($social_github, FILTER_VALIDATE_URL)) {
                $errors[] = 'GitHub URL must be a valid URL';
            }
            if (!empty($social_insta) && !filter_var($social_insta, FILTER_VALIDATE_URL)) {
                $errors[] = 'Instagram URL must be a valid URL';
            }
            if (!empty($social_linked) && !filter_var($social_linked, FILTER_VALIDATE_URL)) {
                $errors[] = 'LinkedIn URL must be a valid URL';
            }
            if (!empty($social_twitch) && !filter_var($social_twitch, FILTER_VALIDATE_URL)) {
                $errors[] = 'Twitch URL must be a valid URL';
            }
            if (!empty($social_twitter) && !filter_var($social_twitter, FILTER_VALIDATE_URL)) {
                $errors[] = 'Twitter URL must be a valid URL';
            }

            // If no errors, save settings
            if (empty($errors)) {
                $system->set_setting('site_name', sanitizePlainText($site_name));
                $system->set_setting('admin_email', $admin_email);
                $system->set_setting('base_url', rtrim($base_url, '/'));
                $system->set_setting('blog_ppp', $blog_ppp);
                $system->set_setting('timezone', $timezone);
                $system->set_setting('date_format', $date_format);
                $system->set_setting('maintenance', $maintenance);
                $system->set_setting('pretty_url', $pretty_url);

                // Save social media links
                $system->set_setting('social_github', $social_github);
                $system->set_setting('social_insta', $social_insta);
                $system->set_setting('social_linked', $social_linked);
                $system->set_setting('social_twitch', $social_twitch);
                $system->set_setting('social_twitter', $social_twitter);

                if ($system->save_settings()) {
                    redirect('settings.php?saved=1');
                } else {
                    $errors[] = 'Failed to save settings';
                }
            }
        }
    }
}

// Handle success messages from redirects
if (isset($_GET['saved'])) {
    $success = 'Settings saved successfully!';
}
if (isset($_GET['reset_all'])) {
    $success = 'All settings have been reset to defaults!';
}
if (isset($_GET['reset'])) {
    $fieldName = ucfirst(str_replace('_', ' ', $_GET['reset']));
    $success = "$fieldName has been reset to default!";
}

// Reload settings after save/reset
$currentSettings = $system->get_all_settings();

// Get list of common timezones
$timezones = [
    'UTC' => 'UTC (Coordinated Universal Time)',
    'America/New_York' => 'Eastern Time (US & Canada)',
    'America/Chicago' => 'Central Time (US & Canada)',
    'America/Denver' => 'Mountain Time (US & Canada)',
    'America/Los_Angeles' => 'Pacific Time (US & Canada)',
    'America/Phoenix' => 'Arizona',
    'America/Anchorage' => 'Alaska',
    'Pacific/Honolulu' => 'Hawaii',
    'Europe/London' => 'London',
    'Europe/Paris' => 'Paris',
    'Europe/Berlin' => 'Berlin',
    'Europe/Rome' => 'Rome',
    'Europe/Madrid' => 'Madrid',
    'Europe/Moscow' => 'Moscow',
    'Asia/Dubai' => 'Dubai',
    'Asia/Karachi' => 'Karachi',
    'Asia/Kolkata' => 'India',
    'Asia/Shanghai' => 'Beijing, Shanghai',
    'Asia/Tokyo' => 'Tokyo',
    'Asia/Seoul' => 'Seoul',
    'Asia/Singapore' => 'Singapore',
    'Australia/Sydney' => 'Sydney',
    'Pacific/Auckland' => 'Auckland'
];

// Get list of common date formats with examples
$dateFormats = [
    'F j, Y' => 'December 27, 2025',
    'Y-m-d' => '2025-12-27',
    'm/d/Y' => '12/27/2025',
    'd/m/Y' => '27/12/2025',
    'M j, Y' => 'Dec 27, 2025',
    'j F Y' => '27 December 2025',
    'D, M j, Y' => 'Sat, Dec 27, 2025',
    'l, F j, Y' => 'Saturday, December 27, 2025'
];

echo $template->render('pages/admin-settings.php', [
    'errors' => $errors,
    'success' => $success,
    'current' => $currentSettings,
    'defaults' => $defaultSettings,
    'current_user' => $current_user,
    'csrf_token' => getCSRFToken(),
    'timezones' => $timezones,
    'dateFormats' => $dateFormats
]);
