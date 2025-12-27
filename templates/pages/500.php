@extends('main.php')

@section('title')
500 - Server Error
@endsection

@section('content')
<div class="error-page">
    <div class="error-hero">
        <div class="error-hero-content">
            <!-- 500 Illustration -->
            <div class="error-illustration">
                <svg width="240" height="240" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Server/Computer Icon -->
                    <rect x="50" y="50" width="140" height="100" rx="8" stroke="currentColor" stroke-width="6" opacity="0.3"/>
                    <line x1="70" y1="80" x2="170" y2="80" stroke="currentColor" stroke-width="4" opacity="0.3"/>
                    <line x1="70" y1="100" x2="150" y2="100" stroke="currentColor" stroke-width="4" opacity="0.3"/>
                    <line x1="70" y1="120" x2="130" y2="120" stroke="currentColor" stroke-width="4" opacity="0.3"/>

                    <!-- Alert/Warning Icon -->
                    <circle cx="120" cy="95" r="35" fill="url(#gradient500)" opacity="0.9"/>
                    <path d="M120 80 L120 100 M120 110 L120 112" stroke="white" stroke-width="6" stroke-linecap="round"/>

                    <!-- 500 Text -->
                    <text x="50%" y="200" text-anchor="middle" font-size="56" font-weight="bold" fill="url(#gradient500text)" opacity="0.8">500</text>

                    <defs>
                        <linearGradient id="gradient500" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#EF4444;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#F97316;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="gradient500text" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#8B5CF6;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#F97316;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Error Message -->
            <div class="error-content">
                <h1 class="error-title">Something Went Wrong</h1>
                <p class="error-message">
                    Our server encountered an unexpected error and couldn't complete your request. We've been notified and are working on a fix.
                </p>

                <!-- Suggestions -->
                <div class="error-suggestions">
                    <h3>What you can try:</h3>
                    <ul>
                        <li>
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <polyline points="23 4 23 10 17 10"/>
                                <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                            </svg>
                            <span>Refresh the page and try again</span>
                        </li>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                            <span>Wait a few minutes and come back</span>
                        </li>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                            </svg>
                            <span>Return to the homepage</span>
                        </li>
                    </ul>
                </div>

                <!-- Technical Details (for admins) -->
                <div class="error-technical">
                    <details>
                        <summary>Technical Details</summary>
                        <div class="error-technical-content">
                            <p><strong>Error Code:</strong> 500 Internal Server Error</p>
                            <p><strong>Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                            <p><strong>Request:</strong> <?php echo e($_SERVER['REQUEST_URI'] ?? 'Unknown'); ?></p>
                            <p class="error-help-text">If this error persists, please contact the site administrator.</p>
                        </div>
                    </details>
                </div>

                <!-- Action Buttons -->
                <div class="error-actions">
                    <a href="{{ $system->get_setting('base_url') }}/index.php" class="btn btn-primary btn-large">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                        Go to Homepage
                    </a>
                    <a href="javascript:location.reload()" class="btn btn-secondary btn-large">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <polyline points="23 4 23 10 17 10"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Refresh Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
