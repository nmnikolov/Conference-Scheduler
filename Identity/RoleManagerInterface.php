<?php
declare(strict_types=1);

namespace Framework\Identity;

interface RoleManagerInterface
{
    function createRole(string $roleName) : bool;
    function exists(string $roleName) : bool;
    function getRoleId(string $roleName) : int;
}