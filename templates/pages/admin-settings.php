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
