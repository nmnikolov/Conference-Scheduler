<?php
declare(strict_types=1);

namespace Framework\Identity\Tables;

/**
 * Class UserRoles
 * @package Framework\Identity\Tables
 * @Table UserRoles
 * @Primary user_id
 * @Primary role_id
 * @Foreign (user_id) References users(id)
 * @Foreign (role_id) References roles(id)
 */
final class UserRoles
{
    /**
     * @var
     * @Field user_id
     * @Type INT
     * @Length 11
     * @NotNull
     */
    private $userId;

    /**
     * @var
     * @Field role_id
     * @Type INT
     * @Length 11
     * @NotNull
     */
    private $roleId;
}