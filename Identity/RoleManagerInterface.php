<?php
declare(strict_types=1);

namespace Framework\Identity;

interface RoleManagerInterface
{
    /**
     * @param string $roleName
     * @return bool
     */
    function createRole(string $roleName) : bool;

    /**
     * @param string $roleName
     * @return bool
     */
    function exists(string $roleName) : bool;

    /**
     * @param string $roleName
     * @return int
     */
    function getRoleId(string $roleName) : int;
}