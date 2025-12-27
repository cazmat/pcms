<header class="admin-header">
    <div class="admin-header-container">
        <div class="admin-logo">
            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-4 0-7-3-7-7V8.3l7-3.11 7 3.11V13c0 4-3 7-7 7zm-1-9h2v2h-2v-2zm0-4h2v3h-2V7z"/>
            </svg>
            <span class="admin-logo-text">Admin Panel</span>
        </div>

        <nav class="admin-nav">
            <div class="admin-nav-links">
                <a href="{{ $system->get_setting('base_url') }}/admin/index.php" class="admin-nav-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ $system->get_setting('base_url') }}/admin/edit.php" class="admin-nav-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    <span>New Post</span>
                </a>
                <a href="{{ $system->get_setting('base_url') }}/admin/logs.php" class="admin-nav-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    <span>Logs</span>
                </a>
                <a href="{{ $system->get_setting('base_url') }}/admin/settings.php" class="admin-nav-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M12 1v6m0 6v6m9.22-15.22l-4.24 4.24m-5.96 5.96L6.78 22.78M23 12h-6m-6 0H1m20.22 9.22l-4.24-4.24m-5.96-5.96L6.78 1.78"/>
                    </svg>
                    <span>Settings</span>
                </a>
                <a href="{{ $system->get_setting('base_url') }}/index.php" class="admin-nav-link admin-nav-view-site">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span>View Site</span>
                </a>
            </div>

            <div class="admin-nav-user">
                <span class="admin-user-info">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span class="admin-username">{{ $current_user['username'] }}</span>
                </span>
                <a href="{{ $system->get_setting('base_url') }}/admin/logout.php" class="admin-logout-btn">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Log Out</span>
                </a>
            </div>
        </nav>
    </div>
</header>
