@extends('admin.php')

@section('title')
<?php echo $isEdit ? 'Edit' : 'Create'; ?> Post
@endsection

@section('content')
<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>{{ $error }}</li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" class="post-form">
    <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">

    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="{{ $formData['id'] }}">
        <input type="hidden" name="original_slug" value="{{ $formData['slug'] }}">
    <?php endif; ?>

    <div class="form-group">
        <label for="title">Title *</label>
        <input type="text" id="title" name="title" value="{{ $formData['title'] }}" required>
    </div>

    <div class="form-group">
        <label for="excerpt">Excerpt</label>
        <textarea id="excerpt" name="excerpt" rows="3">{{ $formData['excerpt'] }}</textarea>
        <small>A short summary of your post (optional)</small>
    </div>

    <!-- SEO Meta Fields -->
    <div class="form-group">
        <label for="meta_description">Meta Description</label>
        <textarea id="meta_description" name="meta_description" rows="2" maxlength="160">{{ $formData['meta_description'] }}</textarea>
        <small>SEO meta description (max 160 characters, optional)</small>
    </div>

    <div class="form-group">
        <label for="meta_keywords">Meta Keywords</label>
        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ $formData['meta_keywords'] }}" maxlength="255">
        <small>Comma-separated keywords for SEO (optional)</small>
    </div>

    <div class="form-group">
        <label for="content">Content *</label>
        <textarea id="content" name="content" rows="15" required>{{ $formData['content'] }}</textarea>
        <small>You can use HTML tags for formatting</small>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="author">Author *</label>
            <input type="text" id="author" name="author" value="{{ $formData['author'] }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="draft" <?php echo $formData['status'] === 'draft' ? 'selected' : ''; ?>>
                    Draft
                </option>
                <option value="published" <?php echo $formData['status'] === 'published' ? 'selected' : ''; ?>>
                    Published
                </option>
            </select>
        </div>
    </div>

    <!-- Category Selection -->
    <div class="form-group">
        <label for="category_id">
            Category
            <a href="{{ $system->get_setting('base_url') }}/admin/category-create.php" class="inline-link" target="_blank" title="Create new category">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
            </a>
        </label>
        <select id="category_id" name="category_id">
            <option value="">Select a category...</option>
            <?php foreach ($categories as $category): ?>
                <option value="{{ $category['id'] }}"
                        <?php echo $formData['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                    {{ htmlspecialchars($category['name']) }}
                </option>
            <?php endforeach; ?>
        </select>
        <small>Choose one category for this post (optional)</small>
    </div>

    <!-- Tags Selection -->
    <div class="form-group">
        <label>
            Tags
            <a href="{{ $system->get_setting('base_url') }}/admin/tag-create.php" class="inline-link" target="_blank" title="Create new tag">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
            </a>
        </label>
        <div class="tags-selection">
            <?php if (empty($tags)): ?>
                <p class="no-tags-message">
                    No tags available.
                    <a href="{{ $system->get_setting('base_url') }}/admin/tag-create.php" target="_blank">Create your first tag</a>
                </p>
            <?php else: ?>
                <?php foreach ($tags as $tag): ?>
                    <label class="tag-checkbox">
                        <input
                            type="checkbox"
                            name="tag_ids[]"
                            value="{{ $tag['id'] }}"
                            <?php echo in_array($tag['id'], $currentTagIds) ? 'checked' : ''; ?>
                        >
                        <span class="tag-label" style="--tag-color: {{ $tag['color'] }}">
                            <span class="tag-color" style="background-color: {{ $tag['color'] }}"></span>
                            {{ htmlspecialchars($tag['name']) }}
                        </span>
                    </label>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <small>Select one or more tags for this post (optional)</small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <?php echo $isEdit ? 'Update' : 'Create'; ?> Post
        </button>
        <a href="{{ $system->get_setting('base_url') }}/admin/index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.inline-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-left: 0.5rem;
    color: #667eea;
    text-decoration: none;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.inline-link:hover {
    opacity: 1;
}

.tags-selection {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 0.75rem;
    padding: 1rem;
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    max-height: 300px;
    overflow-y: auto;
}

.tag-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s;
}

.tag-checkbox input[type="checkbox"] {
    margin: 0;
    margin-right: 0.5rem;
    cursor: pointer;
}

.tag-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    flex: 1;
}

.tag-checkbox input[type="checkbox"]:checked + .tag-label {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-color: var(--tag-color, #8b5cf6);
}

.tag-color {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    flex-shrink: 0;
}

.no-tags-message {
    grid-column: 1 / -1;
    text-align: center;
    color: #6b7280;
    padding: 2rem 1rem;
}

.no-tags-message a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.no-tags-message a:hover {
    text-decoration: underline;
}

/* Scrollbar for tags */
.tags-selection::-webkit-scrollbar {
    width: 8px;
}

.tags-selection::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 4px;
}

.tags-selection::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 4px;
}

.tags-selection::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }

    .tags-selection {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
