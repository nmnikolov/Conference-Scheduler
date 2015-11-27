<?php

namespace Framework\Models\BindingModels;

class CreateVenueBindingModel
{
    /**
     * @Required
     * @MinLength(2)
     * @MaxLength(30)
     * @Display(Venue name)
     */
    private $name;

    /**
     * @Required
     * @MinLength(2)
     * @MaxLength(30)
     * @Display(Venue Description)
     */
    private $description;

    /**
     * @Required
     * @MinLength(5)
     * @MaxLength(30)
     * @Display(Venue Address)
     */
    private $address;

    /**
     * @return mixed
     */
    public function getName() {
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
    public function getAddress() : string {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address) {
        $this->address = $address;
    }


}