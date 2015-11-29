<?php
declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Exceptions\ApplicationException;
use Framework\Helpers\Helpers;
use Framework\HttpContext\HttpContext;
use Framework\Models\BindingModels\CreateConferenceBindingModel;
use Framework\Models\BindingModels\EditConferenceBindingModel;
use Framework\Models\Conference;
use Framework\Models\ViewModels\EditConferenceViewModel;
use Framework\Models\ViewModels\MyConferencesViewModel;
use Framework\Models\ViewModels\UserProfileViewModel;
use Framework\Models\ViewModels\VenueViewModel;
use Framework\Repositories\ConferencesRepository;
use Framework\Repositories\VenuesRepository;

class ConferencesController extends BaseController
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
     * @@Authorize
     */
    public function create(){
        $this->renderDefaultLayout();
    }

    public function ongoing(){
        $this->renderDefaultLayout();
    }

    public function future(){
        $this->renderDefaultLayout();
    }

    public function past(){
        $this->renderDefaultLayout();
    }

    /**
     * @@Authorize
     */
    public function participating(){
        $this->renderDefaultLayout();
    }

    /**
     * @param int $id
     * @throws ApplicationException
     */
    public function details(int $id){
        $conference = ConferencesRepository::getInstance()->getById($id);
        $this->renderDefaultLayout();
    }

    /**
     * @@Authorize
     * @POST
     * @param CreateConferenceBindingModel $model
     */
    public function createPst(CreateConferenceBindingModel $model){
        try {
            if (!Helpers::validateDate($model->getStartTime())) {
                throw new ApplicationException("Start time is not a valid date!");
            }

            if (!Helpers::validateDate($model->getEndTime())) {
                throw new ApplicationException("End time is not a valid date!");
            }

            $conference = new Conference(
                $model->getTitle(),
                $model->getDescription(),
                $model->getStartTime(),
                $model->getEndTime(),
                intval(HttpContext::getInstance()->getIdentity()->getCurrentUser()->getId())
            );

            $conferenceId = ConferencesRepository::getInstance()->create($conference);
            $this->redirect("conferences/edit/" . $conferenceId);
        } catch (ApplicationException $e){
            $_SESSION["binding-errors"] = [$e->getMessage()];
            $this->redirect("conferences/create");
        }
    }

    /**
     * @@Authorize
     */
    public function edit(int $id){
        $conference = ConferencesRepository::getInstance()->getById($id);
        if ($conference["ownerId"] !== $this->context->getIdentity()->getCurrentUser()->getId()) {
            throw new ApplicationException("Your are now allowed to edit this conference!");
        }

        $venue = new VenueViewModel();
        if ($conference["venueId"]) {
            $venue = new VenueViewModel(
                $conference["venueId"],
                $conference["venueName"],
                $conference["venueDescription"],
                $conference["venueAddress"]
            );
        }

        $activeVenues = VenuesRepository::getInstance()->getActiveVenues();

        $owner = new UserProfileViewModel(
            $conference["ownerUsername"],
            $conference["ownerId"],
            $conference["ownerFullname"]
        );

        $viewModel = new EditConferenceViewModel(
            intval($conference["id"]),
            $conference["title"],
            $conference["description"],
            $conference["startTime"],
            $conference["endTime"],
            $conference["isActive"] ? TRUE : FALSE,
            $conference["isDismissed"] ? TRUE : FALSE,
            $owner,
            $venue,
            $activeVenues,
            []
        );

        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Authorize
     * @POST
     * @param int $id
     * @param EditConferenceBindingModel $model
     * @throws ApplicationException
     */
    public function editPst(int $id, EditConferenceBindingModel $model){
        try {
            $dbConference = ConferencesRepository::getInstance()->getById($id);
            if ($dbConference["ownerId"] !== $this->context->getIdentity()->getCurrentUser()->getId()) {
                throw new ApplicationException("Your are now allowed to edit this conference!");
            }

            $conference = new Conference(
                $model->getTitle(),
                $model->getDescription(),
                $model->getStartTime(),
                $model->getEndTime(),
                $dbConference["ownerId"],
                $model->getVenueId()
            );

            ConferencesRepository::getInstance()->edit($id, $conference);
            $this->redirect("conferences/details/" . $id);
        } catch (ApplicationException $e){
            $_SESSION["binding-errors"] = [$e->getMessage()];
            $this->redirect("conferences/edit/" . $id);
        }
    }

    /**
     * @@Authorize
     */
    public function my(){
        $userId = $this->context->getIdentity()->getCurrentUser()->getId();
        $userConferences = ConferencesRepository::getInstance()->getUserConferencesPreview(intval($userId));
//        var_dump($userConferences);
        $viewModel = new MyConferencesViewModel($userConferences);
        $this->renderDefaultLayout($viewModel);
    }
}