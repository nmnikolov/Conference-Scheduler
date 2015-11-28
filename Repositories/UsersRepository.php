<?php
declare(strict_types=1);

namespace Framework\Repositories;

use Framework\Database\Database;
use Framework\Exceptions\ApplicationException;
use Framework\HttpContext\HttpContext;
use Framework\Models\Conference;
use Framework\Models\Hall;

class UsersRepository
{
    /**
     * @var UsersRepository
     */
    private static $inst = null;

    /**
     * @var Database
     */
    private $db;

    /**
     * UsersRepository constructor.
     * @param Database $db
     */
    private function __construct(Database $db){
        $this->db = $db;
    }

    /**
     * @return UsersRepository
     */
    public static function getInstance() : UsersRepository
    {
        if (self::$inst == null){
            self::$inst = new UsersRepository(Database::getInstance('app'));
        }

        return self::$inst;
    }

    /**
     * @return array
     */
    public function getAllUsers(){
        $userId = HttpContext::getInstance()->getIdentity()->getCurrentUser()->getId();
        $query = "SELECT
            u.id,
            u.username,
            u.fullname,
            r.name AS roleName
        FROM users AS u
        JOIN user_roles AS ur
          ON ur.user_id = u.id
        JOIN roles AS r
          ON r.id = ur.role_id
        WHERE u.id != ?
        ORDER BY u.username";

        $result = $this->db->prepare($query);
        $result->execute([$userId]);

        return $result->fetchAll();
    }

    /**
     * @param int $id
     * @throws ApplicationException
     */
    public function getById(int $id){
        $query = "SELECT
          u.id,
          u.username,
          u.fullname
        FROM users AS u
        WHERE u.id = ?";

        $result = $this->db->prepare($query);
        $result->execute([$id]);

        if($result->rowCount() < 1 ){
            throw new ApplicationException("User not found.");
        }

        return $result->fetch();
    }
}