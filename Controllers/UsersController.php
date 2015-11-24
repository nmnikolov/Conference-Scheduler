<?php
declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Config\AppConfig;
use Framework\Identity\BindingModels\UserEditBindingModel;
use Framework\Identity\RoleManager;
use Framework\Identity\UserManager;
use Framework\Models\BindingModels\LoginBindingModel;
use Framework\Models\BindingModels\RegisterBindingModel;
use Framework\Models\ViewModels\UserProfileViewModel;
use Framework\ViewModels\LoginInformation;
use Framework\ViewModels\RegisterInformation;
use SoftUni\ViewModels\ProfileInformation;

class UsersController extends  BaseController
{
    /**
     * @NoAction
     */
    public function __construct()
    {
    }

    /**
     * @NoAction
     */
    private function initLogin($user, $pass){
        $userId = UserManager::getInstance()->login($user, $pass);
        $_SESSION['userId'] = $userId;
        $this->redirect();
    }

    public function register(){
        $this->authorize('', false);
        $viewModel = new RegisterInformation();

        $this->render($viewModel);
        return true;
    }

    /**
     * @param RegisterBindingModel $model
     * @return bool
     * @POST
     * @param int $id
     */
    public function registerPst(RegisterBindingModel $model){
        $this->authorize('', false);
        $viewModel = new RegisterInformation();

        try {
            $userId = UserManager::getInstance()->register($model->getUsername(), $model->getPassword());
            $roleId = RoleManager::getInstance()->getRoleId(AppConfig::DEFAULT_REGISTRATION_ROLE);
            UserManager::getInstance()->addToRole($userId, $roleId);
            $this->initLogin($model->getUsername(), $model->getPassword());
        } catch (\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        $this->render($viewModel);
        return true;
    }

    /**
     * @return bool
     * @GET
     * @@NotLogged
     */
    public function login(){
        $viewModel = new LoginInformation();

        $this->render($viewModel);
        return true;
    }

    /**
     * @return bool
     * @POST
     * @@NotLogged
     */
    public function loginPst(LoginBindingModel $model) : bool {
        $viewModel = new LoginInformation();

        try {
            $this->initLogin($model->getUsername(), $model->getPassword());
        } catch (\Exception $e) {
            $viewModel->error = $e->getMessage();
        }

        $this->render($viewModel);
        return true;
    }

    /**
     * @@Authorize
     */
    public function logout(){
        if ($this->isLoggedIn()) {
            unset($_SESSION['userId']);
        }

        $this->redirect();
    }

    /**
     * @return bool
     * @@Authorize
     */
    public function profile(){
        $viewModel = new ProfileInformation();
        $userRow = UserManager::getInstance()->getInfo($_SESSION['userId']);

        $user = new UserProfileViewModel(
            $userRow['username'],
            $userRow['password'],
            $userRow['id']
        );
        $viewModel->setUser($user);

        $this->render($viewModel);
        return true;
    }

    /**
     * @param \Framework\Models\BindingModels\UserEditBindingModel $model
     * @return bool
     * @@Authorize
     * @POST
     */
    public function profilePst(\Framework\Models\BindingModels\UserEditBindingModel $model){
        $this->authorize('');

        $viewModel = new ProfileInformation();

        try {
            if ($model->getPassword() != $model->getConfirmPassword()){
                throw new \Exception('Empty password or passwords does not match');
            }
            if (UserManager::getInstance()->edit($model)){
                $viewModel->success = 'Edit successful';
                $this->redirect("users/profile");
            }
        } catch (\Exception $e) {
            $userRow = UserManager::getInstance()->getInfo($_SESSION['userId']);
            $user = new UserProfileViewModel(
                $userRow['username'],
                $userRow['password'],
                $userRow['id']
            );
            $viewModel->setUser($user);
            $viewModel->error = $e->getMessage();
        }

        $this->render($viewModel);
        return true;
    }
}