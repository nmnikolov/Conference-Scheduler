<?php
declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Config\AppConfig;
use Framework\Exceptions\ApplicationException;
use Framework\HttpContext\HttpContext;
use Framework\Identity\RoleManager;
use Framework\Identity\UserManager;
use Framework\Models\BindingModels\LoginBindingModel;
use Framework\Models\BindingModels\RegisterBindingModel;
use Framework\Models\BindingModels\UserEditBindingModel;
use Framework\Models\ViewModels\UserProfileViewModel;
use Framework\Models\ViewModels\ChangePasswordViewModel;
use Framework\ViewModels\LoginInformation;
use Framework\ViewModels\RegisterInformation;
use SoftUni\ViewModels\PasswordInformation;
use SoftUni\ViewModels\ProfileInformation;

class UsersController extends  BaseController
{
    /**
     * @NoAction
     * @param HttpContext $context
     */
    public function __construct(HttpContext $context)
    {
        parent::__construct($context);
    }

    /**
     * @NoAction
     */
    private function initLogin(LoginBindingModel $model){
        $userId = UserManager::getInstance()->login($model);
        $this->context->getSession()->userId = $userId;
        $this->context->getIdentity()->setCurrentUser();
        $this->redirect();
    }

    /**
     * @@NotLogged
     */
    public function register(){
        $this->renderDefaultLayout();
    }

    /**
     * @param RegisterBindingModel $model
     * @POST
     * @@NotLogged
     */
    public function registerPst(RegisterBindingModel $model){
        try {
            $userId = UserManager::getInstance()->register($model);
            $roleId = RoleManager::getInstance()->getRoleId(AppConfig::DEFAULT_REGISTRATION_ROLE);
            UserManager::getInstance()->addToRole($userId, $roleId);

            $loginModel = new LoginBindingModel();
            $loginModel->setUsername($model->getUserName());
            $loginModel->setPassword($model->getPassword());
            $this->initLogin($loginModel);
        } catch (ApplicationException $e) {
            $this->redirect("users/register");
        }
    }

    /**
     * @GET
     * @@NotLogged
     */
    public function login(){
        $this->renderDefaultLayout();
    }

    /**
     * @param LoginBindingModel $model
     * @POST
     * @@NotLogged
     */
    public function loginPst(LoginBindingModel $model){
        $this->initLogin($model);
    }

    /**
     * @@Authorize
     */
    public function logout(){
        $this->context->getIdentity()->logout();
        $this->redirect();
    }

    /**
     * @@Authorize
     */
    public function profile(){
        $userProfileViewModel = $this->context->getIdentity()->getCurrentUser();
        $this->renderDefaultLayout($userProfileViewModel);
    }

    /**
     * @param \Framework\Models\BindingModels\UserEditBindingModel $model
     * @@Authorize
     * @POST
     */
    public function profilePst(UserEditBindingModel $model){
        try {
            UserManager::getInstance()->edit($model);
            $this->context->getIdentity()->setCurrentUser();
            $this->redirect("users/profile");
        } catch (ApplicationException $e) {
            $userProfileViewModel = $this->context->getIdentity()->getCurrentUser();
            $this->renderDefaultLayout($userProfileViewModel);
        }
    }

    /**
     * @@Authorize
     */
    public function password(){
        $userProfileViewModel = $this->context->getIdentity()->getCurrentUser();
        $this->renderDefaultLayout($userProfileViewModel);
    }

    /**
     * @param \Framework\Models\BindingModels\ChangePasswordBindingModel $model
     * @@Authorize
     * @POST
     */
    public function passwordPst(\Framework\Models\BindingModels\ChangePasswordBindingModel $model){
        try {
            if (UserManager::getInstance()->changePassword($model)){
                $this->redirect("users/profile");
            }
        } catch (ApplicationException $e) {
            $userProfileViewModel = $this->context->getIdentity()->getCurrentUser();
            $this->renderDefaultLayout($userProfileViewModel);
        }
    }
}