<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" style="font-family: 'Lucida Handwriting','sans-serif'" href="{{ url('/') }}">
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
                                <a class="nav-link" href="{{ route('pending-task.index') }}" @if(Route::currentRouteName() == 'pending-task.index') style="color: #0d6efd; font-weight: bold;" @endif>
                                    Requests
                                    @if($count = \App\Http\Controllers\Task\AdminTaskController::getPendingTaskCount())
                                        <span style="margin-left: 0.3rem; font-size: 8px;" class="translate-middle badge rounded-pill bg-danger">
                                        {{$count}}
                                        </span>
                                    @endif
                                </a>
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
        <div class="d-flex flex-column align-items-center pt-5">
            <div>
                <h1 style="font-family: 'Lucida Handwriting','sans-serif'">Welcome to TODO Application</h1>
            </div>
            <div class="pt-2">
                <img style="height: 60vh;" src="{{asset('img/kanban.svg')}}" alt="kanban">
            </div>
            <div class="pt-2">
                <h2 style="font-family: 'Lucida Handwriting','sans-serif'">The Way You Manage Your Tasks</h2>
            </div>
        </div>
    </body>
</html>
