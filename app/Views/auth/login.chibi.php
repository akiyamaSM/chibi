<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login page</title>
</head>
<body>
    <h1>Hello World</h1>
    @if( $error = flash('error') )
        <h1>{{ $error }}</h1>
    @done
    <form action="@@route('auth.login.post')" method="POST">
        @csrf_field
        <div class="row">
            <label for="username">Email</label>
            <input  id="username" type="text" name="username">
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input  id="password" type="password" name="password">
        </div>

        <div class="row">
            <input type="submit" value="Sign In">
        </div>
    </form>
</body>
</html>