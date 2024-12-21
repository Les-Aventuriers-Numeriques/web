@extends('layout')

@section('content')
    <p class="text-center m-5">
        <a class="btn btn-primary btn-lg p-3" href="{{ hub_route('auth.redirect') }}" role="button"><i class="bi bi-discord"></i> Se connecter avec Discord</a>
    </p>
@endsection
