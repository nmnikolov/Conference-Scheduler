<?php

namespace Framework\Models;

class Hall
{
    private $name;
    private $capacity;
    private $venue_id;

    /**
     * Conference constructor.
     * @param string $name
     * @param int $capacity
     * @param int $venue_id
     */
    public function __construct(string $name, int $capacity, int $venue_id) {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->venue_id = $venue_id;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCapacity() : int {
        return $this->capacity;
    }

    /**
     * @return int
     */
    public function getVenueId() : int {
        return $this->venue_id;
    }
}