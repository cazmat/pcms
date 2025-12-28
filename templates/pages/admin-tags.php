@extends('admin.php')

@section('title')
Tags
@endsection

@section('content')
<!-- Tags Header -->
<div class="dashboard-hero">
    <div class="dashboard-hero-content">
        <div class="dashboard-title-section">
            <h1 class="dashboard-title">Tags</h1>
            <p class="dashboard-subtitle">Create tags to add metadata to your posts</p>
        </div>
        <a href="{{ $system->get_setting('base_url') }}/admin/tag-create.php" class="btn btn-primary btn-create">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New Tag
        </a>
    </div>
</div>

<!-- Success/Error Messages -->
<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        {{ $success }}
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $error): ?>
            <p>{{ $error }}</p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Tags List -->
<div class="tags-container">
    <?php if (empty($tags)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
            </div>
            <h3>No tags yet</h3>
            <p>Create your first tag to add metadata to your blog posts</p>
            <a href="{{ $system->get_setting('base_url') }}/admin/tag-create.php" class="btn btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Add New Tag
            </a>
        </div>
    <?php else: ?>
        <div class="tags-grid">
            <?php foreach ($tags as $tag): ?>
                <div class="tag-card">
                    <div class="tag-card-header">
                        <div class="tag-color-preview" style="background-color: {{ $tag['color'] }}"></div>
                        <div class="tag-info">
                            <h3 class="tag-name">{{ htmlspecialchars($tag['name']) }}</h3>
                            <span class="tag-slug">{{ htmlspecialchars($tag['slug']) }}</span>
                        </div>
                    </div>

                    <div class="tag-card-body">
                        <div class="tag-stats">
                            <div class="tag-stat">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <span>{{ $tag['post_count'] }} {{ $tag['post_count'] === 1 ? 'post' : 'posts' }}</span>
                            </div>
                        </div>

                        <div class="tag-actions">
                            <a href="{{ $system->get_setting('base_url') }}/admin/tag-edit.php?id={{ $tag['id'] }}" class="btn-icon-action" title="Edit tag">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>

                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this tag? It will be removed from all posts.');">
                                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                <input type="hidden" name="tag_id" value="{{ $tag['id'] }}">
                                <button type="submit" name="delete_tag" class="btn-icon-action btn-icon-danger" title="Delete tag">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        <line x1="10" y1="11" x2="10" y2="17"/>
                                        <line x1="14" y1="11" x2="14" y2="17"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.tags-container {
    margin-top: 2rem;
}

.tags-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.tag-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.tag-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.tag-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border-bottom: 1px solid #e5e7eb;
}

.tag-color-preview {
    width: 40px;
    height: 40px;
    border-radius: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.tag-info {
    flex: 1;
    min-width: 0;
}

.tag-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.tag-slug {
    font-size: 0.875rem;
    color: #6b7280;
    font-family: 'Courier New', monospace;
}

.tag-card-body {
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.tag-stats {
    display: flex;
    gap: 1rem;
}

.tag-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.tag-stat svg {
    flex-shrink: 0;
}

.tag-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-icon-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #f3f4f6;
    border: none;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-icon-action:hover {
    background: #e5e7eb;
    color: #1f2937;
}

.btn-icon-danger:hover {
    background: #fee2e2;
    color: #dc2626;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.empty-state-icon {
    margin-bottom: 1.5rem;
    color: #9ca3af;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0 0 2rem 0;
}

@media (max-width: 768px) {
    .tags-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
