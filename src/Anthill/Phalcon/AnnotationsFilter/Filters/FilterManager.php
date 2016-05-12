<?php

namespace Anthill\Phalcon\AnnotationsFilter\Filters;

abstract class FilterManager
{
    abstract public function filter($class);
}