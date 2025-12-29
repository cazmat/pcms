@extends('main.php')

@section('title')
403 - Access Forbidden
@endsection

@section('content')
<div class="error-page">
    <div class="error-hero">
        <div class="error-hero-content">
            <!-- 403 Illustration -->
            <div class="error-illustration">
                <svg width="240" height="240" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Lock icon -->
                    <rect x="80" y="100" width="80" height="90" rx="8" stroke="currentColor" stroke-width="8" opacity="0.3"/>
                    <path d="M100 100V70C100 58 106 50 120 50C134 50 140 58 140 70V100" stroke="currentColor" stroke-width="8" stroke-linecap="round" opacity="0.3"/>
                    <!-- Keyhole -->
                    <circle cx="120" cy="135" r="8" fill="currentColor" opacity="0.5"/>
                    <rect x="116" y="135" width="8" height="20" rx="2" fill="currentColor" opacity="0.5"/>
                    <!-- 403 Text -->
                    <text x="50%" y="210" text-anchor="middle" font-size="72" font-weight="bold" fill="url(#gradient403)" opacity="0.8">403</text>
                    <defs>
                        <linearGradient id="gradient403" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#DC2626;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#EA580C;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#F59E0B;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Error Message -->
            <div class="error-content">
                <h1 class="error-title">Access Forbidden</h1>
                <p class="error-message">
                    You don't have permission to access this resource. This area may be restricted or require authentication.
                </p>

                <!-- Search Suggestions -->
                <div class="error-suggestions">
                    <h3>Here's what you can do:</h3>
                    <ul>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                            </svg>
                            <span>Return to the <a href="{{ $system->get_setting('base_url') }}/index.php">homepage</a></span>
                        </li>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <span>Log in if you have an account with the required permissions</span>
                        </li>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <span>Contact the site administrator if you believe this is an error</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="error-actions">
                    <a href="{{ $system->get_setting('base_url') }}/index.php" class="btn btn-primary btn-large">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                        Go to Homepage
                    </a>
                    <a href="javascript:history.back()" class="btn btn-secondary btn-large">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
