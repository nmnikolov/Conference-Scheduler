<?php
declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Config\AppConfig;
use Framework\Helpers\Helpers;
use Framework\HttpContext\HttpContext;
use Framework\Models\ViewModels\DummyViewModel;
use Framework\View;

abstract class BaseController
{
    /**
     * @var HttpContext
     */
    protected $context = null;

    /**
     * BaseController constructor.
     * @param HttpContext $context
     * @NoAction
     */
    public function __construct(HttpContext $context) {
        $this->context = $context;
    }

    /**
     * @NoAction
     * @param $model
     */
    public function renderDefaultLayout($model = null) {
        $layout = AppConfig::DEFAULT_LAYOUT;

        if ($model === null) {
            $dummy = new DummyViewModel();
            View::initView($dummy, $layout);
        } else {
            View::initView($model, $layout);
        }
    }

    /**
     * @NoAction
     * @param string $layout
     * @param $model
     */
    public function renderCustomLayout(string $layout,  $model = null) {
        if ($model === null) {
            $dummy = new DummyViewModel();
            View::initView($dummy, $layout);
        } else {
            View::initView($model, $layout);
        }
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