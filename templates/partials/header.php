<header>
    <div class="container">
        <h1>{{ $system->get_setting("site_name") }}</h1>
        <nav>
            <a href="{{ $system->get_setting('base_url') }}">Home</a>
            <a href="{{ $system->get_setting('base_url') }}/admin/index.php">Admin</a>
        </nav>
    </div>
</header>
