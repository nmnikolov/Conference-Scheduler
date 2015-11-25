<?php
declare(strict_types=1);

namespace Framework\Exceptions;

use Framework\Config\AppConfig;

class ApplicationException extends \Exception
{
    private $redirectUrl;

    /**
     * ApplicationException constructor.
     * @param string $message
     * @param string $redirectUrl
     * @param int $code
     */
    public function __construct(string $message, string $redirectUrl = "error", int $code = 0) {
        $this->redirectUrl = $redirectUrl;

        parent::__construct($message, $code);
    }

    /**
     * @return string
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }
}