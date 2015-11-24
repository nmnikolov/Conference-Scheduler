<?php
declare(strict_types=1);

namespace Framework\Identity;

use Framework\Database\Database;

class RoleManager implements RoleManagerInterface
{
    /**
     * @var RoleManagerInterface
     */
    protected static $inst = null;

    /**
     * RoleManager constructor.
     */
    private function __construct(){
    }

    /**
     * @return RoleManagerInterface
     */
    public static function getInstance() : RoleManagerInterface
    {
        if (self::$inst == null){
            self::$inst = new RoleManager();
        }

        return self::$inst;
    }

    public function createRole(string $roleName) : bool
    {
        $db = Database::getInstance('app');

        if ($this->exists($roleName)) {
            throw new \Exception("Role with this name already exists!");
        }

        $result = $db->prepare("INSERT INTO Roles (rolename) VALUES (?)");
        $result->execute([$roleName]);

        return $result->rowCount() > 0;
    }

    public function exists(string $roleName) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id FROM roles WHERE rolename = ?");
        $result->execute([$roleName]);

        return $result->rowCount() > 0;
    }

    public function getRoleId(string $roleName) : int {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id FROM roles WHERE name = ?");
        $result->execute([$roleName]);

        if ($result->rowCount() === 0) {
            throw new \Exception("Role with this name does not exists");
        }

        return  intval($result->fetch()["id"]);
    }
}