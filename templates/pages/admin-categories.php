@extends('admin.php')

@section('title')
Categories
@endsection

@section('content')
<!-- Categories Header -->
<div class="dashboard-hero">
    <div class="dashboard-hero-content">
        <div class="dashboard-title-section">
            <h1 class="dashboard-title">Categories</h1>
            <p class="dashboard-subtitle">Organize your blog posts into categories</p>
        </div>
        <a href="{{ $system->get_setting('base_url') }}/admin/category-create.php" class="btn btn-primary btn-create">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New Category
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

<!-- Categories List -->
<div class="categories-container">
    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <h3>No categories yet</h3>
            <p>Create your first category to start organizing your blog posts</p>
            <a href="{{ $system->get_setting('base_url') }}/admin/category-create.php" class="btn btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Add New Category
            </a>
        </div>
    <?php else: ?>
        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
                <div class="category-card">
                    <div class="category-card-header">
                        <div class="category-color-preview" style="background-color: {{ $category['color'] }}"></div>
                        <div class="category-info">
                            <h3 class="category-name">{{ htmlspecialchars($category['name']) }}</h3>
                            <span class="category-slug">{{ htmlspecialchars($category['slug']) }}</span>
                        </div>
                        <?php if ($category['slug'] === 'uncategorized'): ?>
                            <span class="category-badge category-badge-protected">Protected</span>
                        <?php endif; ?>
                    </div>

                    <div class="category-card-body">
                        <div class="category-stats">
                            <div class="category-stat">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <span>{{ $category['post_count'] }} {{ $category['post_count'] === 1 ? 'post' : 'posts' }}</span>
                            </div>
                        </div>

                        <div class="category-actions">
                            <a href="{{ $system->get_setting('base_url') }}/admin/category-edit.php?id={{ $category['id'] }}" class="btn-icon-action" title="Edit category">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>

                            <?php if ($category['slug'] !== 'uncategorized'): ?>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category? All posts in this category will be reassigned to \'Uncategorized\'.');">
                                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                    <input type="hidden" name="category_id" value="{{ $category['id'] }}">
                                    <button type="submit" name="delete_category" class="btn-icon-action btn-icon-danger" title="Delete category">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            <line x1="10" y1="11" x2="10" y2="17"/>
                                            <line x1="14" y1="11" x2="14" y2="17"/>
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.categories-container {
    margin-top: 2rem;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.category-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.category-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border-bottom: 1px solid #e5e7eb;
}

.category-color-preview {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.category-info {
    flex: 1;
    min-width: 0;
}

.category-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.category-slug {
    font-size: 0.875rem;
    color: #6b7280;
    font-family: 'Courier New', monospace;
}

.category-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.category-badge-protected {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.category-card-body {
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.category-stats {
    display: flex;
    gap: 1rem;
}

.category-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.category-stat svg {
    flex-shrink: 0;
}

.category-actions {
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
    .categories-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
