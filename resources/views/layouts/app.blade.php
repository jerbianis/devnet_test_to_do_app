<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
    <style>
        .custom-alert {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}" @if(Route::currentRouteName() == 'dashboard') style="color: #0d6efd; font-weight: bold;" @endif>Dashboard</a>
                            </li>
                        @endauth
                        @admin
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('project.index') }}" @if(Route::currentRouteName() == 'project.index') style="color: #0d6efd; font-weight: bold;" @endif>Projects</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('task.index') }}" @if(Route::currentRouteName() == 'task.index') style="color: #0d6efd; font-weight: bold;" @endif>Tasks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pending-task.index') }}" @if(Route::currentRouteName() == 'pending-task.index') style="color: #0d6efd; font-weight: bold;" @endif>Requests</a>
                            </li>
                        @endadmin
                        @employee
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employee.task.index') }}" @if(Route::currentRouteName() == 'employee.task.index') style="color: #0d6efd; font-weight: bold;" @endif>Tasks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employee.pending-task.index') }}" @if(Route::currentRouteName() == 'employee.pending-task.index') style="color: #0d6efd; font-weight: bold;" @endif>Requests</a>
                            </li>
                        @endemployee
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        $(document).ready(function() {
            // Select all elements with the 'auto-dismiss' class and fade them out after 2 seconds
            $('.alert').each(function() {
                var alert = $(this);
                setTimeout(function() {
                    alert.fadeOut(1200);
                }, 1700);
            });
        });
    </script>
    @if (session('status'))
        <div class="alert alert-success custom-alert" role="alert">
            {{ session('status') }}
        </div>
    @endif
</body>
</html>
