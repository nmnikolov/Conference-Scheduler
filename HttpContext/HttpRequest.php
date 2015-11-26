<?php
declare(strict_types=1);

namespace Framework\HttpContext;

use Framework\Interfaces\HttpRequestInterface;

class HttpRequest implements HttpRequestInterface
{
    /**
     * @var FormPart
     */
    private $form = null;

    /**
     * HttpRequest constructor.
     * @param FormPart $form
     */
    public function __construct() {
        $this->form = new FormPart();
    }

    /**
     * @param string $key
     * @return string
     */
    function __get(string $key) : string {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }

        return "";
    }

    /**
     * @return FormPart
     */
    function getForm() : FormPart {
        return $this->form;
    }
}