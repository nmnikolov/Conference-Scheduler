<?php
declare(strict_types=1);

namespace Framework\HttpContext;

use Framework\Interfaces\HttpSessionInterface;

class HttpSession implements HttpSessionInterface
{
    /**
     * @var array
     */
    private $sessions = [];

    /**
     * @param string $key
     * @return SessionPart
     */
    public function __get(string $key) {
        if (array_key_exists($key, $this->sessions)) {
            return $this->sessions[$key];
        }
        $session = new SessionPart($key);

        return $session;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function __set(string $key, string $value) {
        $session = new SessionPart($key);
        $session->$key = $value;
        $this->sessions[$key] = $session;
    }
}