<?php
declare(strict_types=1);

namespace Framework\Annotations;

abstract class AbstractAnnotation implements AnnotationInterface
{
    /**
     * AbstractAnnotation constructor.
     */
    protected function __construct() {
    }

    public abstract function dispatch();
}