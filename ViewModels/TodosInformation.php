<?php
declare(strict_types=1);

namespace Framework\ViewModels;

class TodosInformation
{
    public $error = false;
    public $success = false;

    /**
     * @var \Framework\ViewModels\User
     */
    private $user = null;

    public function setUser(\Framework\ViewModels\User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Framework\ViewModels\User
     */
    public function getUser() : \Framework\ViewModels\User
    {
        if ($this->user !== null) {
            return $this->user;
        }

        return new \Framework\ViewModels\User();
    }
}