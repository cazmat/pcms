<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ $system->get_setting("site_name") }}</title>
    <link rel="stylesheet" href="<?php echo e($system->get_setting('base_url')); ?>/css/style.css">
    @yield('head')
</head>
<body>
    @include('header.php')

    <main class="container">
        @yield('content')
    </main>

    @include('footer.php')

    @yield('scripts')
</body>
</html>
