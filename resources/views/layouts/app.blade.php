<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}'} 
    	</script>
    	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        <title>@yield('title')</title>
    </head>
    <body>
    	<div id="app">
            <div class="contrainer">
                
                @yield('content')

            </div> 
    	</div>

    	<script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>