<?php
declare(strict_types=1);

namespace Framework\Models\BindingModels;

class UserEditBindingModel
{
    /**
     * @Require
     */
    private $password;

    /**
     * @Require
     */
    private $confirmPassword;

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