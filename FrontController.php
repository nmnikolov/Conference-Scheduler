<?php
declare(strict_types=1);

namespace Framework;

use Framework\Annotations\AnnotationsParser;
use Framework\Config\AppConfig;
use Framework\Config\DatabaseConfig;
use Framework\Database\Database;
use Framework\Exceptions\ApplicationException;
use Framework\Helpers\Helpers;
use Framework\Helpers\Scanner;
use Framework\ORM\Manager;

class FrontController
{
    private $controllerName;
    private $actionName;
    private $requestParams = [];

    private $controller;
    private $router = null;

    public function __construct(\Framework\Routers\Router $router){
        $this->router = $router;
        try{
            $this->router->parseURI();
            $this->controllerName = $router->getControllerName();
            $this->actionName = $router->getActionName();
            $this->requestParams = $router->getParams();
        } catch (ApplicationException $e) {
            $_SESSION["errors"] = $e->getMessage();
            Helpers::redirect($e->getRedirectUrl());
        } catch (\Exception $e){
            Helpers::redirect("error");
        }
    }

    public function dispatch(){
        try {
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
        } catch (ApplicationException $e) {
            $_SESSION["errors"] = $e->getMessage();
            Helpers::redirect("error");
        } catch (\Exception $e) {
            Helpers::redirect("error");
        }

        unset($_SESSION["errors"]);
        unset($_SESSION["binding-errors"]);
    }

    private function initController(){
        $controllerName = $this->controllerName;
        if (!Helpers::startsWith($controllerName, AppConfig::CONTROLLERS_NAMESPACE)) {
            $controllerName = AppConfig::CONTROLLERS_NAMESPACE
                . ucfirst($this->controllerName)
                . AppConfig::CONTROLLERS_SUFFIX;
        }

            class_exists($controllerName, false);
            $annotationsParser = new AnnotationsParser($controllerName, $this->actionName);
            $annotationsParser->checkAnnotations();
            $this->controller = new $controllerName();


        $this->controller = new $controllerName();
    }
}