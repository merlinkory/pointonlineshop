<!doctype html>
<html>
    <head>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <title>Login</title>
        <link href="{ assert('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <h1>Вход</h1>  
        
        <form class="col-3 offset-4 border rounded" method="POST" action="{{route('user.login')}}">
            @csrf
            <div class="form-group">
                <label for="email" class="col-form-label-lg">Your email</label>
                <input class="form-control" id="email" name="email" type="text" placeholder="Email">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="col-form-label-lg">Your password</label>
                <input class="form-control" id="password" name="password" type="text" placeholder="password">
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <button class="btn btn-lg btm-primary" type="submit" name="sendMe" value="1">Login</button>
            </div>
        </form>
    </body>
</html>