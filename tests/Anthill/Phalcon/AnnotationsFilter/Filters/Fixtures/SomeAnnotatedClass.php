<?php

namespace Tests\Anthill\Phalcon\AnnotationsFilter\Filters\Fixtures;

class SomeAnnotatedClass
{
    /**
     * @Filter({"email","upper"})
     * @var string
     */
    private $fieldA = "some(one)@exa\mple.com";

    /**
     * @Filter("email")
     * @Filter("upper")
     * @var boolean
     */
    private $fieldB;

    /**
     * @Filter("trim")
     * @var boolean
     */
    private $fieldC;

    /**
     * @return mixed
     */
    public function getFieldA()
    {
        return $this->fieldA;
    }

    /**
     * @return mixed
     */
    public function getExpectedFieldA()
    {
        $filter = new \Phalcon\Filter();
        return $filter->sanitize($this->fieldA, ['email', 'upper']);
    }

    /**
     * @return mixed
     */
    public function getFieldB()
    {
        return $this->fieldB;
    }

    /**
     * @return mixed
     */
    public function getExpectedFieldB()
    {
        $filter = new \Phalcon\Filter();
        $value = $filter->sanitize($this->fieldB, 'email');
        return $filter->sanitize($value, 'upper');
    }

    /**
     * @return mixed
     */
    public function getFieldC()
    {
        return $this->fieldC;
    }

    /**
     * @return mixed
     */
    public function getExpectedFieldC()
    {
        return null;
    }
}