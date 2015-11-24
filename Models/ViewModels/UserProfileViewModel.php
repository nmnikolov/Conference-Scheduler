<?php
declare(strict_types=1);

namespace Framework\Models\ViewModels;

class UserProfileViewModel
{
    private $id;
    private $username;
    private $pass;

    /**
     * @return mixed
     */
    public function isLogged() : bool
    {
        return $this->username !== null;
    }

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
     * @return UserProfileViewModel
     */
    public function setId($id) : UserProfileViewModel
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
     * @return UserProfileViewModel
     */
    public function setUsername($username) : UserProfileViewModel
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
     * @return UserProfileViewModel
     */
    public function setPass($pass) : UserProfileViewModel
    {
        $this->pass = $pass;
        return $this;
    }
}