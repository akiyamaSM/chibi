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