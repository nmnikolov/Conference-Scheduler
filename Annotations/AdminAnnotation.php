<?php
declare(strict_types=1);

namespace Framework\Annotations;

use Framework\Config\AppConfig;
use Framework\Helpers\Helpers;
use Framework\Identity\UserManager;

class AdminAnnotation extends AbstractAnnotation
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
        if (!isset($_SESSION['userId']) || !UserManager::getInstance()->isInRoleById($_SESSION['userId'], AppConfig::DEFAULT_ADMIN_ROLE)) {
            Helpers::redirect("");
        }
    }
}