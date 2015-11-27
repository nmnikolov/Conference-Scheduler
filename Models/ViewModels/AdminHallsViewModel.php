<?php

namespace Framework\Models\ViewModels;

class AdminHallsViewModel
{
    /**
     * @var array
     */
    private $halls = [];

    /**
     * HallViewModel constructor.
     * @param array $halls
     */
    public function __construct(array $halls) {
        $this->halls = $halls;
    }

    /**
     * @return array
     */
    public function getHalls() : array {
        return $this->halls;
    }


}