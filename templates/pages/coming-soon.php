<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - {{ $system->get_setting('site_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1e293b;
        }

        .coming-soon-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem 2rem;
            text-align: center;
        }

        .coming-soon-illustration {
            margin-bottom: 2rem;
        }

        .coming-soon-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .coming-soon-message {
            font-size: 1.125rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-preview {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .features-preview h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 1.5rem;
        }

        .features-list {
            list-style: none;
            text-align: left;
            max-width: 500px;
            margin: 0 auto;
        }

        .features-list li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .features-list li:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .features-list svg {
            flex-shrink: 0;
            margin-top: 2px;
            color: #667eea;
        }

        .features-list span {
            color: #475569;
            line-height: 1.6;
        }

        .status-info {
            display: inline-flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 12px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .status-info p {
            margin: 0;
            color: #64748b;
            font-size: 0.95rem;
        }

        .status-info strong {
            color: #334155;
            font-weight: 600;
        }

        @media (max-width: 640px) {
            .coming-soon-container {
                padding: 2rem 1.5rem;
            }

            .coming-soon-title {
                font-size: 2rem;
            }

            .coming-soon-message {
                font-size: 1rem;
            }

            .features-preview {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <!-- Rocket Illustration -->
        <div class="coming-soon-illustration">
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
                <circle cx="40" cy="40" r="2" fill="#FFFFFF" opacity="0.5">
                    <animate attributeName="opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                </circle>
                <circle cx="200" cy="60" r="2" fill="#FFFFFF" opacity="0.5">
                    <animate attributeName="opacity" values="0.5;1;0.5" dur="2.5s" repeatCount="indefinite"/>
                </circle>
                <circle cx="60" cy="200" r="2" fill="#FFFFFF" opacity="0.5">
                    <animate attributeName="opacity" values="0.5;1;0.5" dur="3s" repeatCount="indefinite"/>
                </circle>
                <circle cx="180" cy="190" r="2" fill="#FFFFFF" opacity="0.5">
                    <animate attributeName="opacity" values="0.5;1;0.5" dur="2.2s" repeatCount="indefinite"/>
                </circle>

                <defs>
                    <linearGradient id="gradientRocket" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                        <stop offset="50%" style="stop-color:#764ba2;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#F97316;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="gradientFin" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Coming Soon Message -->
        <h1 class="coming-soon-title">We're Launching Soon!</h1>
        <p class="coming-soon-message">
            Our website is currently under construction. We're working hard to bring you an amazing experience.
            Check back soon to see what we've been building!
        </p>

        <!-- Features Preview -->
        <div class="features-preview">
            <h3>What to expect:</h3>
            <ul class="features-list">
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
        <div class="status-info">
            <p><strong>Status:</strong> Building something awesome</p>
            <p><strong>Expected:</strong> Soon</p>
        </div>
    </div>
</body>
</html>
