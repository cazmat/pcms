@extends('main.php')

@section('title')
Home
@endsection

@section('content')
<?php if (empty($posts)): ?>
    <div class="no-posts-message">
        <div class="no-posts-icon">📝</div>
        <h2>No Posts Yet</h2>
        <p>Check back soon for exciting new content!</p>
    </div>
<?php else: ?>
    <!-- Hero Section - Featured Latest Post -->
    <?php
    $featured_post = $posts[0];
    $remaining_posts = array_slice($posts, 1);
    ?>

    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-label">Featured Post</div>
            <h1 class="hero-title">
                <a href="{{ $system->get_setting('base_url') }}/post.php?slug={{ $featured_post['slug'] }}">
                    {{ $featured_post['title'] }}
                </a>
            </h1>
            <div class="hero-meta">
                <span class="hero-author">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    {{ $featured_post['author'] }}
                </span>
                <span class="hero-date">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    <?php echo formatDate($featured_post['created_at']); ?>
                </span>
            </div>
            <?php if ($featured_post['excerpt']): ?>
                <p class="hero-excerpt">{{ $featured_post['excerpt'] }}</p>
            <?php endif; ?>
            <a href="{{ $system->get_setting('base_url') }}/post.php?slug={{ $featured_post['slug'] }}" class="hero-button">
                Read Article
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- Two Column Layout: Main Content + Sidebar -->
    <div class="content-wrapper">
        <main class="main-content">
            <?php if (!empty($remaining_posts)): ?>
                <h2 class="section-title">Recent Posts</h2>
                <div class="posts-grid">
                    <?php foreach ($remaining_posts as $post): ?>
                        <article class="post-card">
                            <div class="post-card-content">
                                <h3 class="post-card-title">
                                    <a href="{{ $system->get_setting('base_url') }}/post.php?slug={{ $post['slug'] }}">
                                        {{ $post['title'] }}
                                    </a>
                                </h3>
                                <div class="post-card-meta">
                                    <span class="post-card-author">{{ $post['author'] }}</span>
                                    <span class="post-card-separator">•</span>
                                    <span class="post-card-date"><?php echo formatDate($post['created_at']); ?></span>
                                </div>
                                <?php if ($post['excerpt']): ?>
                                    <p class="post-card-excerpt">{{ $post['excerpt'] }}</p>
                                <?php endif; ?>
                                <a href="{{ $system->get_setting('base_url') }}/post.php?slug={{ $post['slug'] }}" class="post-card-link">
                                    Read more →
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            @include('pagination.php')
        </main>

        @include('sidebar.php')
    </div>
<?php endif; ?>
@endsection
