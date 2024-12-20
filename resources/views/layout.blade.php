<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">

    {!! SEO::generate() !!}

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32 48x48">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <header class="container">

    </header>

    <main class="container">
        <h1>{{ SEO::getTitle(true) }}</h1>

        @session('alert-type')
            <div class="alert alert-{{ $value }}" role="alert">
                {!! session()->get('alert-message') !!}
            </div>
        @endsession

        @yield('content')
    </main>

    <footer class="container border-top">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                &copy; {{ $today->year }} <a href="https://epoc.fr"><img src="{{ asset('images/epoc.png') }}" alt="Logo de Maxime &quot;Epoc&quot; Gross" width="24" height="24"></a> <a href="https://epoc.fr/">Maxime "Epoc" Gross</a>
            </div>
            <div class="col-auto fs-2">
                @foreach($socialLinks as $icon => $url)
                    <a href="{{ $url }}"><i class="bi bi-{{ $icon }}"></i></a>
                @endforeach
            </div>
        </div>
    </footer>
</body>
</html>
