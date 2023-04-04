<?php

enum requestMethods
{
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;
    case OPTIONS;
    case HEAD;
    case ANY;
}

class router
{
    private static array $activeRoutes = [];
    private static bool $isRoutingActive;

    public function __construct($activateRouting = true)
    {
        self::$isRoutingActive = $activateRouting;
    }


    /***
     * @param requestMethods $method
     * @param $uri
     * @param $callback
     * @return void
     */
    public static function addRoute(requestMethods $method, $uri, $callback): void
    {
        $route = [
            "method" => $method,
            "uri" => $uri,
            "callback" => $callback
        ];

        self::$activeRoutes[] = $route;
        self::matchRoutes($route);
    }

    /***
     * @param array $activeRoute
     * @return void
     */
    private static function matchRoutes(array $activeRoute): void
    {
        if (!self::$isRoutingActive) {
            return;
        }

        if (self::requestMethodMatchesRoutesMethod($activeRoute["method"]) && self::uriMatches($activeRoute["uri"], $_SERVER["REQUEST_URI"])) {
            $activeRoute["callback"]();
            return;
        }

        http_response_code(404);
    }

    /***
     * @param requestMethods $routeRequestMethod
     * @return bool
     */
    private static function requestMethodMatchesRoutesMethod(requestMethods $routeRequestMethod): bool
    {
        if ($routeRequestMethod == requestMethods::ANY) {
            return true;
        }

        if ($routeRequestMethod->name == $_SERVER["REQUEST_METHOD"]) {
            return true;
        }

        return false;
    }

    /***
     * Checks for dynamic parameters in the route uri
     *
     * @param string $routeURI
     * @param string $requestURI
     * @return bool
     */
    private static function uriMatches(string $routeURI, string $requestURI): bool
    {
        $routeURI = preg_replace('/\{[^\/]+\}/', '[^/]+', $routeURI);

        if (preg_match("#^$routeURI$#", $requestURI)) {
            return true;
        }

        return false;
    }

    /***
     * @param $originURI
     * @param $destinationURI
     * @param false $statuscode
     * @return void
     */
    public static function redirect($originURI, $destinationURI, int|false $statuscode = false): void
    {
        if (!self::uriMatches($originURI, $_SERVER["REQUEST_URI"])) {
            return;
        }

        header("Location: $destinationURI", true, $statuscode);
        exit();
    }
}