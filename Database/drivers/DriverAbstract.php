<?php
declare(strict_types=1);

namespace Framework\Database\Drivers;

abstract class DriverAbstract
{
    /**
     * @var string
     */
    protected $user;

    /**
     * @var
     */
    protected $pass;

    /**
     * @var
     */
    protected $dbName;

    /**
     * @var
     */
    protected $host;

    public function __construct(string $user, string $pass, string $dbName, string $host = null){
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
        $this->host = $host;
    }

    /**
     * @return string
     */
    public abstract function getDsn();
}