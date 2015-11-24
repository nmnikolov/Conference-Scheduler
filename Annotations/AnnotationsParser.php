<?php
declare(strict_types=1);

namespace Framework\Annotations;

use Framework\Config\AppConfig;
use Framework\Helpers\Scanner;

class AnnotationsParser
{
    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    /**
     * AnnotationsParser constructor.
     * @param string $controller
     * @param string $action
     *
     */
    public function __construct(string $controller, string $action){
        $this->controllerName = $controller;
        $this->actionName = $action;
    }

    public function checkAnnotations()
    {
        $controllerName = explode(DIRECTORY_SEPARATOR, $this->controllerName);
        $actionName = array_pop($controllerName) . "/". $this->actionName;
        $action = Scanner::getInstance()->getAction($actionName);

        if (!in_array($_SERVER['REQUEST_METHOD'], $action["methods"])) {
            throw new \Exception($_SERVER['REQUEST_METHOD'] . " is not allowed for the action!");
        }

        foreach ($action["annotations"] as $annotation => $val) {

            if ($val === "") {
                $annotationClass = new $annotation();
            } else {
                $annotationClass = new $annotation($val);
            }

            call_user_func_array(
                [
                    $annotationClass,
                    "dispatch"
                ],
                array()
            );
        }
    }
}