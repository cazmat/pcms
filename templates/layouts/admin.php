<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin - {{ $system->get_setting("site_name") }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e($system->get_setting('base_url')); ?>/css/style.css">
    @yield('head')
</head>
<body class="@yield('pageclass')">
    @include('admin-header.php')

    <main class="container">
        @yield('content')
    </main>

    @include('footer.php')

    @yield('scripts')
</body>
</html>
