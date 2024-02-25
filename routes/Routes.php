<?php

namespace Router;

use App\RouteException\RouteException;


class Routes 
{
    private $url;
    private $routes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes["GET"][] = $route;
    }

    public function post($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes["POST"][] = $route;
    }

    public function run()
    {
       if(!isset($this->routes[$_SERVER["REQUEST_METHOD"]])){
            return throw new RouteException("REQUEST_METHOD does not exist");
       }

       foreach($this->routes[$_SERVER["REQUEST_METHOD"]] as $route){
            if($route->match($this->url)){
                return $route->call();
                die();
            }
       }

       return throw new RouteException("Not matching routes");
    }

}