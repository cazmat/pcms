@extends('admin.php')

@section('title')
Settings
@endsection

@section('content')
<!-- Settings Hero -->
<div class="settings-hero">
    <div class="settings-hero-content">
        <div class="settings-hero-text">
            <h1 class="settings-hero-title">Settings</h1>
            <p class="settings-hero-subtitle">Configure your blog's general settings and preferences</p>
        </div>
        <div class="settings-hero-icon">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3"/>
                <path d="M12 1v6m0 6v6m9.22-15.22l-4.24 4.24m-5.96 5.96L6.78 22.78M23 12h-6m-6 0H1m20.22 9.22l-4.24-4.24m-5.96-5.96L6.78 1.78"/>
            </svg>
        </div>
    </div>
</div>

<!-- Messages -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>{{ $error }}</li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
        {{ $success }}
    </div>
<?php endif; ?>

<form method="POST" class="settings-form" id="settingsForm">
    <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">

    <!-- General Settings Section -->
    <div class="settings-section">
        <div class="settings-section-header">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="2" y1="12" x2="22" y2="12"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            <h2>General Settings</h2>
        </div>

        <!-- Site Name -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="site_name" class="setting-label">Site Name</label>
                    <p class="setting-description">The name of your blog that appears in the header and page titles</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <span class="value-badge value-current">{{ $current['site_name'] }}</span>
                    <?php if ($current['site_name'] !== $defaults['site_name']): ?>
                        <span class="value-badge value-default">Default: {{ $defaults['site_name'] }}</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="text" id="site_name" name="site_name" value="{{ $current['site_name'] }}" required maxlength="100" class="form-input">
                    <?php if ($current['site_name'] !== $defaults['site_name']): ?>
                        <button type="submit" name="reset_field" value="site_name" class="btn-reset-inline" onclick="return confirm('Reset Site Name to default?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Admin Email -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="admin_email" class="setting-label">Admin Email</label>
                    <p class="setting-description">Email address for administrative notifications</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <span class="value-badge value-current">{{ $current['admin_email'] }}</span>
                    <?php if ($current['admin_email'] !== $defaults['admin_email']): ?>
                        <span class="value-badge value-default">Default: {{ $defaults['admin_email'] }}</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="email" id="admin_email" name="admin_email" value="{{ $current['admin_email'] }}" required class="form-input">
                    <?php if ($current['admin_email'] !== $defaults['admin_email']): ?>
                        <button type="submit" name="reset_field" value="admin_email" class="btn-reset-inline" onclick="return confirm('Reset Admin Email to default?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Base URL -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="base_url" class="setting-label">Base URL</label>
                    <p class="setting-description">The base URL of your blog (without trailing slash)</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <span class="value-badge value-current">{{ $current['base_url'] }}</span>
                    <?php if ($current['base_url'] !== $defaults['base_url']): ?>
                        <span class="value-badge value-default">Default: {{ $defaults['base_url'] }}</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="url" id="base_url" name="base_url" value="{{ $current['base_url'] }}" required class="form-input">
                    <?php if ($current['base_url'] !== $defaults['base_url']): ?>
                        <button type="submit" name="reset_field" value="base_url" class="btn-reset-inline" onclick="return confirm('Reset Base URL to default?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Settings Section -->
    <div class="settings-section">
        <div class="settings-section-header">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                <line x1="8" y1="21" x2="16" y2="21"/>
                <line x1="12" y1="17" x2="12" y2="21"/>
            </svg>
            <h2>Display Settings</h2>
        </div>

        <!-- Posts Per Page -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="blog_ppp" class="setting-label">Posts Per Page</label>
                    <p class="setting-description">Number of posts to display on each page (5-50)</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <span class="value-badge value-current">{{ $current['blog_ppp'] }} posts</span>
                    <?php if ($current['blog_ppp'] !== $defaults['blog_ppp']): ?>
                        <span class="value-badge value-default">Default: {{ $defaults['blog_ppp'] }}</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="number" id="blog_ppp" name="blog_ppp" value="{{ $current['blog_ppp'] }}" min="5" max="50" required class="form-input">
                    <?php if ($current['blog_ppp'] !== $defaults['blog_ppp']): ?>
                        <button type="submit" name="reset_field" value="blog_ppp" class="btn-reset-inline" onclick="return confirm('Reset Posts Per Page to default?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Timezone -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="timezone" class="setting-label">Timezone</label>
                    <p class="setting-description">The timezone used for displaying dates and times</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <span class="value-badge value-current">{{ $current['timezone'] }}</span>
                    <?php if ($current['timezone'] !== $defaults['timezone']): ?>
                        <span class="value-badge value-default">Default: {{ $defaults['timezone'] }}</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <select id="timezone" name="timezone" class="form-select">
                        <?php foreach ($timezones as $value => $label): ?>
                            <option value="{{ $value }}" <?php echo $current['timezone'] === $value ? 'selected' : ''; ?>>
                                {{ $label }}
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($current['timezone'] !== $defaults['timezone']): ?>
                        <button type="submit" name="reset_field" value="timezone" class="btn-reset-inline" onclick="return confirm('Reset Timezone to default?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Date Format -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="date_format" class="setting-label">Date Format</label>
                    <p class="setting-description">How dates are displayed throughout the site</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <span class="value-badge value-current"><?php echo date($current['date_format']); ?></span>
                    <?php if ($current['date_format'] !== $defaults['date_format']): ?>
                        <span class="value-badge value-default">Default: <?php echo date($defaults['date_format']); ?></span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <select id="date_format" name="date_format" class="form-select">
                        <?php foreach ($dateFormats as $format => $example): ?>
                            <option value="{{ $format }}" <?php echo $current['date_format'] === $format ? 'selected' : ''; ?>>
                                {{ $example }}
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($current['date_format'] !== $defaults['date_format']): ?>
                        <button type="submit" name="reset_field" value="date_format" class="btn-reset-inline" onclick="return confirm('Reset Date Format to default?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Settings Section -->
    <div class="settings-section">
        <div class="settings-section-header">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polyline points="16 18 22 12 16 6"/>
                <polyline points="8 6 2 12 8 18"/>
            </svg>
            <h2>Technical Settings</h2>
        </div>

        <!-- Maintenance Mode -->
        <div class="setting-card setting-card-toggle">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="maintenance" class="setting-label">Maintenance Mode</label>
                    <p class="setting-description">Only logged-in administrators can access the site</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-toggle-row">
                    <div class="setting-value-display">
                        <span class="value-badge <?php echo $current['maintenance'] ? 'value-enabled' : 'value-disabled'; ?>">
                            <?php echo $current['maintenance'] ? 'Enabled' : 'Disabled'; ?>
                        </span>
                    </div>
                    <div class="setting-control-toggle">
                        <label class="toggle-switch">
                            <input type="checkbox" id="maintenance" name="maintenance" value="1" <?php echo $current['maintenance'] ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <?php if ($current['maintenance'] !== $defaults['maintenance']): ?>
                            <button type="submit" name="reset_field" value="maintenance" class="btn-reset-inline" onclick="return confirm('Reset Maintenance Mode to default?')" title="Reset to default">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                                </svg>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pretty URLs -->
        <div class="setting-card setting-card-toggle">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="pretty_url" class="setting-label">Pretty URLs</label>
                    <p class="setting-description">Enable SEO-friendly URLs (requires mod_rewrite)</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-toggle-row">
                    <div class="setting-value-display">
                        <span class="value-badge <?php echo $current['pretty_url'] ? 'value-enabled' : 'value-disabled'; ?>">
                            <?php echo $current['pretty_url'] ? 'Enabled' : 'Disabled'; ?>
                        </span>
                    </div>
                    <div class="setting-control-toggle">
                        <label class="toggle-switch">
                            <input type="checkbox" id="pretty_url" name="pretty_url" value="1" <?php echo $current['pretty_url'] ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <?php if ($current['pretty_url'] !== $defaults['pretty_url']): ?>
                            <button type="submit" name="reset_field" value="pretty_url" class="btn-reset-inline" onclick="return confirm('Reset Pretty URLs to default?')" title="Reset to default">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                                </svg>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Settings Section -->
    <div class="settings-section">
        <div class="settings-section-header">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
            </svg>
            <h2>Social Media</h2>
        </div>

        <!-- GitHub -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="social_github" class="setting-label">GitHub</label>
                    <p class="setting-description">Your GitHub profile URL</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <?php if (!empty($current['social_github'])): ?>
                        <span class="value-badge value-current">{{ $current['social_github'] }}</span>
                    <?php else: ?>
                        <span class="value-badge value-disabled">Not set</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="url" id="social_github" name="social_github" value="{{ $current['social_github'] }}" placeholder="https://github.com/username" class="form-input">
                    <?php if ($current['social_github'] !== $defaults['social_github']): ?>
                        <button type="submit" name="reset_field" value="social_github" class="btn-reset-inline" onclick="return confirm('Clear GitHub URL?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Twitter -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="social_twitter" class="setting-label">Twitter/X</label>
                    <p class="setting-description">Your Twitter/X profile URL</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <?php if (!empty($current['social_twitter'])): ?>
                        <span class="value-badge value-current">{{ $current['social_twitter'] }}</span>
                    <?php else: ?>
                        <span class="value-badge value-disabled">Not set</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="url" id="social_twitter" name="social_twitter" value="{{ $current['social_twitter'] }}" placeholder="https://twitter.com/username" class="form-input">
                    <?php if ($current['social_twitter'] !== $defaults['social_twitter']): ?>
                        <button type="submit" name="reset_field" value="social_twitter" class="btn-reset-inline" onclick="return confirm('Clear Twitter URL?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- LinkedIn -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="social_linked" class="setting-label">LinkedIn</label>
                    <p class="setting-description">Your LinkedIn profile URL</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <?php if (!empty($current['social_linked'])): ?>
                        <span class="value-badge value-current">{{ $current['social_linked'] }}</span>
                    <?php else: ?>
                        <span class="value-badge value-disabled">Not set</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="url" id="social_linked" name="social_linked" value="{{ $current['social_linked'] }}" placeholder="https://linkedin.com/in/username" class="form-input">
                    <?php if ($current['social_linked'] !== $defaults['social_linked']): ?>
                        <button type="submit" name="reset_field" value="social_linked" class="btn-reset-inline" onclick="return confirm('Clear LinkedIn URL?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Instagram -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="social_insta" class="setting-label">Instagram</label>
                    <p class="setting-description">Your Instagram profile URL</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <?php if (!empty($current['social_insta'])): ?>
                        <span class="value-badge value-current">{{ $current['social_insta'] }}</span>
                    <?php else: ?>
                        <span class="value-badge value-disabled">Not set</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="url" id="social_insta" name="social_insta" value="{{ $current['social_insta'] }}" placeholder="https://instagram.com/username" class="form-input">
                    <?php if ($current['social_insta'] !== $defaults['social_insta']): ?>
                        <button type="submit" name="reset_field" value="social_insta" class="btn-reset-inline" onclick="return confirm('Clear Instagram URL?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Twitch -->
        <div class="setting-card">
            <div class="setting-card-header">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714Z"/>
                    </svg>
                </div>
                <div class="setting-header-text">
                    <label for="social_twitch" class="setting-label">Twitch</label>
                    <p class="setting-description">Your Twitch channel URL</p>
                </div>
            </div>
            <div class="setting-card-body">
                <div class="setting-value-display">
                    <?php if (!empty($current['social_twitch'])): ?>
                        <span class="value-badge value-current">{{ $current['social_twitch'] }}</span>
                    <?php else: ?>
                        <span class="value-badge value-disabled">Not set</span>
                    <?php endif; ?>
                </div>
                <div class="setting-control">
                    <input type="url" id="social_twitch" name="social_twitch" value="{{ $current['social_twitch'] }}" placeholder="https://twitch.tv/username" class="form-input">
                    <?php if ($current['social_twitch'] !== $defaults['social_twitch']): ?>
                        <button type="submit" name="reset_field" value="social_twitch" class="btn-reset-inline" onclick="return confirm('Clear Twitch URL?')" title="Reset to default">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="settings-actions">
        <button type="submit" name="save_settings" class="btn btn-primary btn-large">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
            Save All Settings
        </button>
        <button type="submit" name="reset_all" class="btn btn-danger btn-large" onclick="return confirm('Are you sure you want to reset ALL settings to their default values? This cannot be undone.')">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
            </svg>
            Reset All to Defaults
        </button>
        <a href="{{ $system->get_setting('base_url') }}/admin" class="btn btn-secondary btn-large">
            Cancel
        </a>
    </div>
</form>
@endsection
