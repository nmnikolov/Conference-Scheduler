<?php
declare(strict_types=1);

namespace SoftUni\ViewModels;

use Framework\Models\ViewModels\UserProfileViewModel;

class ProfileInformation
{
    public $error = false;
    public $success = false;

    /**
     * @var UserProfileViewModel
     */
    private $user = null;

    public function setUser(UserProfileViewModel $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserProfileViewModel
     */
    public function getUser() : UserProfileViewModel
    {
        return $this->user;
    }
}