<?php
declare(strict_types=1);

namespace Framework;

use Framework\Config\AppConfig;

class View
{
    public static $controllerName;
    public static $actionName;

    public static function initView($model, $layout){
        self::test();

        $model->view = AppConfig::VIEW_FOLDER
            . DIRECTORY_SEPARATOR
            . self::$controllerName
            . DIRECTORY_SEPARATOR
            . self::$actionName
            . AppConfig::VIEW_EXTENSION;

        require AppConfig::VIEW_FOLDER
            . DIRECTORY_SEPARATOR
            . AppConfig::LAYOUT_FOLDER
            . DIRECTORY_SEPARATOR
            . strtolower($layout)
            . AppConfig::VIEW_EXTENSION;
    }

    private static function test(){
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            self::$actionName = substr(self::$actionName, 0, strlen(self::$actionName) - 3);
        }
    }
}