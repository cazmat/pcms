@extends('main.php')

@section('title')
{{ $post['title'] }}
@endsection

@section('content')
<article class="post-single">
    <h1>{{ $post['title'] }}</h1>
    <div class="post-meta">
        <span class="author">By {{ $post['author'] }}</span>
        <span class="date"><?php echo formatDate($post['created_at']); ?></span>
        <?php if ($post['updated_at'] != $post['created_at']): ?>
            <span class="updated">Updated: <?php echo formatDate($post['updated_at']); ?></span>
        <?php endif; ?>
    </div>
    <div class="post-content">
        {!! $post['content'] !!}
    </div>
    <div class="post-actions">
        <a href="{{ $system->get_setting('base_url') }}/index.php" class="btn-back">&larr; Back to all posts</a>
    </div>
</article>
@endsection
