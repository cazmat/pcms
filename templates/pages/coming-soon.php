@extends('main.php')

@section('title')
Coming Soon
@endsection

@section('content')
<div class="error-page">
    <div class="error-hero">
        <div class="error-hero-content">
            <!-- Coming Soon Illustration -->
            <div class="error-illustration">
                <svg width="240" height="240" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Rocket launching -->
                    <g transform="translate(120, 120)">
                        <!-- Rocket body -->
                        <path d="M-20,-60 L-20,-20 Q-20,0 -10,10 L10,10 Q20,0 20,-20 L20,-60 Q20,-80 0,-80 Q-20,-80 -20,-60 Z"
                              fill="url(#gradientRocket)" opacity="0.9"/>
                        <!-- Window -->
                        <circle cx="0" cy="-40" r="12" fill="white" opacity="0.3"/>
                        <!-- Left fin -->
                        <path d="M-20,-20 L-35,-10 L-20,0 Z" fill="url(#gradientFin)" opacity="0.8"/>
                        <!-- Right fin -->
                        <path d="M20,-20 L35,-10 L20,0 Z" fill="url(#gradientFin)" opacity="0.8"/>
                        <!-- Flames -->
                        <path d="M-15,10 Q-10,25 -8,35 L-8,10 Z" fill="#F97316" opacity="0.6">
                            <animate attributeName="opacity" values="0.6;0.8;0.6" dur="0.5s" repeatCount="indefinite"/>
                        </path>
                        <path d="M-3,10 Q0,30 0,40 L0,10 Z" fill="#F59E0B" opacity="0.7">
                            <animate attributeName="opacity" values="0.7;0.9;0.7" dur="0.6s" repeatCount="indefinite"/>
                        </path>
                        <path d="M8,10 Q10,25 8,35 L8,10 Z" fill="#F97316" opacity="0.6">
                            <animate attributeName="opacity" values="0.6;0.8;0.6" dur="0.5s" repeatCount="indefinite"/>
                        </path>
                    </g>
                    <!-- Stars -->
                    <circle cx="40" cy="40" r="2" fill="#3B82F6" opacity="0.5">
                        <animate attributeName="opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="200" cy="60" r="2" fill="#8B5CF6" opacity="0.5">
                        <animate attributeName="opacity" values="0.5;1;0.5" dur="2.5s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="60" cy="200" r="2" fill="#F97316" opacity="0.5">
                        <animate attributeName="opacity" values="0.5;1;0.5" dur="3s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="180" cy="190" r="2" fill="#3B82F6" opacity="0.5">
                        <animate attributeName="opacity" values="0.5;1;0.5" dur="2.2s" repeatCount="indefinite"/>
                    </circle>

                    <defs>
                        <linearGradient id="gradientRocket" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#8B5CF6;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#F97316;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="gradientFin" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#6366F1;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#8B5CF6;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Coming Soon Message -->
            <div class="error-content">
                <h1 class="error-title">We're Launching Soon!</h1>
                <p class="error-message">
                    Our website is currently under construction. We're working hard to bring you an amazing experience.
                    Check back soon to see what we've been building!
                </p>

                <!-- Features Preview -->
                <div class="error-suggestions">
                    <h3>What to expect:</h3>
                    <ul>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-4.41 0-8-3.59-8-8V8.3l8-4.44 8 4.44V12c0 4.41-3.59 8-8 8z"/>
                                <path d="M10.5 13L8 10.5l-1.41 1.41L10.5 15.83l7-7L16.09 7.41z"/>
                            </svg>
                            <span>Fresh content and engaging articles</span>
                        </li>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <span>Modern design and seamless experience</span>
                        </li>
                        <li>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                            </svg>
                            <span>Interactive features and community engagement</span>
                        </li>
                    </ul>
                </div>

                <!-- Status Message -->
                <div class="coming-soon-status">
                    <p><strong>Status:</strong> Building something awesome</p>
                    <p><strong>Expected:</strong> Soon</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.coming-soon-status {
    margin-top: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
    border-radius: 12px;
    border: 1px solid rgba(139, 92, 246, 0.2);
}

.coming-soon-status p {
    margin: 0.5rem 0;
    color: #64748b;
    font-size: 0.95rem;
}

.coming-soon-status strong {
    color: #334155;
    font-weight: 600;
}
</style>
@endsection
