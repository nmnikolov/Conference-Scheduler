<?php
declare(strict_types=1);

namespace Framework\Identity;

use Framework\Database\Database;
use Framework\Exceptions\ApplicationException;
use Framework\Models\BindingModels\LoginBindingModel;
use Framework\Models\BindingModels\RegisterBindingModel;
use Framework\Models\BindingModels\UserEditBindingModel;
use Framework\Models\ViewModels\UserProfileViewModel;

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
     * @param RegisterBindingModel $model
     * @return int
     * @throws \Exception
     */
    public function register(RegisterBindingModel $model) : int
    {
        $db = Database::getInstance('app');

        if (self::usernameExists($model->getUserName())){
            $_SESSION['binding-errors'][] = 'Username already exists.';
            throw new ApplicationException("");
        }

        if ($model->getPassword() !== $model->getConfirmPassword()) {
            $_SESSION['binding-errors'][] = 'Passwords does not match.';
            throw new ApplicationException("");
        }

        $result = $db->prepare("INSERT INTO users (username, password, fullname)
          VALUES (?, ?, ?)");

        $result->execute([
                $model->getUserName(),
                password_hash($model->getPassword(), PASSWORD_DEFAULT),
                $model->getFullName()
            ]
        );

        if ($result->rowCount() < 1){
            throw new ApplicationException('Cannot register user');
        }

        return intval($db->lastId());
    }

    /**
     * @param LoginBindingModel $model
     * @return mixed
     * @throws \Exception
     */
    public function login(LoginBindingModel $model) : string
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $result->execute([$model->getUsername()]);

        if ($result->rowCount() > 0){
            $userRow = $result->fetch();

            if (password_verify($model->getPassword(), $userRow['password'])){
                return $userRow['id'];
            }
        }

        $_SESSION["binding-errors"] = ["Wrong username or password!"];
        throw new ApplicationException("");
    }

    /**
     * @param \Framework\Models\BindingModels\UserEditBindingModel $model
     * @return mixed
     * @throws \Exception
     */
    public function edit(\Framework\Models\BindingModels\UserEditBindingModel $model) : bool
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("UPDATE users SET fullname = ? WHERE id = ?");
        $result->execute([
            $model->getFullName(),
            $_SESSION['userId']
        ]);

        return $result->rowCount() > 0;
    }

    /**
     * @param \Framework\Models\BindingModels\ChangePasswordBindingModel $model
     * @return mixed
     * @throws \Exception
     */
    public function changePassword(\Framework\Models\BindingModels\ChangePasswordBindingModel $model) : bool
    {
        if ($model->getPassword() != $model->getConfirmPassword()){
            $_SESSION['binding-errors'] = ["Passwords does not match!"];
            throw new ApplicationException('');
        }

        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT password FROM users WHERE id = ?");
        $result->execute([
            $_SESSION['userId']
        ]);

        $password = $result->fetch()["password"];

        if (!password_verify($model->getCurrentPassword(), $password)) {
            $_SESSION['binding-errors'] = ["Wrong current password!"];
            throw new ApplicationException('');
        }

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

        $result = $db->prepare("SELECT id, username, password, fullname FROM users WHERE id = ?");
        $result->execute([$id]);

        return $result->fetch();
    }

    /**
     * @param string $username
     * @return mixed
     * @throws \Exception
     */
    public function usernameExists(string $username) : bool
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id FROM users WHERE username = ?");
        $result->execute([$username]);

        return $result->rowCount() > 0;
    }

    /**
     * @param string $email
     * @return mixed
     * @throws \Exception
     */
    public function emailExists(string $email) : bool
    {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id FROM users WHERE email = ?");
        $result->execute([$email]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $username
     * @param $roleName
     * @return mixed
     * @throws \Exception
     */
    public function isInRoleByUsername(string $username, string $roleName) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT u.id FROM user_roles AS ur
          JOIN users AS u ON ur.user_id = u.id
          JOIN roles AS r ON ur.role_id = r.id
          WHERE u.username = ? AND r.name = ?");
        $result->execute([$username, $roleName]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $id
     * @param $roleName
     * @return mixed
     * @throws \Exception
     */
    public function isInRoleById(string $id, string $roleName) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT u.id FROM user_roles AS ur
          JOIN users AS u ON ur.user_id = u.id
          JOIN roles AS r ON ur.role_id = r.id
          WHERE u.id = ? AND r.name = ?");
        $result->execute([$id, $roleName]);

        return $result->rowCount() > 0;
    }

    /**
     * @param $userId
     * @param $roleId
     * @return mixed
     * @throws \Exception
     */
    public function addToRole(int $userId, int $roleId) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
        $result->execute([$userId, $roleId]);

        return $result->rowCount() > 0;
    }

    /**
     * @param int $userId
     * @return UserProfileViewModel
     * @throws \Exception
     */
    public function getUserInfo(int $userId) : UserProfileViewModel {
        $db = Database::getInstance('app');

        $result = $db->prepare("SELECT id, username, password, fullname FROM users WHERE id = ?");
        $result->execute([$userId]);
        $userRow = $result->fetch();

        $user = new UserProfileViewModel();
        $user->setId($userRow["id"])
            ->setUsername($userRow["username"])
            ->setFullName($userRow["fullname"]);

        return $user;
    }
}