<?php

namespace Framework\Models\ViewModels;

class AdminApiViewModel
{
    /**
     * @var array
     */
    private $actions = [];

    /**
     * HallViewModel constructor.
     * @param array $halls
     */
    public function __construct(array $actions) {
        $this->halls = $actions;
    }

    /**
     * @return array
     */
    public function getHalls() : array {
        return $this->halls;
    }
}