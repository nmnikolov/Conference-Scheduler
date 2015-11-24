<?php
declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Identity\UserManager;
use Framework\ViewModels\TodosInformation;

class HomeController extends BaseController
{
    /**
     * @return bool
     */
    public function home() : bool
    {
        $viewModel = new TodosInformation();

        if (!$this->isLoggedIn()) {
            $this->render($viewModel);
            return true;
        }

        $userRow = UserManager::getInstance()->getInfo($_SESSION['userId']);

        $user = new \Framework\ViewModels\User(
            $userRow['username'],
            $userRow['password'],
            $userRow['id']
        );
        $viewModel->setUser($user);

        $this->render($viewModel);
        return true;
    }

    /**
     * @return bool
     * @param int $a
     * @param string $b
     * @@Authorize
     * @Route(muhaha/ttt/{int}/aac/{str})
     * @POST
     * @GET
     */
    public function test1(int $a, string $b){
        $viewModel = new TodosInformation();

        $this->render($viewModel);
        return true;
    }

    /**
     * @return bool
     * @@Authorize
     * @Route(test/test)
     * @POST
     * @GET
     */
    public function test2(){

    }
}