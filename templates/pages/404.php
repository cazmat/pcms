@extends('main.php')

@section('title')
404 - Page Not Found
@endsection

@section('content')
<div class="error-page">
    <div class="error-hero">
        <div class="error-hero-content">
            <!-- 404 Illustration -->
            <div class="error-illustration">
                <svg width="240" height="240" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Magnifying glass looking for content -->
                    <circle cx="90" cy="90" r="50" stroke="currentColor" stroke-width="8" opacity="0.3"/>
                    <line x1="128" y1="128" x2="170" y2="170" stroke="currentColor" stroke-width="8" stroke-linecap="round" opacity="0.3"/>
                    <!-- Question mark -->
                    <path d="M120 60C120 45 130 35 145 35C160 35 170 45 170 60C170 70 165 75 155 80L150 85V95" stroke="currentColor" stroke-width="6" stroke-linecap="round" opacity="0.5"/>
                    <circle cx="150" cy="110" r="5" fill="currentColor" opacity="0.5"/>
                    <!-- 404 Text -->
                    <text x="50%" y="180" text-anchor="middle" font-size="72" font-weight="bold" fill="url(#gradient404)" opacity="0.8">404</text>
                    <defs>
                        <linearGradient id="gradient404" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#8B5CF6;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#F97316;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Error Message -->
            <div class="error-content">
                <h1 class="error-title">Oops! Page Not Found</h1>
                <p class="error-message">
                    The page you're looking for seems to have wandered off. It might have been moved, deleted, or perhaps it never existed.
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
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                            </svg>
                            <span>Check your URL for typos</span>
                        </li>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                            <span>Use the back button in your browser</span>
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
