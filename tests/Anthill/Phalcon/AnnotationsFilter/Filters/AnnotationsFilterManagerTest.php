<?php

namespace Tests\Anthill\Phalcon\AnnotationsFilter;

use Phalcon\Annotations\Adapter\Memory as MemoryAnnotator;
use Phalcon\Filter;
use Anthill\Phalcon\AnnotationsFilter\Filters\AnnotationFilterManager;
use Tests\Anthill\Phalcon\AnnotationsFilter\Filters\Fixtures\SomeAnnotatedClass;

class AnnotationsFilterManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $filteredClass = new SomeAnnotatedClass();

        $annotator = new AnnotationFilterManager(new MemoryAnnotator(),new Filter());
        $annotator->filter($filteredClass);

        $this->assertEquals($filteredClass->getFieldA(),$filteredClass->getExpectedFieldA());
        $this->assertEquals($filteredClass->getFieldB(),$filteredClass->getExpectedFieldB());
        $this->assertEquals($filteredClass->getFieldC(),$filteredClass->getExpectedFieldC());
    }
}