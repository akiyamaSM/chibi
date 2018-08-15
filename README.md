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

# Views

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
	App\Hurdles\YearIsCurrent::class,
];
```

# Simple ORM
The Chibi framework is using [Francesco Bianco](https://github.com/francescobianco)'s ORM([moldable](https://github.com/javanile/moldable)), take a look on it to know how to use it.
