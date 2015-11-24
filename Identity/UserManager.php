<?php
declare(strict_types=1);

namespace Framework\Identity;

use Framework\Database\Database;
use Framework\Models\BindingModels\UserEditBindingModel;

class UserManager implements UserManagerInterface
{
    /**
     * @var UserManagerInterface
     */
    protected static $inst = null;

    /**
     * UserManager constructor.
     */
    private function __construct(){
    }

    /**
     * @return UserManagerInterface
     */
    public static function getInstance() : UserManagerInterface
    {
        if (self::$inst == null){
            self::$inst = new UserManager();
        }

        return self::$inst;
    }

    /**
     * @param string $username
     * @param string $password
     * @return int
     * @throws \Exception
     */
    public function register(string $username, string $password) : int
    {
        $db = Database::getInstance('app');

        if ($username === '') {
            throw new \Exception('Username cannot be empty');
        }

        if (self::exists($username)){
            throw new \Exception('User already registered');
        }

        $result = $db->prepare("INSERT INTO users (username, password)
          VALUES (?, ?)");

        $result->execute([
                $username,
                password_hash($password, PASSWORD_DEFAULT)
            ]
        );

        if ($result->rowCount() > 0){
            return intval($db->lastId());
        }

        throw new \Exception('Cannot register user');
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function login(string $username, string $password) : string
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $result->execute([$username]);

        if ($result->rowCount() === 0){
            throw new \Exception("User does not exist");
        }

        $userRow = $result->fetch();

        if (password_verify($password, $userRow['password'])){
            return $userRow['id'];
        }

        throw new \Exception("Passwords does not match");
    }

    /**
     * @param \Framework\Models\BindingModels\UserEditBindingModel $model
     * @return mixed
     * @throws \Exception
     */
    public function edit(\Framework\Models\BindingModels\UserEditBindingModel $model) : bool
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $result->execute([
            password_hash($model->getPassword(), PASSWORD_DEFAULT),
            $_SESSION['userId']
        ]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getInfo(string $id) : array
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id, username, password FROM users WHERE id = ?");
        $result->execute([$id]);

        return $result->fetch();
    }

    /**
     * @param $username
     * @return mixed
     * @throws \Exception
     */
    public function exists(string $username) : bool
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id FROM users WHERE username = ?");
        $result->execute([$username]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $username
     * @param $roleName
     * @return mixed
     * @throws \Exception
     */
    function isInRoleByUsername(string $username, string $roleName) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT u.id FROM UserRoles AS ur
          JOIN users AS u ON ur.user_id = u.id
          JOIN roles AS r ON ur.role_id = r.id
          WHERE u.username = ? AND r.rolename = ?");
        $result->execute([$username, $roleName]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $id
     * @param $roleName
     * @return mixed
     * @throws \Exception
     */
    function isInRoleById(string $id, string $roleName) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT u.id FROM UserRoles AS ur
          JOIN users AS u ON ur.user_id = u.id
          JOIN roles AS r ON ur.role_id = r.id
          WHERE u.id = ? AND r.rolename = ?");
        $result->execute([$id, $roleName]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $userId
     * @param $roleId
     * @return mixed
     * @throws \Exception
     */
    function addToRole(int $userId, int $roleId) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("INSERT INTO UserRoles (user_id, role_id) VALUES (?, ?)");
        $result->execute([$userId, $roleId]);

        return $result->rowCount() > 0;
    }
}