# chibi
Chibi Is a mini PHP framework to work on small projects, containing the following elements.

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

#Simple ORM
