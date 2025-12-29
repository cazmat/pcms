<header class="site-header">
    <div class="header-container">
        <div class="logo">
            <a href="{{ $system->get_setting('base_url') }}">
                <span class="logo-text">{{ $system->get_setting("site_name") }}</span>
            </a>
        </div>
        <nav class="main-nav">
            <a href="{{ $system->get_setting('base_url') }}" class="nav-link">Home</a>

@if(isLoggedIn())
            <div class="user-menu">
                <button class="user-menu-trigger nav-link">
                    <i class="bi bi-person-circle"></i>
                    <span class="user-name">{{ getCurrentUser()['username'] }}</span>
                    <i class="bi bi-chevron-down chevron-icon"></i>
                </button>
                <div class="user-menu-dropdown">
                    <a href="{{ $system->get_setting('base_url') }}/admin" class="dropdown-item">
                        <i class="bi bi-speedometer2"></i>
                        <span>Admin Dashboard</span>
                    </a>
                    <a href="{{ $system->get_setting('base_url') }}/admin/logout.php" class="dropdown-item">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
@else
            <a href="{{ $system->get_setting('base_url') }}/admin/login.php" class="nav-link">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </a>
@endif
        </nav>
  </div>
</header>
