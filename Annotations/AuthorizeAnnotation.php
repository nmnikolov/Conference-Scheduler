<?php
declare(strict_types=1);

namespace Framework\Annotations;

use Framework\Helpers\Helpers;

class AuthorizeAnnotation extends AbstractAnnotation
{
    /**
     * AuthorizeAnnotation constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    public function dispatch() {
        $this->beforeActionExecute();
    }

    private function beforeActionExecute(){
        if (!isset($_SESSION['userId'])) {
            Helpers::redirect("users/login");
        }
    }
}