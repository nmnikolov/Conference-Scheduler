<?php
declare(strict_types=1);

namespace Framework\HttpContext;

use Framework\Interfaces\HttpCookieInterface;
use Framework\Interfaces\HttpRequestInterface;
use Framework\Interfaces\HttpSessionInterface;
use Framework\Interfaces\HttpUserInterface;

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
     *
     * @var HttpSessionInterface
     */
    private $session;

    private $user;

    /**
     * HttpContext constructor.
     * @param HttpRequestInterface $request
     * @param HttpCookieInterface $cookie
     * @param HttpSessionInterface $session
     * @param HttpUserInterface $user
     */
    private function __construct(HttpRequestInterface $request, HttpCookieInterface $cookie, HttpSessionInterface $session, HttpUserInterface $user) {
        $this->request = $request;
        $this->cookie = $cookie;
        $this->session = $session;
        $this->user = $user;
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
     * @return HttpUserInterface
     */
    public function getIdentity() {
        return $this->user;
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
     * @param HttpUserInterface $user
     * @throws \Exception
     */
    public static function setInstance(HttpRequestInterface $request, HttpCookieInterface $cookie, HttpSessionInterface $session, HttpUserInterface $user){
        if (self::$inst !== null) {
            throw new \Exception("There is already instance for HttpContext");
        }

        self::$inst = new HttpContext($request, $cookie, $session, $user);
    }
}