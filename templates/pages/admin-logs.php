@extends('admin.php')

@section('title')
Error Logs
@endsection

@section('content')
<div class="admin-header">
    <h2>Error Logs</h2>
    <div class="environment-badge">
        Environment: <strong><?php echo strtoupper($environment); ?></strong>
    </div>
</div>

<?php if (empty($logFiles)): ?>
    <div class="alert alert-info">
        <p>No log files found. Logs will appear here when errors are logged.</p>
    </div>
<?php else: ?>
    <div class="logs-container">
        <div class="logs-sidebar">
            <h3>Log Files</h3>
            <ul class="log-files-list">
                <?php foreach ($logFiles as $logFile): ?>
                    <li>
                        <a href="?file=<?php echo urlencode($logFile); ?>"
                           class="<?php echo $logFile === $currentLogFile ? 'active' : ''; ?>">
                            <?php echo e($logFile); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="logs-content">
            <div class="logs-header">
                <h3><?php echo e($currentLogFile); ?></h3>
                <p class="log-info">Showing latest entries first. Log entries are in JSON format.</p>
            </div>

            <div class="logs-viewer">
                <pre><?php echo e($logContents); ?></pre>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
.environment-badge {
    display: inline-block;
    padding: 5px 10px;
    background: #f0f0f0;
    border-radius: 4px;
    font-size: 14px;
}

.logs-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.logs-sidebar {
    flex: 0 0 250px;
    background: #f9f9f9;
    padding: 15px;
    border-radius: 4px;
}

.logs-sidebar h3 {
    margin-top: 0;
    font-size: 16px;
}

.log-files-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.log-files-list li {
    margin-bottom: 5px;
}

.log-files-list a {
    display: block;
    padding: 8px 12px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    font-size: 14px;
    word-break: break-all;
}

.log-files-list a:hover {
    background: #f0f0f0;
}

.log-files-list a.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.logs-content {
    flex: 1;
}

.logs-header {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.logs-header h3 {
    margin: 0 0 5px 0;
    font-size: 18px;
}

.log-info {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.logs-viewer {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 20px;
    border-radius: 4px;
    max-height: 600px;
    overflow-y: auto;
}

.logs-viewer pre {
    margin: 0;
    font-family: 'Courier New', Courier, monospace;
    font-size: 13px;
    line-height: 1.6;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
</style>
@endsection
