<?php

namespace Framework\Models\ViewModels;

class AdminChangeRoleViewModel
{
    private $user;
    private $role;
    private $roles = [];

    /**
     * AdminChangeRoleViewModel constructor.
     * @param UserProfileViewModel $user
     * @param RoleViewModel $role
     * @param array $roles
     */
    public function __construct(UserProfileViewModel $user, RoleViewModel $role, array $roles) {
        $this->user = $user;
        $this->role = $role;
        $this->roles = $roles;
    }

    /**
     * @return UserProfileViewModel
     */
    public function getUser() : UserProfileViewModel {
        return $this->user;
    }

    /**
     * @return RoleViewModel
     */
    public function getRole() : RoleViewModel {
        return $this->role;
    }

    /**
     * @return array
     */
    public function getRoles() : array {
        return $this->roles;
    }
}