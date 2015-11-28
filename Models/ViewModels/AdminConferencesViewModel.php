<?php

namespace Framework\Models\ViewModels;

class AdminConferencesViewModel
{
    /**
     * @var array
     */
    private $conferences = [];

    /**
     * AdminConferencesViewModel constructor.
     * @param array $conferences
     */
    public function __construct(array $conferences) {
        $this->conferences = $conferences;
    }

    /**
     * @return array
     */
    public function getConferences() : array {
        return $this->conferences;
    }
}