<?php

namespace Framework\Models;

use DateTime;

class Conference
{
    private $ownerId;
    private $venueId;
    private $title;
    private $description;
    private $startTime;
    private $endTime;

    /**
     * Conference constructor.
     * @param int $ownerId
     * @param int $venueId
     * @param string $title
     * @param string $description
     * @param string $startTime
     * @param string $endTime
     */
    public function __construct(string $title, string $description, string $startTime, string $endTime, int $ownerId, int $venueId = 0) {
        $this->title = $title;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->ownerId = $ownerId;
        $this->venueId = $venueId;
    }

    /**
     * @return int
     */
    public function getOwnerId() : int {
        return $this->ownerId;
    }

    /**
     * @return int
     */
    public function getVenueId() : int {
        return $this->venueId;
    }

    /**
     * @return string|string
     */
    public function getTitle() : string {
        return $this->title;
    }

    /**
     * @return string|string
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
    public function getEndTime() : string{
        return $this->endTime;
    }
}