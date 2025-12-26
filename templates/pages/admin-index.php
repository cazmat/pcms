@extends('admin.php')

@section('title')
Manage Posts
@endsection

@section('content')
<div class="admin-header">
    <h2>Manage Posts</h2>
    <a href="{{ $system->get_setting('base_url') }}/admin/edit.php" class="btn btn-primary">Create New Post</a>
</div>

<?php if ($message): ?>
    <div class="alert alert-success">{{ $message }}</div>
<?php endif; ?>

<div class="admin-posts">
    <?php if (empty($posts)): ?>
        <p class="no-posts">No posts found. Create your first post!</p>
    <?php else: ?>
        <table class="posts-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <strong>{{ $post['title'] }}</strong>
                        </td>
                        <td>{{ $post['author'] }}</td>
                        <td>
                            <span class="status status-{{ $post['status'] }}">
                                <?php echo ucfirst($post['status']); ?>
                            </span>
                        </td>
                        <td><?php echo formatDate($post['created_at']); ?></td>
                        <td class="actions">
                            <?php if ($post['status'] === 'published'): ?>
                                <a href="{{ $system->get_setting('base_url') }}/post.php?slug={{ $post['slug'] }}"
                                   target="_blank" class="btn btn-small">View</a>
                            <?php endif; ?>
                            <a href="{{ $system->get_setting('base_url') }}/admin/edit.php?id=<?php echo $post['id']; ?>"
                               class="btn btn-small">Edit</a>
                            <a href="{{ $system->get_setting('base_url') }}/admin/index.php?delete=1&id=<?php echo $post['id']; ?>"
                               class="btn btn-small btn-danger"
                               onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        @include('pagination.php')
    <?php endif; ?>
</div>
@endsection
