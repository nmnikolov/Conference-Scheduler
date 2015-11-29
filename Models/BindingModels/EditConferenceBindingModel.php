<?php
declare(strict_types=1);

namespace Framework\Models\BindingModels;

class EditConferenceBindingModel
{
    /**
     * @Required
     * @MinLength(2)
     * @MaxLength(255)
     * @Display(Conference title)
     */
    private $title;

    /**
     * @Required
     * @MinLength(2)
     * @Display(Conference description)
     */
    private $description;

    /**
     * @Required
     * @Display(Start time)
     */
    private $startTime;

    /**
     * @Required
     * @Display(End time)
     */
    private $endTime;

    /**
     * @Required
     */
    private $venueId;

    /**
     * @return string
     */
    public function getTitle() : string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription() : string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description) {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getStartTime() : string {
        return $this->startTime;
    }

    /**
     * @param string $startTime
     */
    public function setStartTime(string $startTime) {
        $this->startTime = $startTime;
    }

    /**
     * @return string
     */
    public function getEndTime() : string {
        return $this->endTime;
    }

    /**
     * @param string $endTime
     */
    public function setEndTime(string $endTime) {
        $this->endTime = $endTime;
    }

    /**
     * @return string id
     */
    public function getVenueId() : string {
        return $this->venueId;
    }

    /**
     * @param string $venueId
     */
    public function setVenueId(string $venueId) {
        $this->venueId = $venueId;
    }


}