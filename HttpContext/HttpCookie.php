<?php
declare(strict_types=1);

namespace Framework\HttpContext;

use Framework\Interfaces\HttpCookieInterface;

class HttpCookie implements HttpCookieInterface
{
    public function __get(string $key )
    {
        return $this->$key;
    }

    public function __set(string $key, string $value)
    {
        setcookie($key, $value);
        $this->$key = $value;
    }

    public function delete() {
        var_dump("test");
    }
}