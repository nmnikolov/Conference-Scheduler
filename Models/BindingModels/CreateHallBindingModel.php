<?php

namespace Framework\Models\BindingModels;

class CreateHallBindingModel
{
    /**
     * @Required
     * @MinLength(2)
     * @MaxLength(30)
     * @Display(Hall name)
     */
    private $name;

    /**
     * @Required
     * @Display(Hall capacity)
     */
    private $capacity;

    /**
     * @Required
     * @Display(Venue)
     */
    private $venueId;

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCapacity() : string {
        return $this->capacity;
    }

    /**
     * @param string $capacity
     */
    public function setCapacity(string $capacity) {
        $this->capacity = $capacity;
    }

    /**
     * @return string
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