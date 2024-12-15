<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <p>Home @guest<a href="{{ hub_route('auth.login') }}">Login</a>@else<a href="{{ hub_route('auth.logout') }}">Logout</a>@endguest</p>
</body>
</html>
