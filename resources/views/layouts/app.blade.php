<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />   
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">    

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/flickity.min.css') }}">
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container" id="main-navbar">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @includeIf('admin.navigation.'.auth()->user()->roles()->first()->name)
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>                            
                        @else

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" width="30px" height="30px" class="rounded-circle border border-primary"> {{Auth::user()->name}}
                                    @if ( Auth::user()->unreadNotifications->count() != 0 )
                                        @if( Auth::user()->unreadNotifications->count() > 0 AND Auth::user()->unreadNotifications->count() < 10 )
                                        <span class="badge badge-primary">1</span> 
                                        @else
                                        <span class="badge badge-primary">10 +</span> 
                                        @endif                                       
                                    @endif
                                    
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="z-index: 1021;">
                                    <a class="dropdown-item" href="{{ route('admin.notification.show') }}">
                                        Notifications
                                        @if ( Auth::user()->unreadNotifications->count() != 0 )
                                            @if( Auth::user()->unreadNotifications->count() > 0 AND Auth::user()->unreadNotifications->count() < 10 )
                                            <span class="badge badge-primary">{{ Auth::user()->unreadNotifications->count() }}</span> 
                                            @else
                                            <span class="badge badge-primary">10 +</span> 
                                            @endif                                       
                                        @endif
                                    </a>
                                    <a href="{{ route('password.change') }}" class="dropdown-item">{{ __("Change Password") }}</a>
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
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div id="loader-container">
        <div class="loader"></div>    
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/util.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/flickity.pkgd.min.js') }}" ></script>
    <script type="text/javascript">
        "use strict";
        // Apply Input class datepicker to datpicker object
        $(document).ready(function () {
            $('.datepicker').datepicker({format: "{{ config('app.js_date_format') }}", orientation : "bottom", autoclose : true});
        });

        $('button[data-toggle="collapse"]').on('click', function (e){
            var ele = e.target;
            if ( $(ele).parent().hasClass('collapsed') ) {
                $(ele).removeClass('fa-angle-down');
                $(ele).addClass('fa-angle-up');
            } else {
                $(ele).removeClass('fa-angle-up');
                $(ele).addClass('fa-angle-down');
            }
        });

         $('span[data-toggle="collapse"]').on('click', function (e){
            var ele = e.target;
            if ( $(ele).parent().hasClass('collapsed') ) {
                $(ele).removeClass('fa-angle-down');
                $(ele).addClass('fa-angle-up');
            } else {
                $(ele).removeClass('fa-angle-up');
                $(ele).addClass('fa-angle-down');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
