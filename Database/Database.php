<?php
declare(strict_types=1);

namespace Framework\Database;

use Framework\Config\DatabaseConfig;
use Framework\Database\Drivers\DriverFactory;

class Database
{
    private static $inst = [];

    /**
     * @var \PDO
     */
    private $db = null;

    private function __construct($dbInstance){
        $this->db = $dbInstance;
    }

    public static function setInstance(
        $instanceName,
        $driver,
        $user,
        $pass,
        $dbName,
        $host = null
    ){
        $driver = DriverFactory::Create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO(
            $driver->getDsn(),
            $user,
            $pass
        );

        self::$inst[$instanceName] = new self($pdo);
    }

    /**
     * @param string $instanceName
     * @return Database
     * @throws \Exception
     */
    public static function getInstance(string $instanceName = 'default'){
        if (self::$inst[$instanceName] == null){
            throw new \Exception('Instance with that name was not set');
        }

        return self::$inst[$instanceName];
    }

    /**
     * @param string $dbName
     */
    public static function createNonExistingDatabase(string $dbName){
        $pdo = new \PDO("mysql:host=" . DatabaseConfig::DB_HOST, DatabaseConfig::DB_USER, DatabaseConfig::DB_PASS);

        $pdo->query("CREATE DATABASE IF NOT EXISTS $dbName
            CHARACTER SET utf8
            COLLATE utf8_general_ci;");
    }

    /**
     * @param string $statement
     * @param array $driverOptions
     * @return Statement
     */
    public function prepare($statement, array $driverOptions = []){
        $statement = $this->db->prepare($statement, $driverOptions);

        return new Statement($statement);
    }

    public function query($query){
        return $this->db->query($query);
    }

    public function lastId($name = null){
        return $this->db->lastInsertId($name);
    }
}