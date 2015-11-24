<?php
declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Config\AppConfig;
use Framework\Helpers\Helpers;
use Framework\View;

abstract class BaseController
{
    /**
     * @NoAction
     */
    public function render($model, $layout = AppConfig::DEFAULT_LAYOUT) {
        View::initView($model, $layout);
    }

    /**
     * @NoAction
     */
    public function isLoggedIn(){
        return isset($_SESSION['userId']);
    }

    /**
     * @NoAction
     */
    public function authorize($redirectionPath, $authorizeLogged = true) {

        if (!$this->isLoggedIn() && $authorizeLogged === true) {
            $this->redirect($redirectionPath);
        }

        if ($this->isLoggedIn() && $authorizeLogged === false) {
            $this->redirect($redirectionPath);
        }
    }

    /**
     * @NoAction
     */
    public function redirect($path = AppConfig::DEFAULT_REDIRECTION) {
        header("Location: " . Helpers::url() . $path);
        exit;
    }
}