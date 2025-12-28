@extends('main.php')

@section('title')
{{ $category['name'] }}
@endsection

@section('content')
<!-- Category Header -->
<div class="category-header">
    <div class="category-header-content">
        <div class="category-breadcrumb">
            <a href="{{ $system->get_setting('base_url') }}">Home</a>
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>
            <span>Categories</span>
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>
            <span>{{ $category['name'] }}</span>
        </div>
        <div class="category-info">
            <div class="category-color-badge" style="background-color: {{ $category['color'] }}"></div>
            <h1 class="category-title">{{ $category['name'] }}</h1>
        </div>
        <p class="category-count">
            <?php
            $post_count = count($posts);
            $total_count = $pagination['total_items'];
            if ($total_count === 0) {
                echo 'No posts';
            } elseif ($total_count === 1) {
                echo '1 post';
            } else {
                echo $total_count . ' posts';
            }
            ?>
        </p>
    </div>
</div>

<!-- Two Column Layout: Main Content + Sidebar -->
<div class="content-wrapper">
    <main class="main-content">
        <?php if (empty($posts)): ?>
            <div class="no-posts-message">
                <div class="no-posts-icon">📝</div>
                <h2>No Posts in This Category</h2>
                <p>There are no published posts in the "{{ $category['name'] }}" category yet.</p>
                <a href="{{ $system->get_setting('base_url') }}" class="back-link">← Back to Home</a>
            </div>
        <?php else: ?>
            <div class="posts-grid">
                <?php foreach ($posts as $post): ?>
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

            @include('pagination.php')
        <?php endif; ?>
    </main>

    @include('sidebar.php')
</div>

<style>
.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 3rem;
    border-radius: 12px;
}

.category-header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.category-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

.category-breadcrumb a {
    color: white;
    text-decoration: none;
    transition: opacity 0.2s;
}

.category-breadcrumb a:hover {
    opacity: 0.8;
    text-decoration: underline;
}

.category-breadcrumb span {
    color: white;
}

.category-breadcrumb svg {
    opacity: 0.6;
}

.category-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.category-color-badge {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.category-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    color: white;
}

.category-count {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
}

.back-link {
    display: inline-block;
    margin-top: 1.5rem;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}

.back-link:hover {
    color: #764ba2;
}

@media (max-width: 768px) {
    .category-header {
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .category-title {
        font-size: 1.75rem;
    }

    .category-color-badge {
        width: 36px;
        height: 36px;
    }
}
</style>
@endsection
