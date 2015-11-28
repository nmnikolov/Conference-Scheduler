<?php

namespace Framework\Controllers;

use Framework\Exceptions\ApplicationException;
use Framework\HttpContext\HttpContext;
use Framework\Identity\RoleManager;
use Framework\Identity\UserManager;
use Framework\Models\BindingModels\ChangeRoleBindingModel;
use Framework\Models\BindingModels\CreateHallBindingModel;
use Framework\Models\BindingModels\CreateVenueBindingModel;
use Framework\Models\Hall;
use Framework\Models\Venue;
use Framework\Models\ViewModels\AdminChangeRoleViewModel;
use Framework\Models\ViewModels\AdminConferencesViewModel;
use Framework\Models\ViewModels\AdminCreateHallViewModel;
use Framework\Models\ViewModels\AdminHallsViewModel;
use Framework\Models\ViewModels\AdminUsersViewModel;
use Framework\Models\ViewModels\AdminVenuesViewModel;
use Framework\Repositories\ConferencesRepository;
use Framework\Repositories\HallsRepository;
use Framework\Repositories\UsersRepository;
use Framework\Repositories\VenuesRepository;

class AdminController extends BaseController
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
     * @@Admin
     */
    public function index(){
        $this->renderDefaultLayout();
    }

    /**
     * @@Admin
     */
    public function users(){
        $users = UsersRepository::getInstance()->getAllUsers();
        $viewModel = new AdminUsersViewModel($users);
        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Admin
     * @Route(admin/users/{int}/role/edit)
     * @param int $id
     * @throws ApplicationException
     */
    public function changeRole(int $id){
        if (intval($this->context->getIdentity()->getCurrentUser()->getId()) === $id) {
            throw new ApplicationException("Cannot change your own role!");
        }

        $user = UserManager::getInstance()->getUserInfo($id);
        $role = UserManager::getInstance()->getUserRole($id);
        $roles = RoleManager::getInstance()->getAllRoles();

        $viewModel = new AdminChangeRoleViewModel($user, $role, $roles);

        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Admin
     * @Route(admin/users/{int}/role/editPst)
     * @POST
     * @param int $id
     * @param ChangeRoleBindingModel $model
     * @throws ApplicationException
     */
    public function changeRolePst(int $id, ChangeRoleBindingModel $model){
        if (intval($this->context->getIdentity()->getCurrentUser()->getId()) === $id) {
            throw new ApplicationException("Cannot change your own role!");
        }

        try{
            if (!UserManager::getInstance()->removeUserRoles($id)) {
                throw new ApplicationException("Couldn't change user role.");
            }
            UserManager::getInstance()->addToRole($id, $model->getNewRole());
            $this->redirect("admin/users");
        } catch (ApplicationException $e){
            $_SESSION["binding-errors"] = [$e->getMessage()];
            $this->redirect("admin/users/". $id . "/role/edit");
        }
    }

    /**
     * @@Admin
     */
    public function conferences(){
        $conferences = ConferencesRepository::getInstance()->getAllConferences();
        $viewModel = new AdminConferencesViewModel($conferences);
        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Admin
     * @Route(admin/venues/all)
     */
    public function venues(){
        $venues = VenuesRepository::getInstance()->getAllVenues();
        $viewModel = new AdminVenuesViewModel($venues);
        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Admin
     * @Route(admin/venues/create)
     */
    public function createVenue(){
        $this->renderDefaultLayout();
    }

    /**
     * @param CreateVenueBindingModel $model
     * @@Admin
     * @Route(admin/venues/createPst)
     * @POST
     */
    public function createVenuePst(CreateVenueBindingModel $model){
        try{
            $venue = new Venue(
                $model->getName(),
                $model->getDescription(),
                $model->getAddress()
            );
            VenuesRepository::getInstance()->create($venue);
            $this->redirect("admin/venues");
        } catch (ApplicationException $e){
            $_SESSION["binding-errors"] = [$e->getMessage()];
            $this->redirect("admin/venues/create");
        }
    }

    /**
     * @@Admin
     * @POST
     * @Routes(admin/venues/deactivate/{int})
     * @param int $id
     */
    public function deactivateVenuePst(int $id){

    }

    /**
     * @@Admin
     */
    public function halls(){
        $halls = HallsRepository::getInstance()->getAllHalls();
        $viewModel = new AdminHallsViewModel($halls);
        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Admin
     * @Route(admin/halls/create)
     */
    public function createHall(){
        $venues = VenuesRepository::getInstance()->getActiveVenuesPreview();
        $viewModel = new AdminCreateHallViewModel($venues);
        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Admin
     * @Route(admin/halls/createPst)
     * @POST
     * @param CreateHallBindingModel $model
     */
    public function createHallPst(CreateHallBindingModel $model){
        try{
            $hall = new Hall(
                $model->getName(),
                $model->getCapacity(),
                $model->getVenueId()
            );
            HallsRepository::getInstance()->create($hall);
            $this->redirect("admin/halls");
        } catch (ApplicationException $e){
            $_SESSION["binding-errors"] = [$e->getMessage()];
            $this->redirect("admin/halls/create");
        }
    }
}