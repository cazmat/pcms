@extends('admin.php')

@section('head')
<link rel="stylesheet" href="<?php echo e($system->get_setting('base_url')); ?>/css/admin-style.css">
@endsection

@section('title')
Error Logs
@endsection

@section('pageclass')
admin-logs
@endsection

@section('content')
<!-- Logs Header -->
<div class="dashboard-hero">
    <div class="dashboard-hero-content">
        <div class="dashboard-title-section">
            <h1 class="dashboard-title">Error Logs</h1>
            <p class="dashboard-subtitle">Monitor and troubleshoot application errors</p>
        </div>
        <div class="environment-badge environment-<?php echo strtolower($environment); ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span><?php echo strtoupper($environment); ?></span>
        </div>
    </div>
</div>

<?php if (empty($logFiles)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
        </div>
        <h3>No log files found</h3>
        <p>Error logs will appear here when the application encounters errors</p>
    </div>
<?php else: ?>
    <div class="logs-container">
        <!-- Log Files Sidebar -->
        <div class="logs-sidebar-card">
            <div class="logs-sidebar-header">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                    <polyline points="13 2 13 9 20 9"/>
                </svg>
                <h3>Log Files</h3>
                <span class="file-count"><?php echo count($logFiles); ?></span>
            </div>
            <ul class="log-files-list">
                <?php foreach ($logFiles as $logFile): ?>
                    <li>
                        <a href="?file=<?php echo urlencode($logFile); ?>"
                           class="log-file-item <?php echo $logFile === $currentLogFile ? 'active' : ''; ?>">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            <span class="log-filename"><?php echo e($logFile); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Log Viewer -->
        <div class="logs-content-card">
            <div class="logs-content-header">
                <div class="log-file-info">
                    <h3>
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        <?php echo e($currentLogFile); ?>
                    </h3>
                    <p class="log-description">Log entries are displayed in JSON format, with latest entries first</p>
                </div>
            </div>

            <div class="logs-viewer">
                <pre><code><?php echo e($logContents); ?></code></pre>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
/* Environment Badge */
.environment-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.environment-development {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.environment-production {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.environment-staging {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-top: 2rem;
}

.empty-state-icon {
    margin-bottom: 1.5rem;
    color: #9ca3af;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0;
}

/* Logs Container */
.logs-container {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1.5rem;
    margin-top: 2rem;
}

/* Sidebar Card */
.logs-sidebar-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.logs-sidebar-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-bottom: 1px solid #e5e7eb;
}

.logs-sidebar-header svg {
    flex-shrink: 0;
    color: #667eea;
}

.logs-sidebar-header h3 {
    flex: 1;
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.file-count {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 28px;
    padding: 0 0.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 14px;
}

.log-files-list {
    list-style: none;
    padding: 0.5rem;
    margin: 0;
    max-height: 600px;
    overflow-y: auto;
}

.log-files-list li {
    margin-bottom: 0.25rem;
}

.log-file-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-decoration: none;
    color: #374151;
    transition: all 0.2s;
    cursor: pointer;
}

.log-file-item:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    transform: translateX(2px);
}

.log-file-item.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.log-file-item svg {
    flex-shrink: 0;
}

.log-filename {
    flex: 1;
    font-size: 0.875rem;
    font-family: 'Courier New', monospace;
    word-break: break-all;
    line-height: 1.4;
}

/* Content Card */
.logs-content-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 800px;
}

.logs-content-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
}

.log-file-info h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.log-file-info svg {
    flex-shrink: 0;
    color: #667eea;
}

.log-description {
    margin: 0;
    font-size: 0.875rem;
    color: #6b7280;
}

/* Log Viewer */
.logs-viewer {
    flex: 1;
    background: #1e1e1e;
    overflow: auto;
}

.logs-viewer pre {
    margin: 0;
    padding: 1.5rem;
}

.logs-viewer code {
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.875rem;
    line-height: 1.6;
    color: #d4d4d4;
    white-space: pre-wrap;
    word-wrap: break-word;
}

/* Scrollbar Styling */
.log-files-list::-webkit-scrollbar,
.logs-viewer::-webkit-scrollbar {
    width: 8px;
}

.log-files-list::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 4px;
}

.log-files-list::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 4px;
}

.log-files-list::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

.logs-viewer::-webkit-scrollbar-track {
    background: #2d2d2d;
}

.logs-viewer::-webkit-scrollbar-thumb {
    background: #4a4a4a;
    border-radius: 4px;
}

.logs-viewer::-webkit-scrollbar-thumb:hover {
    background: #5a5a5a;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .logs-container {
        grid-template-columns: 1fr;
    }

    .logs-sidebar-card {
        order: 2;
    }

    .logs-content-card {
        order: 1;
    }

    .log-files-list {
        max-height: 300px;
    }
}

@media (max-width: 768px) {
    .logs-content-card {
        max-height: 500px;
    }

    .logs-viewer pre {
        padding: 1rem;
    }

    .logs-viewer code {
        font-size: 0.75rem;
    }
}
</style>
@endsection
