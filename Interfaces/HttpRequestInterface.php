<?php
declare(strict_types=1);

namespace Framework\Interfaces;

use Framework\HttpContext\FormPart;

interface HttpRequestInterface
{
    function getForm() : FormPart;
}