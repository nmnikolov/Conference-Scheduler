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
     * @param DateTime $startTime
     * @param DateTime $endTime
     */
    public function __construct(int $ownerId, int $venueId, string $title, string $description, DateTime $startTime, DateTime $endTime) {
        $this->ownerId = $ownerId;
        $this->venueId = $venueId;
        $this->title = $title;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * @return int|int
     */
    public function getOwnerId() : int {
        return $this->ownerId;
    }

    /**
     * @return int|int
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
     * @return DateTime
     */
    public function getStartTime() : DateTime {
        return $this->startTime;
    }

    /**
     * @return DateTime
     */
    public function getEndTime() : DateTime{
        return $this->endTime;
    }
}