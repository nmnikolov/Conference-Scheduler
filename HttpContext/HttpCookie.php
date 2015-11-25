<?php
declare(strict_types=1);

namespace Framework\HttpContext;

use Framework\Interfaces\HttpCookieInterface;

class HttpCookie implements HttpCookieInterface
{
    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @param string $key
     * @return CookiePart
     */
    public function __get(string $key) : CookiePart
    {
        if (array_key_exists($key, $this->cookies)) {
            return $this->cookies[$key];
        }
        $cookie = new CookiePart($key);

        return $cookie;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function __set(string $key, string $value)
    {
        $cookie = new CookiePart($key);
        $cookie->$key = $value;
        $this->cookies[$key] = $cookie;
    }

    public function removeCookie(string $key){
        if (array_key_exists($key, $this->cookies)) {
            unset($this->cookies[$key]);
        }
    }
}