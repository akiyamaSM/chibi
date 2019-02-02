<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

{{ $name }} is {{ $age}}

<?php $var = 30 ?>

@when( $age <= 10 )
You are a kid
@or( $age > 10 )
You are growing!
@done


@foreach($array as $arr)
<h1>	{{ $arr }} </h1>
@endforeach


<h3>	{{ $var }}</h3>

<script src="/dist/build.js"></script>
</body>
</html>