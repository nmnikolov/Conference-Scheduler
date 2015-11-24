<?php
declare(strict_types=1);

namespace Framework;

use Framework\Config\DatabaseConfig;
use Framework\Database\Database;
use Framework\Helpers\Scanner;
use Framework\ORM\Manager;

class App
{
    /**
     * @var \Framework\FrontController
     */
    private $frontController;

    /**
     * @param \Framework\FrontController $frontController
     */
    public function __construct($frontController){
        $this->setFrontController($frontController);
    }

    /**
     * @param \Framework\FrontController $frontController
     */
    public function setFrontController($frontController) {
        $this->frontController = $frontController;
    }

    public function start(){
        Database::createNonExistingDatabase(DatabaseConfig::DB_NAME);

//        var_dump(Scanner::getInstance()->getCustomRoutes());
//        exit;

        Database::setInstance(
            DatabaseConfig::DB_INSTANCE,
            DatabaseConfig::DB_DRIVER,
            DatabaseConfig::DB_USER,
            DatabaseConfig::DB_PASS,
            DatabaseConfig::DB_NAME,
            DatabaseConfig::DB_HOST
        );

        Manager::getInstance()->start();

        $this->frontController->dispatch();
    }
}