<?php
declare(strict_types=1);

namespace Framework\Identity;

abstract class IdentityUser implements IdentityUserInterface
{
    /**
     * @Field id
     * @Type INT
     * @Length 11
     * @Primary
     * @Increment
     */
    protected $id;

    /**
     * @Field username
     * @Type NVARCHAR
     * @Length 255
     * @Unique
     */
    protected $username;

    /**
     * @Field password
     * @Type NVARCHAR
     * @Length 255
     */
    protected $pass;

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
    protected function __construct(string $username, string $pass, int $id)
    {
        $this->setId($id)
            ->setUsername($username)
            ->setPass($pass);
    }

    /**
     * @return mixed
     */
    public function getId() : int
    {
        if ($this->id !== null) {
            return $this->id;
        }

        return '';
    }

    /**
     * @param mixed $id
     * @return IdentityUser
     */
    private function setId(int $id) : \Framework\Identity\IdentityUser
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
     * @return IdentityUser
     */
    private function setUsername(string $username) : \Framework\Identity\IdentityUser
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
     * @return IdentityUser
     */
    private function setPass(string $pass) : \Framework\Identity\IdentityUser
    {
        $this->pass = $pass;
        return $this;
    }
}