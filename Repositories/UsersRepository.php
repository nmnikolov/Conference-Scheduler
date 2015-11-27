<?php
declare(strict_types=1);

namespace Framework\Repositories;

use Framework\Database\Database;
use Framework\Exceptions\ApplicationException;
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
        $query = "SELECT
            u.id,
            u.username,
            u.fullname
        FROM users AS u
        ORDER BY u.username";

        $result = $this->db->prepare($query);
        $result->execute([]);

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