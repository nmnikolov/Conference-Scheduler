<?php
declare(strict_types=1);

namespace Framework;

use Framework\Annotations\AnnotationsParser;
use Framework\Config\AppConfig;
use Framework\Helpers\Helpers;
use Framework\Helpers\Scanner;
use Framework\ORM\Manager;

class FrontController
{
    private $controllerName;
    private $actionName;
    private $requestParams = [];

    private $controller;

    public function __construct(\Framework\Routers\Router $router){
        try{
            $this->controllerName = $router->getControllerName();
            $this->actionName = $router->getActionName();
            $this->requestParams = $router->getParams();
        } catch (\Exception $e) {
            Helpers::redirect();
        }
    }

    public function dispatch(){
        $this->initController();

        View::$controllerName = $this->controllerName;
        View::$actionName = $this->actionName;

        if (!call_user_func_array(
            [
                $this->controller,
                $this->actionName
            ],
            $this->requestParams
        )) {
            Helpers::redirect();
        }
    }

    private function initController(){
        $controllerName = $this->controllerName;
        if (!Helpers::startsWith($controllerName, AppConfig::CONTROLLERS_NAMESPACE)) {
            $controllerName = AppConfig::CONTROLLERS_NAMESPACE
                . ucfirst($this->controllerName)
                . AppConfig::CONTROLLERS_SUFFIX;
        }

        try {
            class_exists($controllerName, false);
            $annotationsParser = new AnnotationsParser($controllerName, $this->actionName);
            $annotationsParser->checkAnnotations();
            $this->controller = new $controllerName();
        } catch (\Exception $e) {
            Helpers::redirect();
        }

        $this->controller = new $controllerName();
    }
}