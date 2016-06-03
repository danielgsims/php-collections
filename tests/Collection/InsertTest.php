<?php

use Collections\Collection;

class InsertTest extends PHPUnit_Framework_TestCase
{
        public function testInsert()
    {
        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));

        $this->c->insert(1, new TestClassA(3));

        $this->assertEquals(3, $this->c->at(1)->getValue());

        $this->setExpectedException("Collections\Exceptions\OutOfRangeException");
        $this->c->insert(100, new TestClassA(5));

        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $this->c->insert(-1, new TestClassA(5));
    }

}
