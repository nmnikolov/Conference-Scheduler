<?php
declare(strict_types=1);

namespace Framework;

use Framework\Config\AppConfig;
use Framework\Exceptions\ApplicationException;
use Framework\Helpers\Helpers;

class View
{
    public static $controllerName;
    public static $actionName;

    /**
     * @param $model
     * @param string $layout
     * @throws ApplicationException
     */
    public static function initView($model, string $layout){
        self::viewAdjustment();

        $viewPath = AppConfig::VIEW_FOLDER
            . DIRECTORY_SEPARATOR
            . self::$controllerName
            . DIRECTORY_SEPARATOR
            . self::$actionName
            . AppConfig::VIEW_EXTENSION;

        if (!file_exists($viewPath)) {
            throw new ApplicationException("The view file does not exist!\nFile: " . $viewPath);
        }

        $model->view = $viewPath;
        self::viewModelValidation($model, $viewPath);

        require AppConfig::VIEW_FOLDER
            . DIRECTORY_SEPARATOR
            . AppConfig::LAYOUT_FOLDER
            . DIRECTORY_SEPARATOR
            . strtolower($layout)
            . AppConfig::VIEW_EXTENSION;
    }

    private static function viewAdjustment(){
        if (Helpers::endsWith(self::$actionName, "Pst") ||
            Helpers::endsWith(self::$actionName, "Put") ||
            Helpers::endsWith(self::$actionName, "Del")) {
            self::$actionName = substr(self::$actionName, 0, strlen(self::$actionName) - 3);
        }
    }

    /**
     * @param $model
     * @param string $file
     * @throws ApplicationException
     */
    private static function viewModelValidation($model, string $file){
        $f = fopen($file, 'r');
        $line = fgets($f);
        fclose($f);

        if (preg_match_all('/@var\s+([^\s]+)\s+(\$\w+).*\r?\n/', $line, $matches)) {
            if (!class_exists($matches[1][0], false)) {
                throw new ApplicationException("Non existing class for model in the view!\nClass: " . $matches[1][0]);
            }

            if (!($model instanceof $matches[1][0])) {
                throw new ApplicationException("Submitted model was not right instance.");
            }
        }
    }
}