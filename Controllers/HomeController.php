<?php
declare(strict_types=1);

namespace Framework\Controllers;

use Framework\HttpContext\HttpContext;

class HomeController extends BaseController
{
    /**
     * @NoAction
     * @param HttpContext $context
     */
    public function __construct(HttpContext $context)
    {
        parent::__construct($context);
    }

    public function index()
    {
        $this->renderDefaultLayout();

    }

    /**
     * @param int $a
     * @param string $b
     * @@Authorize
     * @Route(muhaha/ttt/{int}/aac/{str})
     * @POST
     * @GET
     */
    public function test1(int $a, string $b){
        $this->renderDefaultLayout();
    }

    /**
     * @return bool
     * @@Authorize
     * @Route(test/test)
     * @POST
     * @GET
     */
    public function test2(){

    }
}