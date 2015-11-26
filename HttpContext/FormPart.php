<?php

namespace Framework\HttpContext;

class FormPart
{
    /**
     * @param string $key
     * @return string
     */
    function __get(string $key) : string {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }

        return "";
    }
}