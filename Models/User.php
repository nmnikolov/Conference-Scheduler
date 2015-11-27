<?php

namespace Framework\Models;

class Hall
{
    private $username;
    private $fullname;

    /**
     * Hall constructor.
     * @param string $username
     * @param string $fullname
     */
    public function __construct(string $username, string $fullname) {
        $this->username = $username;
        $this->fullname = $fullname;
    }

    /**
     * @return string
     */
    public function getUsername() : string {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFullname() : string {
        return $this->fullname;
    }
}