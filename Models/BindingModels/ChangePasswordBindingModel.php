<?php
declare(strict_types=1);

namespace Framework\Models\BindingModels;

class ChangePasswordBindingModel
{
    /**
     * @Required
     * @MinLength(6)
     * @MaxLength(30)
     * @Display(Current Password)
     */
    private $currentPassword;

    /**
     * @Required
     * @MinLength(6)
     * @MaxLength(30)
     * @Display(Password)
     */
    private $password;

    /**
     * @Required
     * @MinLength(6)
     * @MaxLength(30)
     * @Display(Confirm Password)
     */
    private $confirmPassword;

    /**
     * @return string
     */
    public function getCurrentPassword() : string
    {
        return $this->currentPassword;
    }

    /**
     * @param string $currentPassword
     */
    public function setCurrentPassword(string $currentPassword)
    {
        $this->currentPassword = $currentPassword;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getConfirmPassword() : string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $confirmPassword
     */
    public function setConfirmPassword(string $confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }
}