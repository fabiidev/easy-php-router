# PHP Router

This is a simple PHP class that provides routing functionality for a web application. The router allows to call certain
functions based on the URL and HTTP method.

## Installation

The installation can be done by copying the router.php file into the project and then including it using
by means of require_once.

```
require_once('router.php');
```

## Usage

### Initialization

The router can be initialized by instantiating the router class. The constructor takes a parameter
which is optional and set to true by default. This parameter allows to enable or disable the
routing functionality to be enabled or disabled.

```
$router = new router();
```

### Add routes

Routes can be added by using the addRoute method. This method takes three parameters:
The HTTP method (requestMethods enum), the URI, and a callback function. The callback function is called when
the URI and the HTTP method match the request.

```
$router->addRoute(requestMethods::GET, '/hello', function () {
        echo 'Hello World!';
});
```

### Dynamic parameters

Dynamic parameters can be used in the URI by enclosing them in curly braces. These
parameters are then passed as parameters in the callback function.

```
$router->addRoute(requestMethods::GET, '/users/{id}', function ($id) {
    echo 'User ID: ' . $id;
});
```

### Redirects

Redirections can be created by using the redirect method. This method takes three parameters:
The URI of the origin, the URI of the destination, and optionally an HTTP status code.

```
$router->redirect('/old-page', '/new-page');
```

## Example

```
require_once('app/router.php');

$router = new router();

$router->addRoute(requestMethods::ANY, '/', function () {
    echo 'Home';
});

$router->addRoute(requestMethods::GET, '/users', function () {
    echo 'User List';
});

$router->addRoute(requestMethods::POST, '/users/{id}', function () {
    // Content
});

$router->addRoute(requestMethods::POST, '/users', function () {
    // Handle POST request
});

$router->redirect('/old-page', '/new-page');
```