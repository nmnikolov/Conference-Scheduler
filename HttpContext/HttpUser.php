<?php

namespace Framework\HttpContext;

use Framework\Config\AppConfig;
use Framework\Identity\UserManager;
use Framework\Interfaces\HttpUserInterface;
use Framework\Models\ViewModels\UserProfileViewModel;

class HttpUser implements HttpUserInterface
{
    /**
     * @var UserProfileViewModel
     */
    private $currentUser;

    /**
     * HttpUser constructor.
     */
    public function __construct() {
    }

    /**
     * @return bool
     */
    public function isLogged() : bool {
        return (string) HttpContext::getInstance()->getSession()->userId !== "";
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool {
        if ($this->isLogged()) {
            $userId =(string) HttpContext::getInstance()->getSession()->userId;
            return UserManager::getInstance()->isInRoleById($userId, AppConfig::DEFAULT_ADMIN_ROLE);
        }

        return false;
    }

    public function logout(){
        HttpContext::getInstance()->getSession()->userId->delete();
    }

    /**
     * @return UserProfileViewModel
     */
    public function getCurrentUser() : UserProfileViewModel
    {
        if ($this->isLogged()) {
            return $this->currentUser;
        }

        return new UserProfileViewModel();
    }

    public function setCurrentUser() {
        if ($this->isLogged()) {
            $userId = (string) HttpContext::getInstance()->getSession()->userId;
            $this->currentUser = UserManager::getInstance()->getUserInfo($userId);
        }
    }
}