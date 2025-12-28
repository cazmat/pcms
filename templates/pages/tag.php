@extends('main.php')

@section('title')
{{ $tag['name'] }}
@endsection

@section('content')
<!-- Tag Header -->
<div class="tag-header">
    <div class="tag-header-content">
        <div class="tag-breadcrumb">
            <a href="{{ $system->get_setting('base_url') }}">Home</a>
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>
            <span>Tags</span>
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>
            <span>{{ $tag['name'] }}</span>
        </div>
        <div class="tag-info">
            <div class="tag-icon">
                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
            </div>
            <div class="tag-details">
                <h1 class="tag-title">{{ $tag['name'] }}</h1>
                <div class="tag-color-preview" style="background-color: {{ $tag['color'] }}">
                    <span class="tag-color-label">{{ $tag['color'] }}</span>
                </div>
            </div>
        </div>
        <p class="tag-count">
            <?php
            $post_count = count($posts);
            $total_count = $pagination['total_items'];
            if ($total_count === 0) {
                echo 'No posts';
            } elseif ($total_count === 1) {
                echo '1 post tagged';
            } else {
                echo $total_count . ' posts tagged';
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
                <div class="no-posts-icon">🏷️</div>
                <h2>No Posts with This Tag</h2>
                <p>There are no published posts tagged with "{{ $tag['name'] }}" yet.</p>
                <a href="{{ $system->get_setting('base_url') }}" class="back-link">← Back to Home</a>
            </div>
        <?php else: ?>
            <div class="posts-grid">
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        <div class="post-card-content">
                            <?php if (!empty($post['category'])): ?>
                                <div class="post-category-badge" style="background-color: {{ $post['category']['color'] }}">
                                    {{ htmlspecialchars($post['category']['name']) }}
                                </div>
                            <?php endif; ?>
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
.tag-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 3rem;
    border-radius: 12px;
}

.tag-header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.tag-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

.tag-breadcrumb a {
    color: white;
    text-decoration: none;
    transition: opacity 0.2s;
}

.tag-breadcrumb a:hover {
    opacity: 0.8;
    text-decoration: underline;
}

.tag-breadcrumb span {
    color: white;
}

.tag-breadcrumb svg {
    opacity: 0.6;
}

.tag-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.tag-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.tag-icon svg {
    color: white;
}

.tag-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tag-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    color: white;
}

.tag-color-preview {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    width: fit-content;
}

.tag-color-label {
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.tag-count {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
}

.post-category-badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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
    .tag-header {
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .tag-title {
        font-size: 1.75rem;
    }

    .tag-icon {
        width: 48px;
        height: 48px;
    }

    .tag-icon svg {
        width: 24px;
        height: 24px;
    }

    .tag-info {
        gap: 1rem;
    }
}
</style>
@endsection
