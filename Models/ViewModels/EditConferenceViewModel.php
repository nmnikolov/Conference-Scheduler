<?php

namespace Framework\Models\ViewModels;

class EditConferenceViewModel
{
    private $id;
    private $title;
    private $description;
    private $startTime;
    private $endTime;
    private $isActive;
    private $owner;
    private $venue;
    private $venues;
    private $lectures = [];

    /**
     * EditConferenceViewModelViewModel constructor.
     * @param int|int $id
     * @param string|string $title
     * @param string|string $description
     * @param string|string $startTime
     * @param string|string $endTime
     * @param bool|bool $isActive
     * @param UserProfileViewModel $owner
     * @param VenueViewModel $venue
     * @param array $venues
     * @param array $lectures
     */
    public function __construct(
            int $id,
            string $title,
            string $description,
            string $startTime,
            string $endTime,
            bool $isActive,
            UserProfileViewModel $owner,
            VenueViewModel $venue,
            array $venues,
            array $lectures = []) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->isActive = $isActive;
        $this->owner = $owner;
        $this->venue = $venue;
        $this->venues = $venues;
        $this->lectures = $lectures;
    }

    /**
     * @return int
     */
    public function getId() : int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle() : string {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription() : string {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getStartTime() : string {
        return $this->startTime;
    }

    /**
     * @return string
     */
    public function getEndTime() : string {
        return $this->endTime;
    }

    /**
     * @return bool
     */
    public function getIsActive() : bool {
        return $this->isActive;
    }

    /**
     * @return UserProfileViewModel
     */
    public function getOwner() : UserProfileViewModel {
        return $this->owner;
    }

    /**
     * @return VenueViewModel
     */
    public function getVenue() : VenueViewModel {
        return $this->venue;
    }

    /**
     * @return array
     */
    public function getVenues() : array {
        return $this->venues;
    }

    /**
     * @return array
     */
    public function getLectures() : array {
        return $this->lectures;
    }
}