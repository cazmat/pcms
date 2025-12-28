@extends('main.php')

@section('title')
<?php echo $filter_category ? htmlspecialchars($filter_category['name']) . ' - ' : ''; ?>Home
@endsection

@section('pageclass')
site-home
@endsection

@section('content')
<?php if ($filter_category): ?>
    <!-- Category Filter Indicator -->
    <div class="filter-indicator">
        <div class="filter-indicator-content">
            <div class="filter-label">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                Filtered by category:
            </div>
            <div class="filter-category">
                <span class="filter-category-color" style="background-color: {{ $filter_category['color'] }}"></span>
                <span class="filter-category-name">{{ htmlspecialchars($filter_category['name']) }}</span>
            </div>
            <a href="{{ $system->get_setting('base_url') }}" class="filter-clear">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
                Clear filter
            </a>
        </div>
    </div>
<?php endif; ?>

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

<style>
.filter-indicator {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 0;
    margin-bottom: 2rem;
    border-radius: 12px;
}

.filter-indicator-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 0.95rem;
}

.filter-category {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    backdrop-filter: blur(10px);
}

.filter-category-color {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.5);
}

.filter-category-name {
    font-weight: 600;
}

.filter-clear {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.15);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: background 0.2s;
    margin-left: auto;
}

.filter-clear:hover {
    background: rgba(255, 255, 255, 0.25);
}

@media (max-width: 768px) {
    .filter-indicator-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .filter-clear {
        margin-left: 0;
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
