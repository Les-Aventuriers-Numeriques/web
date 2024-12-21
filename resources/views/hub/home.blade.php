@extends('layout')

@section('content')
    <p>Bienvenue sur notre intranet ! Utilise le menu en haut à droite pour naviguer.</p>
    <p>Merci de rapporter tout problème ou suggestion à <strong>Epoc</strong> sur notre Discord <i class="bi bi-emoji-wink-fill"></i></p>

    <p>Home @guest<a href="{{ hub_route('auth.login') }}">Login</a>@else<a href="{{ hub_route('auth.logout') }}">Logout</a>@endguest</p>
@endsection
