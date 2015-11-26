<?php
declare(strict_types=1);

namespace Framework\Models\ViewModels;

class ChangePasswordViewModel
{
    private $id;
    private $username;
    private $pass;

    /**
     * @return bool
     */
    public function isLogged() : bool
    {
        return $this->username !== null;
    }

    /**
     * ChangePasswordViewModel constructor.
     * @param string $username
     * @param string $pass
     * @param string $id
     */
    public function __construct(string $username = null, string $pass = null, string $id = null)
    {
        $this->setId($id)
            ->setUsername($username)
            ->setPass($pass);
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        if ($this->id !== null) {
            return $this->id;
        }

        return '';
    }

    /**
     * @param string $id
     * @return ChangePasswordViewModel
     */
    public function setId(string $id) : ChangePasswordViewModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        if ($this->username !== null) {
            return $this->username;
        }

        return '';
    }

    /**
     * @param string $username
     * @return ChangePasswordViewModel
     */
    public function setUsername(string $username) : ChangePasswordViewModel
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass() : string
    {
        if ($this->pass !== null) {

            return $this->pass;
        }

        return '';
    }

    /**
     * @param string $pass
     * @return ChangePasswordViewModel
     */
    public function setPass(string $pass) : ChangePasswordViewModel
    {
        $this->pass = $pass;
        return $this;
    }
}