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
    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">

    <style type="text/css">
       table tbody td{
            width: 20em;
            word-wrap: break-word;
        }
    </style>

    @yield('styles')
 </head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container" style=" padding: 0; min-width: 100%;">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <script>
        $('select').attr('style', 'border:hidden; width:100%');
        
        $( "select" ).select2({
            // theme: "bootstrap4",
            placeholder: "Search...",
            allowClear: true
        });
    </script>
    
    @stack('scripts')
</body>
</html>
