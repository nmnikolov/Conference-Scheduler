<?php
declare(strict_types=1);

namespace SoftUni\ViewModels;


use Framework\Models\ViewModels\ChangePasswordViewModel;

class PasswordInformation
{
    public $error = false;
    public $success = false;

    /**
     * @var ChangePasswordViewModel
     */
    private $user = null;

    public function setUser(ChangePasswordViewModel  $user)
    {
        $this->user = $user;
    }

    /**
     * @return ChangePasswordViewModel
     */
    public function getUser() : ChangePasswordViewModel
    {
        return $this->user;
    }
}