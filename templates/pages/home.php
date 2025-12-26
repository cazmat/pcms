@extends('main.php')

@section('title')
Home
@endsection

@section('content')
<div class="posts-list">
    <?php if (empty($posts)): ?>
        <p class="no-posts">No posts available yet. Check back soon!</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <article class="post-preview">
                <h2>
                    <a href="{{ $system->get_setting('base_url') }}/post.php?slug={{ $post['slug'] }}">
                        {{ $post['title'] }}
                    </a>
                </h2>
                <div class="post-meta">
                    <span class="author">By {{ $post['author'] }}</span>
                    <span class="date"><?php echo formatDate($post['created_at']); ?></span>
                </div>
                <?php if ($post['excerpt']): ?>
                    <p class="excerpt">{{ $post['excerpt'] }}</p>
                <?php endif; ?>
                <a href="{{ $system->get_setting('base_url') }}/post.php?slug={{ $post['slug'] }}" class="read-more">
                    Read more &rarr;
                </a>
            </article>
        <?php endforeach; ?>

        @include('pagination.php')
    <?php endif; ?>
</div>
@endsection
