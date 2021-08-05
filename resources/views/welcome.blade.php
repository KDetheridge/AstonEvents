<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>


<body class="antialiased">
    <header>
        @include('includes.header')
    </header>
    <div>
        <h1>Welcome to Aston Events! Use the navigation bar at the top of the screen to view events, login or register.</h1>
    </div>
</body>

</html>