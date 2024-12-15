@extends('layout')

@section('content')
    <p>Home @guest<a href="{{ hub_route('auth.login') }}">Login</a>@else<a href="{{ hub_route('auth.logout') }}">Logout</a>@endguest</p>
@endsection
