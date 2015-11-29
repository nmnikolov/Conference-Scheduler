<?php
declare(strict_types=1);

namespace Framework\Models\ViewModels;

class MyConferencesViewModel
{
    /**
     * @var array
     */
    private $conferences;

    /**
     * MyConferencesViewModel constructor.
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