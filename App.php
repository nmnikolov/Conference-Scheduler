<?php
declare(strict_types=1);

namespace Framework;

use Framework\Config\DatabaseConfig;
use Framework\Database\Database;
use Framework\HttpContext\HttpContext;
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
    public function __construct(FrontController $frontController){
        $this->setFrontController($frontController);
    }

    /**
     * @param \Framework\FrontController $frontController
     */
    public function setFrontController(FrontController $frontController) {
        $this->frontController = $frontController;
    }

    public function start(){
        try{
            Database::createNonExistingDatabase(DatabaseConfig::DB_NAME);

            Database::setInstance(
                DatabaseConfig::DB_INSTANCE,
                DatabaseConfig::DB_DRIVER,
                DatabaseConfig::DB_USER,
                DatabaseConfig::DB_PASS,
                DatabaseConfig::DB_NAME,
                DatabaseConfig::DB_HOST
            );
        } catch (\Exception $e){
            require_once("error.php");
            exit;
        }

        Manager::getInstance()->start();
        HttpContext::getInstance()->getIdentity()->setCurrentUser();
        $this->frontController->dispatch();
    }
}