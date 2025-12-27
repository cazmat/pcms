@extends('admin.php')

@section('title')
Dashboard
@endsection

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-hero">
    <div class="dashboard-hero-content">
        <div class="dashboard-title-section">
            <h1 class="dashboard-title">Welcome back, {{ $current_user['username'] }}!</h1>
            <p class="dashboard-subtitle">Manage your blog posts and content</p>
        </div>
        <a href="{{ $system->get_setting('base_url') }}/admin/edit.php" class="btn btn-primary btn-create">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Create New Post
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card stat-card-total">
        <div class="stat-icon">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Posts</div>
        </div>
    </div>

    <div class="stat-card stat-card-published">
        <div class="stat-icon">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['published'] }}</div>
            <div class="stat-label">Published</div>
        </div>
    </div>

    <div class="stat-card stat-card-drafts">
        <div class="stat-icon">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['drafts'] }}</div>
            <div class="stat-label">Drafts</div>
        </div>
    </div>
</div>

<!-- Success Message -->
<?php if ($message): ?>
    <div class="alert alert-success">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
        {{ $message }}
    </div>
<?php endif; ?>

<!-- Posts Section -->
<div class="posts-section">
    <div class="posts-section-header">
        <h2>Your Posts</h2>
        <div class="posts-count"><?php echo count($posts); ?> of {{ $stats['total'] }} posts</div>
    </div>

    <?php if (empty($posts)): ?>
        <div class="no-posts-card">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            <h3>No posts yet</h3>
            <p>Get started by creating your first blog post!</p>
            <a href="{{ $system->get_setting('base_url') }}/admin/edit.php" class="btn btn-primary">
                Create Your First Post
            </a>
        </div>
    <?php else: ?>
        <div class="posts-grid">
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <div class="post-card-header">
                        <h3 class="post-card-title">{{ $post['title'] }}</h3>
                        <span class="post-card-status status-<?php echo $post['status']; ?>">
                            <?php echo ucfirst($post['status']); ?>
                        </span>
                    </div>

                    <?php if ($post['excerpt']): ?>
                        <p class="post-card-excerpt">{{ $post['excerpt'] }}</p>
                    <?php endif; ?>

                    <div class="post-card-meta">
                        <div class="post-card-meta-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span>{{ $post['author'] }}</span>
                        </div>
                        <div class="post-card-meta-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                            </svg>
                            <span><?php echo formatDate($post['created_at']); ?></span>
                        </div>
                    </div>

                    <div class="post-card-actions">
                        <?php if ($post['status'] === 'published'): ?>
                            <a href="{{ $system->get_setting('base_url') }}/post/<?php echo $post['slug']; ?>"
                               target="_blank"
                               class="btn-action btn-action-view"
                               title="View Post">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View
                            </a>
                        <?php endif; ?>
                        <a href="{{ $system->get_setting('base_url') }}/admin/edit/<?php echo $post['id']; ?>"
                           class="btn-action btn-action-edit"
                           title="Edit Post">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Edit
                        </a>
                        <a href="{{ $system->get_setting('base_url') }}/admin/index.php?delete=1&id=<?php echo $post['id']; ?>"
                           class="btn-action btn-action-delete"
                           onclick="return confirm('Are you sure you want to delete this post?')"
                           title="Delete Post">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>
                            Delete
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        @include('pagination.php')
    <?php endif; ?>
</div>
@endsection
