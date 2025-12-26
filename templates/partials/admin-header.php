<header>
    <div class="container">
        <h1>Admin Panel</h1>
        <nav>
            <a href="{{ $system->get_setting('base_url') }}/index.php">View Blog</a>
            <a href="{{ $system->get_setting('base_url') }}/admin/index.php">Manage Posts</a>
            <a href="{{ $system->get_setting('base_url') }}/admin/logs.php">Logs</a>
            <span class="nav-divider">|</span>
            <span class="nav-user">Logged in as: <strong>{{ $current_user['username'] }}</strong></span>
            <a href="{{ $system->get_setting('base_url') }}/admin/logout.php" class="btn-logout">Log Out</a>
        </nav>
    </div>
</header>
