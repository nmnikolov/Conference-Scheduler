<?php
declare(strict_types=1);

namespace Framework\HttpContext;

class CookiePart
{
    /**
     * @var string
     */
    private $name;

    /**
     * CookiePart constructor.
     * @param string $cookieName
     */
    public function __construct(string $cookieName) {
        $this->name = $cookieName;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function __set(string $name, string $value) {
        setcookie($name, $value);
    }

    /**
     * @return string
     */
    public function __toString() : string {
        if(isset($_COOKIE[$this->name])) {
            return $_COOKIE[$this->name];
        }

        return "";
    }

    public function delete(){
        if (isset($_COOKIE[$this->name])) {
            unset($_COOKIE[$this->name]);
        };
    }
}