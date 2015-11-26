<?php
declare(strict_types=1);

namespace Framework\Database\Drivers;

class MySqlDriver extends DriverAbstract
{
    public function getDsn() : string
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        return $dsn;
    }
}