<?php

namespace Framework\Models;

class Venue
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $address;

    /**
     * Venue constructor.
     * @param string $name
     * @param string $description
     * @param string $address
     */
    public function __construct(string $name, string $description, string $address) {
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
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
}