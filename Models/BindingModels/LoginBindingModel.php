<?php
declare(strict_types=1);

namespace Framework\Models\BindingModels;

class LoginBindingModel
{
    /**
     * @Required
     * @MinLength(3)
     * @MaxLength(30)
     * @Display(Username)
     */
    private $username;

    /**
     * @Required
     * @MinLength(6)
     * @MaxLength(30)
     * @Display(Password)
     */
    private $password;

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
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
}