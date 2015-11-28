<?php

namespace Framework\Controllers;

use Framework\Exceptions\ApplicationException;
use Framework\Helpers\Helpers;
use Framework\HttpContext\HttpContext;
use Framework\Models\BindingModels\CreateConferenceBindingModel;
use Framework\Models\Conference;
use Framework\Models\ViewModels\CreateConferenceViewModel;
use Framework\Repositories\ConferencesRepository;

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

        $this->renderDefaultLayout();
    }
}