{{ $name }} is {{ $age}}

@when( $age <= 10 )
		You are a kid
@or( $age > 10 )
		You are growing!
@done


@foreach($array as $arr)
		<h1>	{{ $arr }} </h1>
@endforeach