<?php
declare(strict_types=1);

namespace Framework;

include 'Helpers/Helpers.php';
use Framework\Helpers\Helpers;

class Autoloader
{
    public static function init(){
        spl_autoload_register(function($class){
            $pathParams = explode('\\', $class);
            $path = implode(DIRECTORY_SEPARATOR, $pathParams);
            $path = str_replace($pathParams[0], "", $path);


            if (!file_exists(substr($path . '.php', 1))) {
                Helpers::redirect();
            }

            require_once $path . '.php';
        });
    }
}