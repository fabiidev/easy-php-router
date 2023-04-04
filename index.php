<?php

include "app/router.php";

$router = new router();

$router->addRoute(requestMethods::GET, "/{wesrfhb}/{wesrfhb}", function () {
    include("routes/testRoute.php");
});