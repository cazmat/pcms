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

    <div class="form-group">
        <label for="content">Content *</label>
        <textarea id="content" name="content" rows="15" required>{{ $formData['content'] }}</textarea>
        <small>You can use HTML tags for formatting</small>
    </div>

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

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <?php echo $isEdit ? 'Update' : 'Create'; ?> Post
        </button>
        <a href="{{ $system->get_setting('base_url') }}/admin/index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
