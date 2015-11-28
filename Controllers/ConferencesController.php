<?php

namespace Framework\Controllers;

use Framework\Exceptions\ApplicationException;
use Framework\Helpers\Helpers;
use Framework\HttpContext\HttpContext;
use Framework\Models\BindingModels\CreateConferenceBindingModel;
use Framework\Models\Conference;
use Framework\Models\ViewModels\CreateConferenceViewModel;
use Framework\Models\ViewModels\EditConferenceViewModel;
use Framework\Models\ViewModels\EditConferenceViewModelViewModel;
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

    }

    public function future(){

    }

    public function past(){

    }

    /**
     * @param int $id
     * @throws ApplicationException
     */
    public function details(int $id){
        $conference = ConferencesRepository::getInstance()->getById($id);
        var_dump($conference);
        exit;
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
                HttpContext::getInstance()->getIdentity()->getCurrentUser()->getId()
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
            $owner,
            $venue,
            $activeVenues,
            []
        );

        $this->renderDefaultLayout($viewModel);
    }

    /**
     * @@Authorize
     */
    public function my(){
        $this->renderDefaultLayout();
    }
}