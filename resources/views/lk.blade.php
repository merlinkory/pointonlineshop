<!doctype html>
<html>
    <head>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <title>Личный кабинет</title>
        <link href="{ assert('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <a href="/logout">logout</a>
        <h1>Личный кабинет</h1>      
        <div id="app">

</div>

	

	<script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>