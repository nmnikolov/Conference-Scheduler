<?php
declare(strict_types=1);

namespace Framework\Models\ViewModels;

class ErrorPageViewModel
{
    private $error = "";

    /**
     * ErrorPageViewModel constructor.
     * @param string $error
     */
    public function __construct(string $error) {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getError() : string {
        return $this->error;
    }
}