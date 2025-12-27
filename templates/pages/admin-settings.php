@extends('admin.php')

@section('title')
Settings
@endsection

@section('content')
<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>{{ $error }}</li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        {{ $success }}
    </div>
<?php endif; ?>

<div class="settings-header">
    <h2>Site Settings</h2>
    <p class="settings-subtitle">Configure your blog's general settings</p>
</div>

<form method="POST" class="settings-form" id="settingsForm">
    <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">

    <!-- Site Name -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="site_name" class="setting-label">Site Name</label>
            <p class="setting-description">The name of your blog that appears in the header and page titles</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong>{{ $current['site_name'] }}</strong></span>
                <span class="setting-default">Default: <strong>{{ $defaults['site_name'] }}</strong></span>
            </div>
        </div>
        <div class="setting-control">
            <input type="text" id="site_name" name="site_name" value="{{ $current['site_name'] }}" required maxlength="100" class="form-input">
            <?php if ($current['site_name'] !== $defaults['site_name']): ?>
                <button type="submit" name="reset_field" value="site_name" class="btn-reset" onclick="return confirm('Reset Site Name to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Admin Email -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="admin_email" class="setting-label">Admin Email</label>
            <p class="setting-description">Email address for administrative notifications</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong>{{ $current['admin_email'] }}</strong></span>
                <span class="setting-default">Default: <strong>{{ $defaults['admin_email'] }}</strong></span>
            </div>
        </div>
        <div class="setting-control">
            <input type="email" id="admin_email" name="admin_email" value="{{ $current['admin_email'] }}" required class="form-input">
            <?php if ($current['admin_email'] !== $defaults['admin_email']): ?>
                <button type="submit" name="reset_field" value="admin_email" class="btn-reset" onclick="return confirm('Reset Admin Email to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Base URL -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="base_url" class="setting-label">Base URL</label>
            <p class="setting-description">The base URL of your blog (without trailing slash)</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong>{{ $current['base_url'] }}</strong></span>
                <span class="setting-default">Default: <strong>{{ $defaults['base_url'] }}</strong></span>
            </div>
        </div>
        <div class="setting-control">
            <input type="url" id="base_url" name="base_url" value="{{ $current['base_url'] }}" required class="form-input">
            <?php if ($current['base_url'] !== $defaults['base_url']): ?>
                <button type="submit" name="reset_field" value="base_url" class="btn-reset" onclick="return confirm('Reset Base URL to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Posts Per Page -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="blog_ppp" class="setting-label">Posts Per Page</label>
            <p class="setting-description">Number of posts to display on each page (minimum: 5, maximum: 50)</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong>{{ $current['blog_ppp'] }}</strong></span>
                <span class="setting-default">Default: <strong>{{ $defaults['blog_ppp'] }}</strong></span>
            </div>
        </div>
        <div class="setting-control">
            <input type="number" id="blog_ppp" name="blog_ppp" value="{{ $current['blog_ppp'] }}" min="5" max="50" required class="form-input">
            <?php if ($current['blog_ppp'] !== $defaults['blog_ppp']): ?>
                <button type="submit" name="reset_field" value="blog_ppp" class="btn-reset" onclick="return confirm('Reset Posts Per Page to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Timezone -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="timezone" class="setting-label">Timezone</label>
            <p class="setting-description">The timezone used for displaying dates and times</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong>{{ $current['timezone'] }}</strong></span>
                <span class="setting-default">Default: <strong>{{ $defaults['timezone'] }}</strong></span>
            </div>
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
                <button type="submit" name="reset_field" value="timezone" class="btn-reset" onclick="return confirm('Reset Timezone to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Date Format -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="date_format" class="setting-label">Date Format</label>
            <p class="setting-description">How dates are displayed throughout the site</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong>{{ $current['date_format'] }}</strong></span>
                <span class="setting-default">Default: <strong>{{ $defaults['date_format'] }}</strong></span>
            </div>
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
                <button type="submit" name="reset_field" value="date_format" class="btn-reset" onclick="return confirm('Reset Date Format to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Maintenance Mode -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="maintenance" class="setting-label">Maintenance Mode</label>
            <p class="setting-description">When enabled, only logged-in administrators can access the site</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong><?php echo $current['maintenance'] ? 'Enabled' : 'Disabled'; ?></strong></span>
                <span class="setting-default">Default: <strong><?php echo $defaults['maintenance'] ? 'Enabled' : 'Disabled'; ?></strong></span>
            </div>
        </div>
        <div class="setting-control">
            <label class="toggle-switch">
                <input type="checkbox" id="maintenance" name="maintenance" value="1" <?php echo $current['maintenance'] ? 'checked' : ''; ?>>
                <span class="toggle-slider"></span>
            </label>
            <?php if ($current['maintenance'] !== $defaults['maintenance']): ?>
                <button type="submit" name="reset_field" value="maintenance" class="btn-reset" onclick="return confirm('Reset Maintenance Mode to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pretty URLs -->
    <div class="setting-item">
        <div class="setting-info">
            <label for="pretty_url" class="setting-label">Pretty URLs</label>
            <p class="setting-description">Enable SEO-friendly URLs (requires mod_rewrite)</p>
            <div class="setting-values">
                <span class="setting-current">Current: <strong><?php echo $current['pretty_url'] ? 'Enabled' : 'Disabled'; ?></strong></span>
                <span class="setting-default">Default: <strong><?php echo $defaults['pretty_url'] ? 'Enabled' : 'Disabled'; ?></strong></span>
            </div>
        </div>
        <div class="setting-control">
            <label class="toggle-switch">
                <input type="checkbox" id="pretty_url" name="pretty_url" value="1" <?php echo $current['pretty_url'] ? 'checked' : ''; ?>>
                <span class="toggle-slider"></span>
            </label>
            <?php if ($current['pretty_url'] !== $defaults['pretty_url']): ?>
                <button type="submit" name="reset_field" value="pretty_url" class="btn-reset" onclick="return confirm('Reset Pretty URLs to default?')">
                    Reset to Default
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="settings-actions">
        <button type="submit" name="save_settings" class="btn btn-primary">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
            Save Settings
        </button>
        <button type="submit" name="reset_all" class="btn btn-danger" onclick="return confirm('Are you sure you want to reset ALL settings to their default values? This cannot be undone.')">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
            </svg>
            Reset All to Defaults
        </button>
        <a href="{{ $system->get_setting('base_url') }}/admin/index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
