@extends('main.php')

@section('title')
{{ $post['title'] }}
@endsection

@section('content')
<!-- Post Header with Gradient Background -->
<section class="post-header">
    <div class="post-header-content">
        <div class="post-category-badge">Article</div>
        <h1 class="post-header-title">{{ $post['title'] }}</h1>
        <div class="post-header-meta">
            <span class="post-header-author">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                {{ $post['author'] }}
            </span>
            <span class="post-header-date">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                </svg>
                <?php echo formatDate($post['created_at']); ?>
            </span>
            <?php if ($post['updated_at'] != $post['created_at']): ?>
                <span class="post-header-updated">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                    Updated <?php echo formatDate($post['updated_at']); ?>
                </span>
            <?php endif; ?>
        </div>
        <?php if ($post['excerpt']): ?>
            <p class="post-header-excerpt">{{ $post['excerpt'] }}</p>
        <?php endif; ?>
    </div>
</section>

<!-- Post Content with Sidebar -->
<div class="post-container">
    <article class="post-main-content">
        <div class="post-content-body">
            {!! $post['content'] !!}
        </div>

        <div class="post-footer">
            <div class="post-divider"></div>
            <div class="post-footer-actions">
                <a href="{{ $system->get_setting('base_url') }}/index.php" class="btn-back-to-posts">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to all posts
                </a>
            </div>
        </div>
    </article>

    <aside class="post-sidebar">
        <!-- Author Info Widget -->
        <div class="post-widget">
            <h3 class="post-widget-title">About the Author</h3>
            <div class="author-info">
                <div class="author-avatar">
                    <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="author-details">
                    <h4>{{ $post['author'] }}</h4>
                    <p>Content creator and blogger</p>
                </div>
            </div>
        </div>

        <!-- Share Widget -->
        <div class="post-widget">
            <h3 class="post-widget-title">Share this post</h3>
            <div class="share-buttons">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($system->get_setting('base_url') . '/post.php?slug=' . $post['slug']); ?>&text=<?php echo urlencode($post['title']); ?>"
                   target="_blank"
                   rel="noopener"
                   class="share-button share-twitter"
                   aria-label="Share on Twitter">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                    <span>Twitter</span>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($system->get_setting('base_url') . '/post.php?slug=' . $post['slug']); ?>"
                   target="_blank"
                   rel="noopener"
                   class="share-button share-linkedin"
                   aria-label="Share on LinkedIn">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    <span>LinkedIn</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($system->get_setting('base_url') . '/post.php?slug=' . $post['slug']); ?>"
                   target="_blank"
                   rel="noopener"
                   class="share-button share-facebook"
                   aria-label="Share on Facebook">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span>Facebook</span>
                </a>
            </div>
        </div>

        <!-- Meta Info Widget -->
        <div class="post-widget post-meta-widget">
            <h3 class="post-widget-title">Post Details</h3>
            <div class="post-meta-info">
                <div class="post-meta-item">
                    <span class="post-meta-label">Published</span>
                    <span class="post-meta-value"><?php echo formatDate($post['created_at']); ?></span>
                </div>
                <?php if ($post['updated_at'] != $post['created_at']): ?>
                    <div class="post-meta-item">
                        <span class="post-meta-label">Last Updated</span>
                        <span class="post-meta-value"><?php echo formatDate($post['updated_at']); ?></span>
                    </div>
                <?php endif; ?>
                <div class="post-meta-item">
                    <span class="post-meta-label">Author</span>
                    <span class="post-meta-value">{{ $post['author'] }}</span>
                </div>
            </div>
        </div>
    </aside>
</div>
@endsection
