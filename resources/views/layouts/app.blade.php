<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <link rel="icon" href="{{asset('img/favicon_new.png')}}"/>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
<link href="{{ asset('css/print.css') }}" rel="stylesheet" media="print" type="text/css">
    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">

    @yield('styles')
 </head>
<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('img/logo.png')}}" width="100px" />
                 </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @auth
                        <!-- Left Side Of Navbar -->
                        <ul class="nav nav-pills mr-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('regions*') ? 'active' : '' }}" href="/regions"><i class="fa fa-map-o"></i> <b>Regions</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('groups*') ? 'active' : '' }}" href="/groups"><i class="fa fa-address-card-o"></i> <b>Groups</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('respondents*') ? 'active' : '' }}" href="/respondents"><i class="fa fa-user-o"></i> <b>Respondents</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('surveys*') ? 'active' : '' }}" href="/surveys"><i class="fa fa-check-square-o"></i> <b>Surveys</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('sms-actions*') ? 'active' : '' }}" href="/sms-actions"><i class="fa fa-tag"></i> <b>Call to actions</b></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('category*') ? 'active' : '' }}" href="/category"><i class="fa fa-envelope-o"></i> <b>SMS Category</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('notify*') ? 'active' : '' }}" href="/notify"><i class="fa fa-bell"></i> <b>Notification</b></a>
                            </li>

                        </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
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
            </div>
        </nav>

        <main class="py-4" style="margin-top: 80px;">
            <div class="container">

                @include('flash::message')

                @if (session('status'))
                     <div class="col-sm-12 alert alert-success" role="alert">
                         {{ session('status') }}
                     </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                         </ul>
                     </div>
                @endif

                @yield('content')

            </div>
        </main>
    </div>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    @stack('scripts')
</body>
</html>
