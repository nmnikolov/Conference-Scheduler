<?php
declare(strict_types=1);

namespace Framework\Identity;

interface UserManagerInterface
{
    static function getInstance();
    function register(string $username, string $password) : int;
    function login(string $username, string $password) : string;
    function edit(\Framework\Models\BindingModels\UserEditBindingModel $model) : bool;
    function getInfo(string $id) : array;
    function exists(string $username) : bool;
    function isInRoleByUsername(string $username, string $roleName) : bool;
    function isInRoleById(string $id, string $roleName) : bool;
    function addToRole(int $userId, int $roleId) : bool;
}