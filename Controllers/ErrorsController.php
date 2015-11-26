<?php

namespace Framework\Controllers;

use Framework\HttpContext\HttpContext;
use Framework\Models\ViewModels\ErrorPageViewModel;

class ErrorsController extends BaseController
{
    /**
     * @NoAction
     * @param HttpContext $context
     */
    public function __construct(HttpContext $context)
    {
        parent::__construct($context);
    }

    /**
     * @Route(error/index)
     */
    public function index(){
        $message = isset($_SESSION["errors"]) ? $_SESSION["errors"] : "";
        $viewModel = new ErrorPageViewModel($message);

        $this->renderDefaultLayout($viewModel);
    }
}