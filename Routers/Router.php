<?php
declare(strict_types=1);

namespace Framework\Routers;

use Framework\Config\AppConfig;
use Framework\Exceptions\ApplicationException;
use Framework\Helpers\Helpers;
use Framework\Helpers\Scanner;
use Framework\HttpContext\HttpContext;

class Router
{
    /**
     * @var string
     */
    private $controller = null;

    /**
     * @var string
     */
    private $action = null;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var array
     */
    private $customRoutes = [];

    /**
     * @var string
     */
    private $requestStr = null;

    public function __construct() {
    }

    public function parseURI(){
        $uri = $_SERVER['REQUEST_URI'];
        $self = $_SERVER['PHP_SELF'];
        $index = basename($self);
        $directories = str_replace($index, '', $self);
        $requestString = str_replace($directories, '', $uri);
        $this->requestStr = $requestString;
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

    /**
     * @return string
     * @throws ApplicationException
     */
    public function getControllerName() : string
    {
        if (strpos($this->controller,'.') !== false) {
            throw new ApplicationException("Wrong controller name");
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
        $errors = [];
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
                        $annotations = self::getBindingModelAnnotations($doc);
                        $fieldName = $field->getName();
                        $setter = 'set' . $field->getName();
                        $displayName = array_key_exists("Display", $annotations) ? $annotations["Display"] : $fieldName;

                        if (array_key_exists("Required", $annotations) && !isset($_POST[$fieldName]) || strlen($_POST[$fieldName]) === 0 ) {
                            $errors[] = $displayName . " is required.";
                        } else if (array_key_exists("MinLength", $annotations) && isset($_POST[$fieldName]) && strlen($_POST[$fieldName]) < intval($annotations["MinLength"])) {
                            $errors[] = "Min length for " . $displayName . " is " .  $annotations["MinLength"];
                        } else if (array_key_exists("MaxLength", $annotations) && isset($_POST[$fieldName]) && strlen($_POST[$fieldName]) > intval($annotations["MaxLength"])){
                            $errors[] = "Max length for " . $displayName . " is " .  $annotations["MaxLength"];
                        } else {
                            $bindingModel->$setter($_POST[$fieldName]);
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

        if (count($errors) > 0) {
            $redirect = $this->requestStr;

            if (HttpContext::getInstance()->getRequest()->getForm()->redirect !== "") {
                $redirect = HttpContext::getInstance()->getRequest()->getForm()->redirect;
            }

            $_SESSION["binding-errors"] = $errors;
            throw new ApplicationException("", $redirect);
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

    /**
     * @param string $data
     * @return array
     */
    private static function getBindingModelAnnotations(string $data) : array{
        $annotations = [];
        if(preg_match_all('/@(\w+)\s*\(([^\)]*)\)\s*\n/', $data, $matches)){
            for ($i = 0; $i < count($matches[0]); $i++) {
                $annotations[$matches[1][$i]] =  $matches[2][$i];
            }
        }
        return $annotations;
    }
}