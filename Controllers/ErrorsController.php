<?php

namespace Framework\Controllers;

use Framework\Models\ViewModels\ErrorPageViewModel;

class ErrorsController extends BaseController
{
    /**
     * @Route(error/index)
     */
    public function index(){
//        var_dump($_SESSION);
//        exit;
        $message = isset($_SESSION["errors"]) ? $_SESSION["errors"] : "";
        $viewModel = new ErrorPageViewModel($message);

        $this->render($viewModel);
        return true;
    }
}