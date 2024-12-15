<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">

    {!! SEO::generate(app()->hasDebugModeEnabled()) !!}

    <link rel="icon" href="/favicon.ico" sizes="32x32 48x48">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <header>

    </header>

    <main>
        @yield('content')
    </main>

    <footer>

    </footer>
</body>
</html>
