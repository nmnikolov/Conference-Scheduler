<?php
declare(strict_types=1);

namespace Framework\Annotations;

use Framework\Helpers\Helpers;
use Framework\HttpContext\HttpContext;

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
        $userId = (string) HttpContext::getInstance()->getSession()->userId;

        if ($userId == "") {
            Helpers::redirect("users/login");
        }
    }
}