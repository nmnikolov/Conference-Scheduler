<?php
declare(strict_types=1);

namespace Framework\Annotations;

use Framework\Config\AppConfig;
use Framework\Exceptions\ApplicationException;
use Framework\Helpers\Helpers;
use Framework\HttpContext\HttpContext;
use Framework\Identity\UserManager;

class RoleAnnotation extends AbstractAnnotation
{
    private $roles;

    /**
     * AuthorizeAnnotation constructor.
     */
    public function __construct(string $roles) {
        $this->parseRoles($roles);
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

        $userRole = UserManager::getInstance()->getUserRole(intval($userId));

        if (!in_array($userRole->getName(), $this->roles)) {
            throw new ApplicationException("Not enough permissions to see this page!");
        }
    }

    private function parseRoles(string $rolesStr){
        $roles = explode(",", $rolesStr);
        $this->roles = $roles;
    }
}