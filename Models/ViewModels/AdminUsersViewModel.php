<?php

namespace Framework\Models\ViewModels;

class AdminUsersViewModel
{
    /**
     * @var array
     */
    private $users = [];

    /**
     * HallViewModel constructor.
     * @param array $users
     */
    public function __construct(array $users) {
        $this->users = $users;
    }

    /**
     * @return array
     */
    public function getUsers() : array {
        return $this->users;
    }
}