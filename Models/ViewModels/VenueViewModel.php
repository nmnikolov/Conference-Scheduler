<?php

namespace Framework\Models\ViewModels;

class VenueViewModel
{
    private $id;
    private $description;
    private $address;
    private $name;

    /**
     * VenueViewModel constructor.
     * @param string $id
     * @param string $description
     * @param string $address
     * @param string $name
     */
    public function __construct(string $id = "", string $name = "", string $description = "", string $address = "") {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getId() : string {
        return $this->id;
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
    public function getAddress() : string {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }
}