<?php

namespace Framework\Models\ViewModels;

class AdminVenuesViewModel
{
    /**
     * @var array
     */
    private $venues = [];

    /**
     * AdminVenuesViewModel constructor.
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