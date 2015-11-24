<?php
declare(strict_types=1);

namespace Framework\Identity\BindingModels;

class UserEditBindingModel
{
    private $id;
    private $username;
    private $pass;

    /**
     * User constructor.
     * @param $id
     * @param $username
     * @param $pass
     */
    public function __construct($username = null, $pass = null, $id = null)
    {
        $this->setId($id)
            ->setUsername($username)
            ->setPass($pass);
    }

    /**
     * @return mixed
     */
    public function getId() : string
    {
        if ($this->id !== null) {
            return $this->id;
        }

        return '';
    }

    /**
     * @param mixed $id
     * @return UserEditBindingModel
     */
    public function setId($id) : \Framework\Identity\BindingModels\UserEditBindingModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername() : string
    {
        if ($this->username !== null) {
            return $this->username;
        }

        return '';
    }

    /**
     * @param mixed $username
     * @return UserEditBindingModel
     */
    public function setUsername($username) : \Framework\Identity\BindingModels\UserEditBindingModel
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPass() : string
    {
        if ($this->pass !== null) {
            return $this->pass;
        }

        return '';
    }

    /**
     * @param mixed $pass
     * @return UserEditBindingModel
     */
    public function setPass($pass) : \Framework\Identity\BindingModels\UserEditBindingModel
    {
        $this->pass = $pass;
        return $this;
    }
}