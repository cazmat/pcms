<header class="site-header">
    <div class="header-container">
        <div class="logo">
            <a href="{{ $system->get_setting('base_url') }}">
                <span class="logo-text">{{ $system->get_setting("site_name") }}</span>
            </a>
        </div>
        <nav class="main-nav">
            <a href="{{ $system->get_setting('base_url') }}" class="nav-link">Home</a>
            <a href="{{ $system->get_setting('base_url') }}/admin" class="nav-link">Admin</a>
        </nav>
    </div>
</header>
