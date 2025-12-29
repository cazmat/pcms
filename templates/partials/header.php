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
      <div>
        <a class='nav-link'>
          <i class="bi bi-file-person-fill"></i>
        </a>
        <div>
          <span>{{ getCurrentUser()['username'] }}</span>
          <a href="{{ $system->get_setting('base_url') }}/admin" class="nav-link">Admin</a>
        </div>
      </div>
@else
      <a href=''>Login</a>
@endif
    </nav>
  </div>
</header>
