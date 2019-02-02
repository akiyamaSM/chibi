# Chibi
Chibi is a mini PHP framework to work on small projects, containing the following elements.

# Routing
With Chibi its really easy to make your routes

## Route to Controller
```php
$router->get('/users, 'App\Controllers\HomeController@views');
```
## Route to closure
```php
$router->post('/user/{user}/{name}', function($user, $name){
    
});
```
## A Response & Request instances are allways passed for you out of the box you just need to type hint it
```php
$router->post('/customers', function(Request $request, Response $respone){

    $name = $request->only('name');
    
    return $response->withJson([
      'name' => $name
      ])->withStatus(200);
      
});
```

# Controllers

Every Controller used in the app should extends the Chibi\Controller\Controller Controller.

# Views
You can pass data from controllers to the view via the view method

```php

    public function views()
    {
        $array = [
            'one',
            'two',
            'three'
        ];
        return view('hello', [
            'name' => 'Houssain',
            'age' => 26,
            'array' => $array,
        ]);
    }

```

The views are in the View folder with a Chibi.php extenstion.

A simple templete engin is provided.

```php

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


<h3> {{ $var }}</h3>


```

# Hurdles


Do you want to protect some routes? To be able to access to it only if some conditions are verified, sure you can do! Just use Hurdles for your routes
## Create a Hurdle
A hurdle Object should implement the Wall Interface
```php

namespace App\Hurdles;

use Chibi\Hurdle\Wall;
use Chibi\Request;
use Chibi\Response;

class YearIsCurrent implements Wall{

	public function filter(Request $request, Response $response){

		if($request->has('year') && $request->only('year') == 2018){
			return true;
		}

		return false;
	}
}
```
## Use the Hurdle in the route as follow

```php
$router->get('/users, 'App\Controllers\HomeController@views')->allow(App\Hurdles\YearIsCurrent::class);
```
## Apply a Hurdle for all routes
Well its easy, Just fill the register file in the App\Hurdles Folder

```php
return [
	'Csrf' => Chibi\Hurdle\CSRFTokenable::class,
	'YearIsCurrent' => App\Hurdles\YearIsCurrent::class,
];
```

## CSRF Token

A CSRFTokenable Hurdle will be run at each POST request to protect you from Cross-Site Request Forgery attacks, you only need to include the @csrf_field in the form, otherwise an Exception will be thrown.

```php

<form action=" <?php echo route('test_csrf') ?>" method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" />
    @csrf_field
    <input type="submit">
</form>
```


# Katana ORM
The Chibi framework is using its simple Katana ORM, simple and easy to use, you don't have to make a lot of effor to handle your Models. for the time being it supports:

- Model::find($id); // get the model or null
- Model::findOrFail($id); // get the model or ModelNotFoundException is thrown
- $model_instance->property = 'new Value'; // set the value
- $model_instance->property; // get the value
- $model_instance->update(); // make persist the changes
- $model_instance->save(); // create a new instance if not exist, otherwise update it
- $model_instance->delete(); // remove the model
- Model::destory($ids); // you can pass an id or array of ids to destroy

# Authentication system out of the box

With Chibi framework you will do practicaly nothing to build a system of authentication.

## Set up the Model

Your Katana model should extend the Authenticated class where you should set up the name of the guard.

```php


namespace App;

use Chibi\Auth\Authenticated;

class User extends Authenticated
{
    static $table = 'users';

    /**
     * The guard name
     *
     * @return string
     */
    function guard(): string
    {
        return 'users';
    }
}

```
## Connexion

You can use the following methods:
- $user->forceLogging(); // To force the selected user to login 
- $user->logout(); // to logout
- $user->check(); // check if the current user is logged in
- Auth::against('users')->loginWith(1); // force to log specific use against a guard
- Auth::against('users')->user(); // get the Katana instance of the connected user or null
- Auth::logOut(); // logout the connected user
- Auth::against('users')->canLogin($username, $password, $extra); // check if the user can be logged in

### Hurdles
Chibi framework ships with some useful hurdles that will help you to protect your routes depending on the situation

#### GUEST

```php

$route->get('/onlyGuests', function(){
    return 'only Guests can enter';
})->allow('Guest');

```

#### Auth

```php

$route->get('/onlyAuth', function(){
    return 'only Guests can enter';
})->allow('Auth');

```

You can pass the name of the guard as an option to check against it


```php

$route->get('/onlyAdmins', function(){
    return 'only Guests can enter';
})->allow('Auth:admins');

``` 