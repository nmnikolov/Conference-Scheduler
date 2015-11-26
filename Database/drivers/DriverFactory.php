<?php
declare(strict_types=1);

namespace Framework\Database\Drivers;

class DriverFactory
{
    /**
     * @param string $driver
     * @param string $user
     * @param string $pass
     * @param string $dbName
     * @param string $host
     * @return DriverAbstract
     * @throws \Exception
     */
    public static function Create(string $driver, string $user, string $pass, string $dbName, string $host) : DriverAbstract
    {
        switch(strtolower($driver)){
            case 'mysql':
                return new MySqlDriver($user, $pass, $dbName, $host);
            default:
                throw new \Exception('non-existing driver');
        }
    }
}