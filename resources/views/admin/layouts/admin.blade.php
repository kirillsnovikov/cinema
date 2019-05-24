<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cinema') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li><a class="nav-link" href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li><a class="nav-link" href="{{ route('admin.parser.index') }}">Parser</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </nav>

            <main>

                <div class="row no-gutters">
                    <div class="col-sm-2 bg-primary">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('admin.movie.index') }}" class="list-group-item d-flex justify-content-between align-items-center">Movies
                                <span class="fa fa-film"></span>
<!--                                <span class="badge badge-danger">0</span>
                                <span class="badge badge-info">20</span>
                                <span class="badge badge-success">30</span>
                                <span class="badge badge-warning">15</span>-->
                            </a>
                            <a href="{{ route('admin.type.index') }}" class="list-group-item d-flex justify-content-between align-items-center">Types</a>
                            <a href="{{ route('admin.genre.index') }}" class="list-group-item d-flex justify-content-between align-items-center">Genres</a>
                            <a href="{{ route('admin.person.index') }}" class="list-group-item d-flex justify-content-between align-items-center">Persons
                                <span class="fa fa-user"></span>
                            </a>
                            <a href="{{ route('admin.profession.index') }}" class="list-group-item d-flex justify-content-between align-items-center">Professions</a>
                            <a href="{{ route('admin.country.index') }}" class="list-group-item d-flex justify-content-between align-items-center">Countries
                                <span class="fa fa-globe"></span>
                            </a>
                            <a href="#" class="list-group-item d-flex justify-content-between align-items-center">Tags</a>
                            <a href="#" class="list-group-item d-flex justify-content-between align-items-center">Comments</a>
                            <a href="#" class="list-group-item d-flex justify-content-between align-items-center">Users</a>
                        </div>
                    </div>
                    <div class="col-sm-10 bg-gradient-primary">
                        <div class="container-fluid py-3">
                            @include('admin.components.alert')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
