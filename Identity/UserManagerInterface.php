<?php
declare(strict_types=1);

namespace Framework\Identity;

interface UserManagerInterface
{
    static function getInstance();
    function register(\Framework\Models\BindingModels\RegisterBindingModel $model) : int;
    function login(\Framework\Models\BindingModels\LoginBindingModel $model) : string;
    function edit(\Framework\Models\BindingModels\UserEditBindingModel $model) : bool;
    function changePassword(\Framework\Models\BindingModels\ChangePasswordBindingModel $model) : bool;
    function getInfo(string $id) : array;
    function usernameExists(string $username) : bool;
    function emailExists(string $email) : bool;
    function isInRoleByUsername(string $username, string $roleName) : bool;
    function isInRoleById(string $id, string $roleName) : bool;
    function addToRole(int $userId, int $roleId) : bool;
}