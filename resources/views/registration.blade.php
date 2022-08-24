<!doctype html>
<html>
    <head>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <title>Register</title>
    </head>
    <body>
        <h1>Registration</h1>      
        <form class="col-3 offset-4 border rounded" method="POST" action="{{ route('user.registration') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="col-form-label-lg">Your email</label>
                <input class="form-control" id="email" name="email" type="text" placeholder="Email">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="name" class="col-form-label-lg">Your name</label>
                <input class="form-control" id="name" name="name" type="text" placeholder="name">
                @error('name')
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
                <button class="btn btn-lg btm-primary" type="submit" name="sendMe" value="1">Register</button>
            </div>
        </form>
    </body>
</html>