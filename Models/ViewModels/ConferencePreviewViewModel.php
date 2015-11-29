<?php
declare(strict_types=1);

namespace Framework\Models\ViewModels;

class ConferencePreviewViewModel
{
    private $id;
    private $title;
    private $description;
    private $startTime;
    private $endTime;

    /**
     * ConferencePreviewViewModel constructor.
     * @param int $id
     * @param string $title
     * @param string $description
     * @param string $startTime
     * @param string $endTime
     */
    public function __construct(
            int $id,
            string $title,
            string $description,
            string $startTime,
            string $endTime) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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
}