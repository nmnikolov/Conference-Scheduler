<?php

namespace Framework\Models\ViewModels;

class AdminCreateHallViewModel
{
    /**
     * @var array
     */
    private $venues = [];

    /**
     * AdminCreateHallViewModel constructor.
     * @param array $venues
     */
    public function __construct(array $venues) {
        $this->venues = $venues;
    }

    /**
     * @return array
     */
    public function getVenues() : array {
        return $this->venues;
    }
}