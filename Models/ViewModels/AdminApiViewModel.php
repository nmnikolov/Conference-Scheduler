<?php

namespace Framework\Models\ViewModels;

class AdminApiViewModel
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * AdminApiViewModel constructor.
     * @param array $routes
     */
    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    /**
     * @return array
     */
    public function getRoutes() : array {
        return $this->routes;
    }
}