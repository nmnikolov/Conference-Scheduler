<?php
declare(strict_types=1);

namespace Framework\Identity;

use Framework\Models\BindingModels\ChangePasswordBindingModel;
use Framework\Models\BindingModels\LoginBindingModel;
use Framework\Models\BindingModels\RegisterBindingModel;
use Framework\Models\BindingModels\UserEditBindingModel;
use Framework\Models\ViewModels\RoleViewModel;
use Framework\Models\ViewModels\UserProfileViewModel;

interface UserManagerInterface
{
    static function getInstance();
    function register(RegisterBindingModel $model) : int;
    function login(LoginBindingModel $model) : string;
    function edit(UserEditBindingModel $model) : bool;
    function changePassword(ChangePasswordBindingModel $model) : bool;
    function getInfo(string $id) : array;
    function usernameExists(string $username) : bool;
    function emailExists(string $email) : bool;
    function isInRoleByUsername(string $username, string $roleName) : bool;
    function isInRoleById(string $id, string $roleName) : bool;
    function addToRole(int $userId, int $roleId) : bool;
    function getUserInfo(int $userId) : UserProfileViewModel;
    function getUserRole(int $userId) : RoleViewModel;
    function removeUserRoles(int $userId) : bool;
}