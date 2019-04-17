<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <title>Login page</title>
</head>
<body class="bg-blue container mx-auto">
    @if( $error = flash('error') )
        <span>{{ $error }}</span>
    @done
    <div class="flex h-screen items-center justify-center">
        <form action="@@route('auth.login.post')" method="POST" class="w-3/5 bg-blue-light flex flex-col items-center py-16">
            @csrf_field
            <input class="mb-4 px-6 py-3 rounded-lg text-grey-dark" id="username" type="text" name="username" placeholder="email@example.com">
            <input class="px-6 py-3 rounded-lg text-grey-dark"  id="password" type="password" name="password" placeholder="*********">
            <input class="px-6 py-3 rounded-lg" type="submit" value="Sign In">
        </form>
    </div>
</body>
</html>
