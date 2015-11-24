<?php
//declare(strict_types=1);
//
//namespace Framework\Models;
//
//use Framework\Database\Database;
//
//class User
//{
//    private function __construct(){
//    }
//
//    public static function register(string $username, string $password) : bool
//    {
//        $db = Database::getInstance('app');
//
//        if ($username === '') {
//            throw new \Exception('Username cannot be empty');
//        }
//
//        if (self::exists($username)){
//            throw new \Exception('User already registered');
//        }
//
//        $result = $db->prepare("INSERT INTO users (username, password)
//          VALUES (?, ?)");
//
//        $result->execute([
//                $username,
//                password_hash($password, PASSWORD_DEFAULT)
//            ]
//        );
//
//        if ($result->rowCount() > 0){
//            return true;
//        }
//
//        throw new \Exception('Cannot register user');
//    }
//
//    public static function login(string $username, string $password) : string
//    {
//        $db = Database::getInstance('app');
//
//        $result = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
//        $result->execute([$username]);
//
//        if ($result->rowCount() === 0){
//            throw new \Exception("User does not exist");
//        }
//
//        $userRow = $result->fetch();
//
//        if (password_verify($password, $userRow['password'])){
//            return $userRow['id'];
//        }
//
//        throw new \Exception("Passwords does not match");
//    }
//
//    public static function edit(\Framework\ViewModels\User $user) : bool
//    {
//        $db = Database::getInstance('app');
//
//        $result = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
//        $result->execute([
//            password_hash($user->getPass(), PASSWORD_DEFAULT),
//            $user->getId()
//        ]);
//
//        return $result->rowCount() > 0;
//    }
//
//    public static function getInfo(string $id) : array
//    {
//        $db = Database::getInstance('app');
//
//        $result = $db->prepare("SELECT id, username, password FROM users WHERE id = ?");
//        $result->execute([$id]);
//
//        return $result->fetch();
//    }
//
//    public static function exists(string $username) : bool
//    {
//        $db = Database::getInstance('app');
//
//        $result = $db->prepare("SELECT id FROM users WHERE username = ?");
//        $result->execute([$username]);
//
//        return $result->rowCount() > 0;
//    }
//}