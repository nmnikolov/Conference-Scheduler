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

    /**
     * Database constructor.
     * @param string $dbInstance
     */
    private function __construct(\PDO $dbInstance){
        $this->db = $dbInstance;
    }

    /**
     * @param string $instanceName
     * @param string $driver
     * @param string $user
     * @param string $pass
     * @param string $dbName
     * @param string|null $host
     * @throws \Exception
     */
    public static function setInstance(
        string $instanceName,
        string $driver,
        string $user,
        string $pass,
        string$dbName,
        string $host = ""
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
    public function prepare(string $statement, array $driverOptions = []) : Statement{
        $statement = $this->db->prepare($statement, $driverOptions);

        return new Statement($statement);
    }

    /**
     * @param string $query
     * @return \PDOStatement
     */
    public function query(string $query) : \PDOStatement{
        return $this->db->query($query);
    }

    /**
     * @param string $name
     * @return string
     */
    public function lastId(string $name = "") : string {
        return $this->db->lastInsertId($name);
    }
}