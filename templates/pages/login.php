<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ $system->get_setting("site_name") }}</title>
    <link rel="stylesheet" href="<?php echo e($system->get_setting('base_url')); ?>/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h1>Admin Login</h1>
            <p class="login-subtitle">{{ $system->get_setting("site_name") }}</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li>{{ $error }}</li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ $username }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group checkbox-group">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        Remember me for 30 days
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                </div>
            </form>

            <div class="login-footer">
                <a href="{{ $system->get_setting('base_url') }}/index.php">&larr; Back to Blog</a>
            </div>
        </div>
    </div>
</body>
</html>
