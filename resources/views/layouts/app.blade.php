<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-latest.js') }}"></script>
    {{-- <script src="http://code.jquery.com/jquery-latest.js"></script> --}}

    <!-- Fonts -->
    <script defer src="{{ asset('font/solid.js') }}"></script>
    <script defer src="{{ asset('font/fontawesome.js') }}"></script>
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body
        {
            background-image: url('img/hnba.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                   

                        <li class="nav-item dropdown">
                            <a id="find" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-search"></i>&nbsp; {{ __('Find') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="find">
                                <a class="dropdown-item" href="{{ route('find') }}">
                                    {{ __('Find user details') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('find_asset') }}">
                                    {{ __('Find Asset') }}
                                </a>
                                <a class="dropdown-item" href="{{route('find_dongle_data')}}">
                                    {{ __('Find Dongle') }}
                                </a>
                              
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="Add" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-plus-square"></i>&nbsp; {{ __('Add') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Add">
                                <a class="dropdown-item" href="{{ route('add_new') }}">
                                    {{ __('Add New user') }}
                                </a>
                                <a class="dropdown-item" href="{{route('unallocated_asset')}}">
                                    {{ __('Add Unallocated assets') }}
                                </a>
                                <a class="dropdown-item" href="{{route('unallocated_dongle')}}">
                                    {{ __('Add Unallocated dongle') }}
                                </a>
                              
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="report" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-file"></i>&nbsp; Report
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="report">
                                <a class="dropdown-item" href="{{ route('asset_report') }}">
                                    {{ __('Asset Report') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('dongle_report') }}">
                                    {{ __('Dongle Report') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('user_report') }}">
                                    {{ __('User Report') }}
                                </a>
                              
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="users" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user"></i>&nbsp; Users
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="users">
                                <a class="dropdown-item" href="{{ route('register') }}">
                                    {{ __('User Registration') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('all_user') }}">
                                    {{ __('All Users') }}
                                </a>
                              
                            </div>
                        </li>


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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

    @include('layouts.table')
    @include('layouts.notification')



</body>




  <!-- Data Table Scripts -->
  <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

</html>
