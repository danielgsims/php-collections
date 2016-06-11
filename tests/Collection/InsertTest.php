<?php

use Collections\Collection;

class InsertTest extends PHPUnit_Framework_TestCase
{
        public function testInsert()
    {
        $c = new Collection('TestClassA');
        $c = $c->add(new TestClassA(1));
        $c = $c->add(new TestClassA(2));

        $result = $c->insert(1, new TestClassA(3));

        $this->assertEquals(3, $result->at(1)->getValue());

        $this->setExpectedException("Collections\Exceptions\OutOfRangeException");
        $c->insert(100, new TestClassA(5));

        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $c->insert(-1, new TestClassA(5));
    }

}
