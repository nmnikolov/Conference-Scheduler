<?php
declare(strict_types=1);

namespace Framework\HttpContext;

use Framework\Interfaces\HttpCookieInterface;
use Framework\Interfaces\HttpRequestInterface;
use Framework\Interfaces\HttpSessionInterface;

class HttpContext
{
    private static $inst = null;

    /**
     * @var HttpRequestInterface
     */
    private $request;

    /**
     * @var HttpCookieInterface
     */
    private $cookie;

    /**
     * @var HttpSessionInterface
     */
    private $session;

    /**
     * HttpContext constructor.
     * @param HttpRequestInterface $request
     * @param HttpCookieInterface $cookie
     * @param HttpSessionInterface $session
     */
    private function __construct(HttpRequestInterface $request, HttpCookieInterface $cookie, HttpSessionInterface $session) {
        $this->request = $request;
        $this->cookie = $cookie;
        $this->session = $session;
    }

    /**
     * @return HttpRequestInterface
     */
    public function getRequest() : HttpRequestInterface {
        return $this->request;
    }

    /**
     * @return HttpCookieInterface
     */
    public function getCookies() : HttpCookieInterface {
        return $this->cookie;
    }

    /**
     * @return HttpSessionInterface
     */
    public function getSession() : HttpSessionInterface {
        return $this->session;
    }

    /**
     * @return HttpContext
     * @throws \Exception
     */
    public static function getInstance() : HttpContext{
        if (self::$inst === null) {
            throw new \Exception("HttpContext: object reference not set to an instance of an object");
        }

        return self::$inst;
    }

    /**
     * @param HttpRequestInterface $request
     * @param HttpCookieInterface $cookie
     * @param HttpSessionInterface $session
     * @throws \Exception
     */
    public static function setInstance(HttpRequestInterface $request, HttpCookieInterface $cookie, HttpSessionInterface $session){
        if (self::$inst !== null) {
            throw new \Exception("There is already instance for HttpContext");
        }

        self::$inst = new HttpContext($request, $cookie, $session);
    }
}