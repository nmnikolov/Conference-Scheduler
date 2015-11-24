<?php
declare(strict_types=1);

namespace Framework\Routers;

use Framework\Config\AppConfig;
use Framework\Helpers\Helpers;
use Framework\Helpers\Scanner;

class Router
{
    private $controller = null;
    private $action = null;
    private $params = [];
    private $customRoutes = [];

    public function __construct() {
        $this->parseURI();
    }

    private function parseURI(){
        $uri = $_SERVER['REQUEST_URI'];
        $self = $_SERVER['PHP_SELF'];
        $index = basename($self);
        $directories = str_replace($index, '', $self);
        $requestString = str_replace($directories, '', $uri);
        $requestParams = explode("/", $requestString);

        $this->controller = array_shift($requestParams);
        $this->action = array_shift($requestParams);
        $this->params = $requestParams;

        $this->customRoutes = Scanner::getInstance()->getCustomRoutes();

        if (!$this->searchCustomRoutes($requestParams)) {
            $this->actionNameAdjustment();
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->checkBindingModel();
        }
    }

    public function getControllerName() : string
    {
        if (strpos($this->controller,'.') !== false) {
            throw new \Exception("Wrong controller name");
        }

        if ($this->controller == null   ) {
            return AppConfig::DEFAULT_CONTROLLER;
        }

        return $this->controller;
    }

    public function getActionName() : string
    {
        if ($this->action == null   ) {
            return AppConfig::DEFAULT_ACTION;
        }

        return $this->action;
    }

    public function getParams() : array
    {
        return $this->params;
    }

    private function searchCustomRoutes(array $requestParams) : bool{
        foreach ($this->customRoutes as $key => $val) {
            if (!in_array($_SERVER['REQUEST_METHOD'], $val["methods"])) {
                continue;
            }

            $found = true;
            $tempParams = array();
            if (Helpers::startsWith($key, $this->controller . "/" . $this->action)) {
                if (count($requestParams) === count($val["parameters"])) {
                    for ($i = 0; $i < count($val["parameters"]); $i++) {
                        if ($val["parameters"][$i] === "{int}" && Helpers::isInteger($requestParams[$i])) {
                            $tempParams[] = intval($requestParams[$i]);
                        } else if ($val["parameters"][$i] === "{str}") {
                            $tempParams[] = $requestParams[$i];
                        } else if ($val["parameters"][$i] !== $requestParams[$i]) {
                            $found = false;
                            break;
                        }
                    }
                    
                    if ($found) {
                        $this->controller = lcfirst(substr($val["controller"], 0, strlen($val["controller"]) - strlen(AppConfig::CONTROLLERS_SUFFIX)));
                        $this->action = $val["action"];
                        $this->params = $tempParams;
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function checkBindingModel(){
        $controller = AppConfig::CONTROLLERS_NAMESPACE
            . ucfirst($this->getControllerName())
            . AppConfig::CONTROLLERS_SUFFIX;
        $reflector = new \ReflectionClass($controller);
        $method = $reflector->getMethod($this->action);
        if(!$method->getParameters()){
            return;
        }
        $params = $method->getParameters();

        $count = 0;
        foreach ($params as $param) {
            if ($param->getClass() !== null && class_exists($param->getClass()->getName(), false)) {
                $className = $param->getClass()->getName();

                if (Helpers::endsWith($className, "BindingModel")) {
                    $paramReflectorClass = new \ReflectionClass($param->getClass()->getName());
                    $bindingModelName = $paramReflectorClass->getName();
                    $bindingModel = new $bindingModelName();
                    $paramClassFields = $paramReflectorClass->getProperties();
                    foreach($paramClassFields as $field) {
                        $doc = $field->getDocComment();
                        $annotation = self::docBlockParser($doc);
                        $fieldName = $field->getName();
                        $setter = 'set' . $field->getName();
                        if(!empty($annotation)){
                            if (strtolower($annotation[0]) == '@require') {
                                if (!isset($_POST[$fieldName])) {
                                    $setter = 'set' . $field->getName();
                                    $bindingModel->$setter("{$fieldName} is required");
                                    continue;
                                }
                                $setter = 'set' . $field->getName();
                                $bindingModel->$setter($_POST[$fieldName]);
                            } else {
                                if (isset($_POST[$fieldName])) {
                                    $bindingModel->$setter($_POST[$fieldName]);
                                }
                            }
                        }
                    }
                    $this->params[] = $bindingModel;
                }
            } else if (count($this->params) < $count + 1){
                throw new \Exception("Different parameters count!");
            } else if (preg_match('/@param ([^\s]+) \$' . $param->getName() . "/", $method->getDocComment(), $parameterType)){
                if ($parameterType[1] === "int") {
                    $this->params[$count] = intval($this->params[$count]);
                }
            }

            $count++;
        }
    }

    private  function actionNameAdjustment(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->action .= "Pst";
        } else if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
            $this->action .= "Put";
        } else if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
            $this->action .= "Del";
        }
    }

    private static function docBlockParser($data){
        preg_match_all('/(@\w+)(.*)\r?\n/', $data, $matches);
        foreach($matches[0] as &$match){
            $match = trim(preg_replace('/\s\s+/', '', $match));
        }
        return $matches[0];
    }


//    private function checkBindingModel(){
//        $controller = AppConfig::CONTROLLERS_NAMESPACE
//            . ucfirst($this->getControllerName())
//            . AppConfig::CONTROLLERS_SUFFIX;
//        $reflector = new \ReflectionClass($controller);
//        $method = $reflector->getMethod($this->action);
//        if(!$method->getParameters()){
//            return;
//        }
//        $params = $method->getParameters();
//
//        $count = 0;
//        foreach ($params as $param) {
//            if ($param->getClass() !== null && class_exists($param->getClass()->getName(), false)) {
//                $className = $param->getClass()->getName();
//
//                if (Helpers::endsWith($className, "BindingModel")) {
//                    $paramReflectorClass = new \ReflectionClass($param->getClass()->getName());
//                    $bindingModelName = $paramReflectorClass->getName();
//                    $bindingModel = new $bindingModelName();
//                    $paramClassFields = $paramReflectorClass->getProperties();
//                    foreach($paramClassFields as $field) {
//                        $doc = $field->getDocComment();
//                        $annotation = self::docBlockParser($doc);
//                        $fieldName = $field->getName();
//                        $setter = 'set' . $field->getName();
//                        if(!empty($annotation)){
//                            if (strtolower($annotation[0]) == '@require') {
//                                if (!isset($_POST[$fieldName])) {
//                                    $setter = 'set' . $field->getName();
//                                    $bindingModel->$setter("{$fieldName} is required");
//                                    continue;
//                                }
//                                $setter = 'set' . $field->getName();
//                                $bindingModel->$setter($_POST[$fieldName]);
//                            } else {
//                                if (isset($_POST[$fieldName])) {
//                                    $bindingModel->$setter($_POST[$fieldName]);
//                                }
//                            }
//                        }
//                    }
//                    $this->params[] = $bindingModel;
//                }
//            } else if (count($this->params) < $count + 1){
//                throw new \Exception("Different parameters count!");
//            } else if (preg_match('/@param ([^\s]+) \$' . $param->getName() . "/", $method->getDocComment(), $parameterType)){
//                if ($parameterType[1] === "int") {
//                    $this->params[$count] = intval($this->params[$count]);
//                }
//            }
//
//            $count++;
//        }
//    }
}