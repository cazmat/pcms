@extends('admin.php')

@section('title')
{{ $mode === 'create' ? 'Create Tag' : 'Edit Tag' }}
@endsection

@section('content')
<!-- Tag Form Header -->
<div class="dashboard-hero">
    <div class="dashboard-hero-content">
        <div class="dashboard-title-section">
            <h1 class="dashboard-title">{{ $mode === 'create' ? 'Create Tag' : 'Edit Tag' }}</h1>
            <p class="dashboard-subtitle">{{ $mode === 'create' ? 'Add a new tag to label your posts' : 'Update tag details' }}</p>
        </div>
        <a href="{{ $system->get_setting('base_url') }}/admin/tags.php" class="btn btn-secondary">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Tags
        </a>
    </div>
</div>

<!-- Error Messages -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $error): ?>
            <p>{{ $error }}</p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Tag Form -->
<div class="form-container">
    <form method="POST" class="tag-form" id="tagForm">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

        <!-- Tag Name -->
        <div class="form-group">
            <label for="name" class="form-label">
                Tag Name *
                <span class="form-label-hint">The display name for this tag</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-input"
                value="{{ htmlspecialchars($tag['name']) }}"
                required
                maxlength="100"
                placeholder="e.g., PHP, Tutorial, Beginner"
            >
        </div>

        <!-- Tag Slug -->
        <div class="form-group">
            <label for="slug" class="form-label">
                Slug *
                <span class="form-label-hint">URL-friendly version (lowercase, letters, numbers, and hyphens only)</span>
            </label>
            <input
                type="text"
                id="slug"
                name="slug"
                class="form-input"
                value="{{ htmlspecialchars($tag['slug']) }}"
                required
                maxlength="100"
                pattern="[a-z0-9-]+"
                placeholder="e.g., php, tutorial, beginner"
            >
            <small class="form-help">This will be used in URLs like: /tag/<strong id="slugPreview">{{ $tag['slug'] ?: 'your-slug' }}</strong></small>
        </div>

        <!-- Tag Color -->
        <div class="form-group">
            <label for="color" class="form-label">
                Tag Color *
                <span class="form-label-hint">Choose a color to identify this tag</span>
            </label>
            <div class="color-picker-wrapper">
                <input
                    type="color"
                    id="color"
                    name="color"
                    class="form-input-color"
                    value="{{ $tag['color'] }}"
                >
                <input
                    type="text"
                    id="colorHex"
                    class="form-input color-hex-input"
                    value="{{ $tag['color'] }}"
                    pattern="^#[0-9A-Fa-f]{6}$"
                    maxlength="7"
                    placeholder="#8B5CF6"
                >
                <div class="color-preview" id="colorPreview" style="background-color: {{ $tag['color'] }}"></div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                {{ $mode === 'create' ? 'Create Tag' : 'Update Tag' }}
            </button>
            <a href="{{ $system->get_setting('base_url') }}/admin/tags.php" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
.form-container {
    max-width: 800px;
    margin: 2rem auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

.tag-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.form-label-hint {
    font-size: 0.85rem;
    font-weight: 400;
    color: #6b7280;
}

.form-input {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #8b5cf6;
}

.form-help {
    font-size: 0.875rem;
    color: #6b7280;
}

.color-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.form-input-color {
    width: 80px;
    height: 50px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
}

.color-hex-input {
    flex: 1;
    font-family: 'Courier New', monospace;
}

.color-preview {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #e5e7eb;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

@media (max-width: 768px) {
    .form-container {
        margin: 1rem;
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const slugPreview = document.getElementById('slugPreview');
    const colorInput = document.getElementById('color');
    const colorHexInput = document.getElementById('colorHex');
    const colorPreview = document.getElementById('colorPreview');

    // Auto-generate slug from name
    nameInput.addEventListener('input', function() {
        // Only auto-generate if creating new tag or slug is empty
        if (slugInput.value === '' || !slugInput.hasAttribute('data-manual-edit')) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');

            slugInput.value = slug;
            slugPreview.textContent = slug || 'your-slug';
        }
    });

    // Mark slug as manually edited if user types in it
    slugInput.addEventListener('input', function() {
        this.setAttribute('data-manual-edit', 'true');
        slugPreview.textContent = this.value || 'your-slug';
    });

    // Sync color inputs
    colorInput.addEventListener('input', function() {
        colorHexInput.value = this.value.toUpperCase();
        colorPreview.style.backgroundColor = this.value;
    });

    colorHexInput.addEventListener('input', function() {
        const hex = this.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
            colorInput.value = hex;
            colorPreview.style.backgroundColor = hex;
        }
    });
});
</script>
@endsection
